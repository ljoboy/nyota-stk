<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->genlib->checkLogin();

        $this->genlib->superOnly();

        $this->load->model(['supplierModel', 'item']);
    }

    public function index()
    {
        $items = $this->item->getAll();
        $data['pageContent'] = $this->load->view('suppliers', compact('items'), TRUE);
        $data['pageTitle'] = "Fournisseurs";

        $this->load->view('main', $data);
    }

    public function laad_()
    {
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "id";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";

        $this->load->library('pagination');

        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration

        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $data['allSuppliers'] = $this->supplierModel->getAll($orderBy, $orderFormat, $start, $limit);
        $data['items'] = $this->item->getAll();
        $data['itemSuppliers'] = $this->supplierModel->getAllItemSupplier();
        $totalsuppliers = count($data['allSuppliers'] ?? []);
        $config = $this->genlib->setPaginationConfig($totalsuppliers, "supplier/laad_", $limit, ['class' => 'lnp']);

        $this->pagination->initialize($config);//initialize the library class

        //get all couts from db

        $data['range'] = ($totalsuppliers > 0) ? ($start + 1) . "-" . ($start + count($data['allSuppliers'])) . " sur " . $totalsuppliers : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;

        $json['suppliersTable'] = $this->load->view('suppliers/supplierslist', $data, TRUE);//get view with populated couts table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /**
     * To add new Supplier
     */
    public function add()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('name', 'Nom', ['required', 'trim', 'max_length[20]', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('address', 'Adresse', ['trim', 'ucfirst']);
        $this->form_validation->set_rules('email', 'E-mail', ['trim', 'valid_email']);
        $this->form_validation->set_rules('phone_number', 'Téléphone', ['trim']);
        $this->form_validation->set_rules('items[]', 'Articles', ['trim', 'numeric']);

        if ($this->form_validation->run() !== FALSE) {
            /**
             * insert info into db
             * function header: add($nom, $description)
             */
            $this->db->trans_start();//start transaction
            $inserted = $this->supplierModel->add(set_value('name'), set_value('phone_number'), set_value('email'), set_value('address'));
            $this->supplierModel->setItemSupplier($inserted, $this->input->post('items'));
            $this->db->trans_complete();

            $json = $inserted ? ['status' => 1, 'msg' => "Fournisseur enregistrée avec succès"] : ['status' => 0, 'msg' => "Oops ! Une erreur inattendue. Veuillez contacter l'administrateur."];
        } else {
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /**
     * To update Supplier
     */
    public function update()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('name', 'Nom', ['required', 'trim', 'max_length[20]', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('address', 'Adresse', ['trim', 'ucfirst']);
        $this->form_validation->set_rules('email', 'E-mail', ['trim', 'valid_email']);
        $this->form_validation->set_rules('phone_number', 'Téléphone', ['trim']);
        $this->form_validation->set_rules('items[]', 'Articles', ['trim', 'numeric']);

        if ($this->form_validation->run() !== FALSE) {
            /**
             * update info into db
             * function header: edit($supplier_id, $nom, $description)
             */
            $supplier_id = $this->input->post('supplierId', TRUE);

            $updated = $this->supplierModel->edit(set_value('name'), set_value('phone_number'), set_value('email'), set_value('address'));

            $json = $updated ? ['status' => 1, 'msg' => "Infos mise à jour avec succès"] : ['status' => 0, 'msg' => "Oops ! Erreur inattendue. Contacter l'Utilisateur svp !"];
        } else {
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /**
     * To delete Supplier
     */
    public function delete()
    {
        $this->genlib->ajaxOnly();

        $supplier_id = $this->input->post('_aId');
        if ($supplier_id){
            $done = $this->db->where('id', $supplier_id)->delete('suppliers');
            if ($done){
                $this->supplierModel->deleteItemSuppliers($supplier_id);
            }
        }


        $json['status'] = $done ? 1 : 0;
        $json['_aId'] = $supplier_id;

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}