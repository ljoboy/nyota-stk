<?php
defined('BASEPATH') OR exit('');

class Couts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->genlib->checkLogin();

        $this->genlib->superOnly();

        $this->load->model(['couts_model']);
    }


    public function index()
    {
        $data['pageContent'] = $this->load->view('couts', '', TRUE);
        $data['pageTitle'] = "Couts";

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
     * lac_ = "Load all couts"
     */
    public function laad_()
    {
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "date_sortie";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";

        //count the total couts in db
        $totalcouts = $this->couts_model->getCount();

        $this->load->library('pagination');

        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration

        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalcouts, "couts/laad_", $limit, ['class' => 'lnp']);

        $this->pagination->initialize($config);//initialize the library class

        //get all couts from db
        $data['allcouts'] = $this->couts_model->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = ($totalcouts > 0) ? ($start + 1) . "-" . ($start + count($data['allcouts'])) . " sur " . $totalcouts : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;

        $json['coutsTable'] = $this->load->view('couts/coutslist', $data, TRUE);//get view with populated couts table

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
     * To add new couts
     */
    public function add()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('montant', 'Montant', ['required', 'trim'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('motif', 'Motif', ['required', 'trim', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('author', 'Auteur', ['required'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('date_sortie', 'Date de Sortie', ['required'], ['required' => "Champ obligatoire"]);

        if ($this->form_validation->run() !== FALSE) {
            /**
             * insert info into db
             * function header: add($cust_name, $cust_tel1, $cust_tel2, $cust_email, $cust_gender,$cust_adresse)
             */
            $inserted = $this->couts_model->add(set_value('montant'), set_value('motif'), set_value('author'), set_value('date_sortie'));


            $json = $inserted ? ['status' => 1, 'msg' => "Coût enregistré avec succès"] : ['status' => 0, 'msg' => "Oops ! Une erreur inattendue. Veuillez contacter l'administrateur."];
        } else {
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
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
     *
     */
    public function update()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('montantEdit', 'Montant', ['required', 'trim'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('motifEdit', 'Motif', ['required', 'trim', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('authorEdit', 'Auteur', ['required', 'trim'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('date_sortieEdit', 'Date de Sortie', ['required'], ['required' => "Champ obligatoire"]);

        print_r($this->form_validation->run());

        if ($this->form_validation->run() !== FALSE) {
            /**
             * update info in db
             * function header: update($cust_id, $cust_name, $cust_tel1, $cust_tel2, $cust_email, $cust_gender,$cust_adresse)
             */
            $couts_id = $this->input->post('coutId', TRUE);

            $updated = $this->couts_model->update($couts_id, set_value('montantEdit'), set_value('motifEdit'), set_value('authorEdit'), set_value('date_sortieEdit'));


            $json = $updated ? ['status' => 1, 'msg' => "Infos mise à jour avec succès"] : ['status' => 0, 'msg' => "Oops ! Erreur inattendue. Contacter l'administrateur svp !"];
        } else {
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
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

    public function delete()
    {
        $this->genlib->ajaxOnly();

        $couts_id = $this->input->post('_aId');
        $new_value = $this->genmod->getTableCol('couts', 'deleted', 'coutsId', $couts_id) == 1 ? 0 : 1;

        $done = $this->couts_model->delete($couts_id, $new_value);

        $json['status'] = $done ? 1 : 0;
        $json['_nv'] = $new_value;
        $json['_aId'] = $couts_id;

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
     * Genere un xlsx
     */
    public function excel()
    {

//        var_dump($this->couts_model->get_all());die;
        $this->load->helper('exportexcel');
        $namaFile = "couts.xls";
        $judul = "couts";
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
        header("Content-Disposition: attachment;filename=" . $namaFile);
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Montant");
        xlsWriteLabel($tablehead, $kolomhead++, "Motif");
        xlsWriteLabel($tablehead, $kolomhead++, "Author");
        xlsWriteLabel($tablehead, $kolomhead++, "Date Sortie");
        xlsWriteLabel($tablehead, $kolomhead++, "Staff");
        xlsWriteLabel($tablehead, $kolomhead++, "Creer le");
        xlsWriteLabel($tablehead, $kolomhead++, "Modifie le");
        xlsWriteLabel($tablehead, $kolomhead++, "Effacer ?");

        foreach ($this->couts_model->getAll() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, (string) $data->montant);
            xlsWriteLabel($tablebody, $kolombody++, $data->motif);
            xlsWriteLabel($tablebody, $kolombody++, $data->author);
            xlsWriteLabel($tablebody, $kolombody++, $data->date_sortie);
            xlsWriteLabel($tablebody, $kolombody++, $data->staffName);
            xlsWriteLabel($tablebody, $kolombody++, $data->created_on);
            xlsWriteLabel($tablebody, $kolombody++, $data->lastUpdate);
            xlsWriteLabel($tablebody, $kolombody++, ($data->deleted == 1) ? 'oui' : 'non');

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }
}
