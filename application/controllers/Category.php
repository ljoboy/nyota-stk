<?php
defined('BASEPATH') or exit('');

class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->genlib->checkLogin();

        $this->genlib->superOnly();

        $this->load->model(['category_model']);
    }

    public function index()
    {
        $data['pageContent'] = $this->load->view('categories', '', TRUE);
        $data['pageTitle'] = "Categories";

        $this->load->view('main', $data);
    }

    public function laad_()
    {
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "date_sortie";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";

        $totalcategories = count($this->category_model->getAll($orderBy, $orderFormat));

        $this->load->library('pagination');

        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration

        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalcategories, "couts/laad_", $limit, ['class' => 'lnp']);

        $this->pagination->initialize($config);//initialize the library class

        //get all couts from db
        $data['allCategories'] = $this->couts_model->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = ($totalcategories > 0) ? ($start + 1) . "-" . ($start + count($data['allCategories'])) . " sur " . $totalcategories : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;

        $json['categoriesTable'] = $this->load->view('categories/categorieslist', $data, TRUE);//get view with populated couts table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
