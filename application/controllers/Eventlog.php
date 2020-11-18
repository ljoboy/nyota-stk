<?php
defined('BASEPATH') OR exit('');

class Eventlog extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->genlib->superOnly();
    }
    
    
    public function index(){
        $data['pageContent'] = $this->load->view('eventlog', '', TRUE);
        $data['pageTitle'] = "Journal d'erreur";
        
        $this->load->view('main', $data);
    }
}
