<?php
defined('BASEPATH') or exit('');

//TODO::Vérifier la modification du compte admin
class Administrators extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->genlib->checkLogin();

        $this->genlib->superOnly();

        $this->load->model(['admin']);
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
        $data['pageContent'] = $this->load->view('admin/admin', '', TRUE);
        $data['pageTitle'] = "Utilisateurs";

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
     * lac_ = "Load all administrators"
     */
    public function laad_()
    {
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "first_name";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";

        //count the total administrators in db (excluding the currently logged in admin)
        $totalAdministrators = $this->admin->getCount();

        $this->load->library('pagination');

        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration

        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalAdministrators, "administrators/laad_", $limit, ['class' => 'lnp']);

        $this->pagination->initialize($config);//initialize the library class

        //get all customers from db
        $data['allAdministrators'] = $this->admin->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalAdministrators > 0 ? ($start + 1) . "-" . ($start + count($data['allAdministrators'])) . " sur " . $totalAdministrators : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;

        $json['adminTable'] = $this->load->view('admin/adminlist', $data, TRUE);//get view with populated customers table

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
     * To add new admin
     */
    public function add()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('firstName', 'First name', ['required', 'trim', 'max_length[20]', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('lastName', 'Last name', ['required', 'trim', 'max_length[20]', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('email', 'E-mail', ['trim', 'required', 'valid_email', 'is_unique[admin.email]', 'strtolower'], ['required' => "Champ obligatoire", 'is_unique' => 'Cette adresse mail existe']);
        $this->form_validation->set_rules('role', 'Role', ['required'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('mobile1', 'Phone number', ['required', 'trim', 'numeric', 'max_length[15]', 'min_length[10]', 'is_unique[admin.mobile1]'], ['required' => "Champ obligatoire", 'is_unique' => "Ce numéro est déjà attaché à un Utilisateur"]);
        $this->form_validation->set_rules('mobile2', 'Other number', ['trim', 'numeric', 'max_length[15]', 'min_length[10]']);
        $this->form_validation->set_rules('passwordOrig', 'Password', ['required', 'min_length[8]'], ['required' => "Entrez un mot de passe"]);
        $this->form_validation->set_rules('passwordDup', 'Password Confirmation', ['required', 'matches[passwordOrig]'], ['required' => "Retapez le mot de passe svp !"]);

        if ($this->form_validation->run() !== FALSE) {
            /**
             * insert info into db
             * function header: add($f_name, $l_name, $email, $password, $role, $mobile1, $mobile2)
             */
            $hashedPassword = password_hash(set_value('passwordOrig'), PASSWORD_BCRYPT);

            $inserted = $this->admin->add(set_value('firstName'), set_value('lastName'), set_value('email'), $hashedPassword, set_value('role'), set_value('mobile1'), set_value('mobile2'));


            $json = $inserted ? ['status' => 1, 'msg' => "Compte admin créer avec succès"] : ['status' => 0, 'msg' => "Oops ! Une erreur inattendue. Veuillez contacter l'Utilisateur."];
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

        $this->form_validation->set_rules('firstName', 'First name', ['required', 'trim', 'max_length[20]'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('lastName', 'Last name', ['required', 'trim', 'max_length[20]'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('mobile1', 'Phone number', ['required', 'trim', 'numeric', 'max_length[15]', 'min_length[10]', 'callback_crosscheckMobile[' . $this->input->post('adminId', TRUE) . ']'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('mobile2', 'Other number', ['trim', 'numeric', 'max_length[15]', 'min_length[11]']);
        $this->form_validation->set_rules('email', 'E-mail', ['required', 'trim', 'valid_email']);
        $this->form_validation->set_rules('role', 'Role', ['required', 'trim'], ['required' => "Champ obligatoire "]);

        if ($this->form_validation->run() !== FALSE) {
            /**
             * update info in db
             * function header: update($admin_id, $first_name, $last_name, $email, $mobile1, $mobile2, $role)
             */

            $admin_id = $this->input->post('adminId', TRUE);

            $updated = $this->admin->update($admin_id, set_value('firstName'), set_value('lastName'), set_value('email'), set_value('mobile1'), set_value('mobile2'), set_value('role'));


            $json = $updated ? ['status' => 1, 'msg' => "Infos mise à jour avec succès"] : ['status' => 0, 'msg' => "Oops ! Erreur inattendue. Contacter l'Utilisateur svp !"];
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


    public function suspend()
    {
        $this->genlib->ajaxOnly();

        $admin_id = $this->input->post('_aId');
        $new_status = $this->genmod->gettablecol('admin', 'account_status', 'id', $admin_id) == 1 ? 0 : 1;

        $done = $this->admin->suspend($admin_id, $new_status);

        $json['status'] = $done ? 1 : 0;
        $json['_ns'] = $new_status;
        $json['_aId'] = $admin_id;

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

        $admin_id = $this->input->post('_aId');
        $new_value = $this->genmod->gettablecol('admin', 'deleted', 'id', $admin_id) == 1 ? 0 : 1;

        $done = $this->admin->delete($admin_id, $new_value);

        $json['status'] = $done ? 1 : 0;
        $json['_nv'] = $new_value;
        $json['_aId'] = $admin_id;

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
     * @param $mobile_number
     * @param $admin_id
     * @return bool
     */
    public function crosscheckMobile($mobile_number, $admin_id): bool
    {
        //check db to ensure number was previously used for admin with $admin_id i.e. the same admin we're updating his details
        $adminWithNum = $this->genmod->getTableCol('admin', 'id', 'mobile1', $mobile_number);

        if ($adminWithNum == $admin_id) {
            //used for same admin. All is well.
            return TRUE;
        } else {
            $this->form_validation->set_message('crosscheckMobile', 'Ce numéro est déjà rattaché à un admin');

            return FALSE;
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
     * Used as a callback while updating admin info to ensure 'email' field does not contain an email already used by another admin
     * @param string $email
     * @param int $admin_id
     * @return bool
     */
    public function crosscheckEmail(string $email, int $admin_id): bool
    {
        //check db to ensure email was previously used for admin with $admin_id i.e. the same admin we're updating his details
        $adminWithEmail = $this->genmod->getTableCol('admin', 'id', 'email', $email);

        if ($adminWithEmail == $admin_id) {
            //used for same admin. All is well.
            return TRUE;
        } else {
            $this->form_validation->set_message('crosscheckEmail', 'Cette adresse mail est déjà rattachée à un admin');

            return FALSE;
        }
    }

    public function password_update()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('adminId', 'Admin ID', ['required', 'numeric'], ['required' => "Erreur inconnue !"]);
        $this->form_validation->set_rules('password', 'Password', ['required', 'min_length[8]'], ['required' => "Entrez un mot de passe"]);
        $this->form_validation->set_rules('passwordDup', 'Password Confirmation', ['required', 'matches[password]'], ['required' => "Retapez le mot de passe svp !"]);

        $msg = [];

        if ($this->form_validation->run() !== FALSE) {
            $admin_id = $this->input->post('adminId');
            $password = $this->input->post('password');
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $result = $this->admin->password_update($admin_id, $hashedPassword);

            if ($result === true) {
                $msg['status'] = 1;
                $msg['msg'] = 'Mot de passe changé avec succès';
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'Un problème est survenu lors du changement du mot de passe';
            }

        } else {
            //return all error messages
            $msg['errors'] = $this->form_validation->error_array();//get an array of all errors

            $msg['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
            $msg['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($msg));
    }

}
