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
        $data['logs'] = $this->eventlog_Model->getAll('id', 'DESC');

        $data['pageTitle'] = "Journal d'erreur";

        $data['pageContent'] = $this->load->view('admin/eventlog', '', TRUE);
        $this->load->view('main', $data);
    }

    public function approvisionnement()
    {
        $data['logs'] = $this->eventlog_Model->approvisionnement('id', 'DESC');
//        var_dump($data);die;

        $data['pageTitle'] = "journal d'approvisionnement";

        $data['pageContent'] = $this->load->view('admin/eventlog', '', TRUE);
        $this->load->view('main', $data);
    }

    /**
     * "lilt" = "load Items List Table"
     */
    public function lilt(string $filter = "")
    {
        $this->genlib->ajaxOnly();

        $this->load->helper('text');

        //set the sort order
        $orderBy = $this->input->get('orderBy', true) ? $this->input->get('orderBy', true) : "name";
        $orderFormat = $this->input->get('orderFormat', true) ? $this->input->get('orderFormat', true) : "DESC";

        //count the total number of items in db
        $totalItems = isset($filter) ? $this->eventlog_Model->count_all() : $this->eventlog_Model->count_approvisionnement() ;

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
            "eventlog/lilt",
            $limit,
            ['onclick' => 'return lilt(this.href);']
        );

        $this->pagination->initialize($config);//initialize the library class

        //get all items from db
        $data['allLogs'] = $this->eventlog_Model->getAll($orderBy, $orderFormat, $start, $limit);
//        $data['categories'] = $this->category_model->getAll();
//        $data['itemCategories'] = $this->category_model->getAllItemCategories();
        $data['range'] = $totalItems > 0 ? "Afficher " . ($start + 1) . "-" . ($start + count(
                    $data['allItems']
                )) . " sur " . $totalItems : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;
//        $data['cum_total'] = $this->item->getItemsCumTotal();
//        $data['critic_items'] = $this->item->getCriticItem();

        $json['itemsListTable'] = $this->load->view(
            'admin/eventloglistable',
            $data,
            true
        );//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
