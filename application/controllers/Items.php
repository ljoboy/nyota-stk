<?php

defined('BASEPATH') or exit('');

class Items extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->genlib->checkLogin();

        $this->load->model(['item']);

        $this->load->model(['category_model']);
    }

    /**
     *
     */
    public function index()
    {
        $categories = $this->category_model->getAll();
        $data['pageContent'] = $this->load->view('items/items', compact('categories'), true);
        $data['pageTitle'] = "Articles";

        $this->load->view('main', $data);
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    /**
     * "lilt" = "load Items List Table"
     */
    public function lilt()
    {
        $this->genlib->ajaxOnly();

        $this->load->helper('text');

        //set the sort order
        $orderBy = $this->input->get('orderBy', true) ? $this->input->get('orderBy', true) : "name";
        $orderFormat = $this->input->get('orderFormat', true) ? $this->input->get('orderFormat', true) : "DESC";

        //count the total number of items in db
        $totalItems = $this->db->count_all('items');

        $this->load->library('pagination');

        $pageNumber = $this->uri->segment(
            3,
            0
        );//set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', true) ? $this->input->get('limit', true) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration

        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig(
            $totalItems,
            "items/lilt",
            $limit,
            ['onclick' => 'return lilt(this.href);']
        );

        $this->pagination->initialize($config);//initialize the library class

        //get all items from db
        $data['allItems'] = $this->item->getAll($orderBy, $orderFormat, $start, $limit);
        $data['categories'] = $this->category_model->getAll();
        $data['itemCategories'] = $this->category_model->getAllItemCategories();
        $data['range'] = $totalItems > 0 ? "Afficher " . ($start + 1) . "-" . ($start + count(
                    $data['allItems']
                )) . " sur " . $totalItems : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;
        $data['cum_total'] = $this->item->getItemsCumTotal();
        $data['critic_items'] = $this->item->getCriticItem();

        $json['itemsListTable'] = $this->load->view(
            'items/itemslisttable',
            $data,
            true
        );//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    public function add()
    {
        $this->genlib->ajaxOnly();

        $this->genlib->superOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules(
            'itemName',
            'Item name',
            ['required', 'trim', 'max_length[80]', 'is_unique[items.name]',],
            ['required' => "Champ obligatoire"]
        );
        $this->form_validation->set_rules(
            'itemQuantity',
            'Item quantity',
            ['required', 'trim', 'numeric'],
            ['required' => "Champ obligatoire"]
        );
        $this->form_validation->set_rules(
            'itemPrice',
            'Item Price',
            ['required', 'trim', 'numeric'],
            ['required' => "Champ obligatoire"]
        );
        $this->form_validation->set_rules(
            'itemCode',
            'Code Article',
            ['required', 'trim', 'max_length[20]', 'is_unique[items.code]'],
            ['required' => "Champ obligatoire", 'is_unique' => "Il existe un article portant ce code"]
        );
        $this->form_validation->set_rules(
            'stockMin',
            'Stock Minimum',
            ['required', 'trim', 'numeric'],
            ['required' => "Champ obligatoire"]
        );

        if ($this->form_validation->run() !== false) {
            $this->db->trans_start();//start transaction

            /**
             * insert info into db
             * function header: add($itemName, $itemQuantity, $itemPrice, $itemDescription, $itemCode)
             */
            $insertedId = $this->item->add(
                set_value('itemName'),
                set_value('itemQuantity'),
                set_value('itemPrice'),
                set_value('itemDescription'),
                set_value('itemCode'),
                set_value('stockMin')
            );
            if (set_value('itemCategories')) {
                $this->category_model->setItemCategory(set_value('itemCategories'), $insertedId);
            }


            $itemName = set_value('itemName');
            $itemQty = set_value('itemQuantity');
            $itemPrice = "USD" . number_format(set_value('itemPrice'), 2);
//            $stockMin = set_value('stockMin');

            //insert into eventlog
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $desc = "Ajout de {$itemQty} unités de '{$itemName}' avec un prix unitaire de {$itemPrice} dans le stock";

            $insertedId ? $this->genmod->addevent(
                "Création d'un nouveau article",
                $insertedId,
                $desc,
                "items",
                $this->session->admin_id
            ) : "";

            $this->db->trans_complete();

            $json = $this->db->trans_status() !== false ? [
                'status' => 1,
                'msg' => "Article ajouter avec succès"
            ] : ['status' => 0, 'msg' => "Oops ! Erreur inattendue du côté serveur. Contactez l'admin svp"];
        } else {
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires vides ou mal remplis";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     * Primarily used to check whether an item already has a particular random code being generated for a new item
     * @param string $selColName
     * @param string $whereColName
     * @param string $colValue
     */
    public function gettablecol(string $selColName, string $whereColName, string $colValue)
    {
        $a = $this->genmod->gettablecol('items', $selColName, $whereColName, $colValue);

        $json['status'] = $a ? 1 : 0;
        $json['colVal'] = $a;

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    /**
     *
     */
    public function gcoandqty()
    {
        $json['status'] = 0;

        $itemCode = $this->input->get('_iC', true);

        if ($itemCode) {
            $item_info = $this->item->getItemInfo(['code' => $itemCode], ['quantity', 'unitPrice', 'description']);

            if ($item_info) {
                $json['availQty'] = (int)$item_info->quantity;
                $json['unitPrice'] = $item_info->unitPrice;
                $json['description'] = $item_info->description;
                $json['status'] = 1;
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    public function updatestock()
    {
        $this->genlib->ajaxOnly();

        $this->genlib->superOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules(
            '_iId',
            'Item ID',
            ['required', 'trim', 'numeric'],
            ['required' => "Champ obligatoire"]
        );
        $this->form_validation->set_rules(
            '_upType',
            'Update type',
            ['required', 'trim', 'in_list[newStock,deficit]'],
            ['required' => "Champ obligatoire"]
        );
        $this->form_validation->set_rules(
            'qty',
            'Quantity',
            ['required', 'trim', 'numeric'],
            ['required' => "Champ obligatoire"]
        );
        $this->form_validation->set_rules('min', 'Stock Minimum', ['trim', 'numeric']);
        $this->form_validation->set_rules(
            'desc',
            'Update Description',
            ['required', 'trim'],
            ['required' => "Champ obligatoire"]
        );

        if ($this->form_validation->run() !== false) {
            //update stock based on the update type
            $updateType = set_value('_upType');
            $itemId = set_value('_iId');
            $qty = set_value('qty');
            $desc = set_value('desc');
//            $min = set_value('min');

            $this->db->trans_start();

            $updated = $updateType === "deficit" ? $this->item->deficit($itemId, $qty, $desc) : $this->item->newstock(
                $itemId,
                $qty,
                $desc
            );

            //add event to log if successful
            $stockUpdateType = $updateType === "déficit" ? "Déficite" : "Nouveau Stock";

            $event = "Mise à jour du stock ($stockUpdateType)";

            $action = $updateType === "deficit" ? "enlever au" : "ajouter au";//action that happened

            $eventDesc = "<p>{$qty} unités de {$this->genmod->gettablecol('items', 'name', 'id', $itemId)} ont été {$action} stock</p>
                Raison : <p>{$desc}</p>";

            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $updated ? $this->genmod->addevent($event, $itemId, $eventDesc, "items", $this->session->admin_id) : "";

            $this->db->trans_complete();//end transaction

            $json['status'] = $this->db->trans_status() !== false ? 1 : 0;
            $json['msg'] = $updated ? "Stock mise à jour avec succès" : "Impossible de mettre à jour le stock. Réessayez plus tard svp";
        } else {
            $json['status'] = 0;
            $json['msg'] = "Un ou plusieurs champs obligatoires vides ou mal remplis";
            $json = $this->form_validation->error_array();
        }


        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */

    public function edit()
    {
        $this->genlib->ajaxOnly();

        $this->genlib->superOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('_iId', 'Item ID', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules(
            'itemName',
            'Nom Article',
            [
                'required',
                'trim',
                'callback_crosscheckName[' . $this->input->post('_iId', true) . ']'
            ],
            ['required' => 'Champ obligatoire']
        );
        $this->form_validation->set_rules(
            'itemCode',
            'Code Article',
            [
                'required',
                'trim',
                'callback_crosscheckCode[' . $this->input->post('_iId', true) . ']'
            ],
            ['required' => 'Champ obligatoire']
        );
        $this->form_validation->set_rules('itemPrice', 'Item Prix Unitaire', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('minStock', 'Stock Minimum', ['trim', 'numeric']);
        $this->form_validation->set_rules('itemDesc', 'Item Description', ['trim']);

        if ($this->form_validation->run() !== false) {
            $itemId = set_value('_iId');
            $itemDesc = set_value('itemDesc');
            $itemPrice = set_value('itemPrice');
            $itemName = set_value('itemName');
            $itemCode = $this->input->post('itemCode', true);
            $itemCategories = set_value('itemCategories');
            $stockMin = set_value('stockMin');

            //update item in db
            $updated = $this->item->edit($itemId, $itemName, $itemDesc, $itemPrice, $stockMin);

            $this->category_model->updateItemCategory($itemCategories, $itemId);
            $json['status'] = $updated ? 1 : 0;

            //add event to log
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $desc = "Le détails de l'article avec le code '$itemCode' ont été mise à jour";

            $this->genmod->addevent("Mise à jour de l'article", $itemId, $desc, 'items', $this->session->admin_id);
        } else {
            $json['status'] = 0;
            $json = $this->form_validation->error_array();
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */

    public function crosscheckName($itemName, $itemId): bool
    {
        //check db to ensure name was previously used for the item we are updating
        $itemWithName = $this->genmod->getTableCol('items', 'id', 'name', $itemName);

        //if item name does not exist or it exist but it's the name of current item
        if (!$itemWithName || ($itemWithName == $itemId)) {
            return true;
        } else {//if it exist
            $this->form_validation->set_message('crosscheckName', 'Il y a un article avec ce nom');

            return false;
        }
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     *
     * @param $item_code
     * @param $item_id
     * @return boolean
     */
    public function crosscheckCode($item_code, $item_id): bool
    {
        //check db to ensure item code was previously used for the item we are updating
        $item_with_code = $this->genmod->getTableCol('items', 'id', 'code', $item_code);

        //if item code does not exist or it exist but it's the code of current item
        if (!$item_with_code || ($item_with_code == $item_id)) {
            return true;
        } else {//if it exist
            $this->form_validation->set_message('crosscheckCode', 'Il y a un article avec ce code');

            return false;
        }
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    public function delete()
    {
        $this->genlib->ajaxOnly();

        $this->genlib->superOnly();

        $json['status'] = 0;
        $item_id = $this->input->post('i', true);

        if ($item_id) {
            $this->db->where('id', $item_id)->delete('items');

            $json['status'] = 1;
        }

        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /**
     * Genere un xlsx
     */
    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "articles.xls";
        $judul = "articles";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Nom");
        xlsWriteLabel($tablehead, $kolomhead++, "Code");
        xlsWriteLabel($tablehead, $kolomhead++, "Description");
        xlsWriteLabel($tablehead, $kolomhead++, "Prix Unitaire");
        xlsWriteLabel($tablehead, $kolomhead++, "Quantite");
        xlsWriteLabel($tablehead, $kolomhead++, "Date ajout");
        xlsWriteLabel($tablehead, $kolomhead++, "Modifie le");

        $items = $this->item->getAll();

        foreach ($items as $data) {
            $kolombody = 0;

            //changer xlsWriteLabel en xlsWriteNumber pour les colonnes numériques
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->name);
            xlsWriteLabel($tablebody, $kolombody++, $data->code);
            xlsWriteLabel($tablebody, $kolombody++, $data->description);
            xlsWriteNumber($tablebody, $kolombody++, $data->unitPrice);
            xlsWriteNumber($tablebody, $kolombody++, $data->quantity);
            xlsWriteLabel($tablebody, $kolombody++, $data->dateAdded);
            xlsWriteLabel($tablebody, $kolombody++, $data->lastUpdated);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }
}
