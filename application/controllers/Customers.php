<?php
defined('BASEPATH') OR exit('');
class Customers extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->genlib->superOnly();
    }
    
    
    public function index(){
        $data['pageContent'] = $this->load->view('customers', '', TRUE);
        $data['pageTitle'] = "Clients";
        
        $this->load->view('main', $data);
    }
}
