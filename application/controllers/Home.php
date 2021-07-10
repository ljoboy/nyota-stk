<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!empty($_SESSION['admin_id'])) {
            redirect('dashboard');
        }
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    public function index()
    {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->load->view('home');
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
    public function login()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('email', 'E-mail', ['required', 'trim']);
        $this->form_validation->set_rules('password', 'Password', ['required']);

        if ($this->form_validation->run() !== FALSE) {
            $givenEmail = strtolower(set_value('email'));
            $givenPassword = set_value('password');

            $passwordInDb = $this->genmod->getTableCol('admin', 'password', 'email', $givenEmail);

            if ($passwordInDb) {
                $account_status = $this->genmod->getTableCol('admin', 'account_status', 'email', $givenEmail);
                $deleted = $this->genmod->getTableCol('admin', 'deleted', 'email', $givenEmail);
            } else {
                $phone_number = i18nPhoneNumber($givenEmail);
                $passwordInDb = $this->genmod->getTableCol('admin', 'password', 'mobile1', $phone_number);
                $account_status = $this->genmod->getTableCol('admin', 'account_status', 'mobile1', $phone_number);
                $deleted = $this->genmod->getTableCol('admin', 'deleted', 'mobile1', $phone_number);
                $givenEmail = $this->genmod->getTableCol('admin', 'email', 'mobile1', $phone_number);
            }

            //verify password if $passwordInDb has a value (i.e. is set)
            $verifiedPassword = $passwordInDb ? password_verify($givenPassword, $passwordInDb) : FALSE;

            //allow log in if password and email matches and admin's account has not been suspended or deleted
            if ($verifiedPassword && $account_status != 0 && $deleted != 1) {
                $this->load->model('admin');

                //set session details
                $admin_info = $this->admin->get_admin_info($givenEmail);

                if ($admin_info) {
//                    $admin_id = $get->id;

                    $_SESSION['admin_id'] = $admin_info->id;
                    $_SESSION['admin_email'] = $admin_info->email;
                    $_SESSION['admin_role'] = $admin_info->role;
                    $_SESSION['admin_initial'] = strtoupper(substr($admin_info->first_name, 0, 1));
                    $_SESSION['admin_name'] = $admin_info->first_name . " " . $admin_info->last_name;

                    //update user's last log in time
                    $this->admin->update_last_login($admin_info->id);
                }

                $json['status'] = 1;//set status to return
            } else {//if password is not correct
                $json['msg'] = "Combinaison email et mot de passe incorrecte";
                $json['status'] = 0;
            }
        } else {//if form validation fails
            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou pas remplis correctement";
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
}
