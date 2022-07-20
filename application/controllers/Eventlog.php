<?php
defined('BASEPATH') OR exit('');

class Eventlog extends CI_Controller{
    
    public function __construct(){
        parent::__construct();

        $this->load->model(['eventlog_Model']);
        
        $this->genlib->checkLogin();
        
        $this->genlib->superOnly();
    }
    
    
    public function index(){
        $data['pageTitle'] = "Journal d'événement";
        $data['allevents'] = $this->eventlog_Model->getAll();

        $data['pageContent'] = $this->load->view('eventlog/eventlog', $data, TRUE);

        $this->load->view('main', $data);
    }

    public function approvisionnement()
    {
        $data['allevents'] = $this->eventlog_Model->approvisionnement();
        $data['pageContent'] = $this->load->view('eventlog/eventloglist', $data, TRUE);
        $data['pageTitle'] = "Journal d'approvisionnement";

        $this->load->view('main', $data);
    }

    /**
     * "lilt" = "load Items List Table"
     */
    public function lilt()
    {
        $this->genlib->ajaxOnly();

        $this->load->helper('text');

        //set the sort order
        $orderBy = $this->input->get('orderBy', true) ? $this->input->get('orderBy', true) : "event";
        $orderFormat = $this->input->get('orderFormat', true) ? $this->input->get('orderFormat', true) : "DESC";

        //count the total number of items approvisionnement in db
        $totalEvents = $this->eventlog_Model->count_all();

        $this->load->library('pagination');

        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', true) ? $this->input->get('limit', true) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration

        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig(
            $totalEvents,
            "eventlog/lilt",
            $limit,
            ['onclick' => 'return lilt(this.href);']
        );

        $this->pagination->initialize($config);//initialize the library class

        //get all items from db
        $data['allevents'] = $this->eventlog_Model->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalEvents > 0 ? "Afficher " . ($start + 1) . "-" . ($start + count(
                    $data['allevents']
                )) . " sur " . $totalEvents : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;

        $json['allevents'] = $this->load->view('eventlog/eventloglist', $data, TRUE);//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /**
     * Genere un xlsx
     */
    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "events.xls";
        $judul = "Evenements";
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
        header("Content-Transfer-Encoding: binary");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Evenement");
        xlsWriteLabel($tablehead, $kolomhead++, "Auteur");
        xlsWriteLabel($tablehead, $kolomhead++, "Produit");
        xlsWriteLabel($tablehead, $kolomhead++, "Code Unitaire");
        xlsWriteLabel($tablehead, $kolomhead++, "Description");
        xlsWriteLabel($tablehead, $kolomhead++, "Date et Heure");

        $items = $this->eventlog_Model->getAll();

        foreach ($items as $data) {
            $kolombody = 0;

            //changer xlsWriteLabel en xlsWriteNumber pour les colonnes numériques
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->event);
            xlsWriteLabel($tablebody, $kolombody++, $data->author);
            xlsWriteLabel($tablebody, $kolombody++, $data->name);
            xlsWriteNumber($tablebody, $kolombody++, $data->code);
            xlsWriteNumber($tablebody, $kolombody++, $data->eventDesc);
            xlsWriteNumber($tablebody, $kolombody++, date('d-m-Y H:i:s', strtotime($data->eventTime)));

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }
}
