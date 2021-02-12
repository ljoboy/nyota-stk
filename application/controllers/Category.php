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

    /**
     * To add new Category
     */
    public function add()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('nom', 'Nom', ['required', 'trim', 'max_length[20]', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('description', 'Description', ['required', 'trim', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);

        if ($this->form_validation->run() !== FALSE) {
            /**
             * insert info into db
             * function header: add($nom, $description)
             */
            $inserted = $this->category_model->add(set_value('nom'), set_value('description'));

            $json = $inserted ? ['status' => 1, 'msg' => "Catégorie enregistrée avec succès"] : ['status' => 0, 'msg' => "Oops ! Une erreur inattendue. Veuillez contacter l'administrateur."];
        } else {
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /**
     * To update Category
     */
    public function update()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('nom', 'Nom', ['required', 'trim', 'max_length[20]', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('description', 'Description', ['required', 'trim', 'strtolower', 'ucfirst'], ['required' => "Champ obligatoire"]);

        print_r($this->form_validation->run());

        if ($this->form_validation->run() !== FALSE) {
            /**
             * update info into db
             * function header: add($nom, $description)
             */
            $category_id = $this->input->post('categoryId', TRUE);

            $updated = $this->couts_model->update($category_id, set_value('nom'), set_value('description'));

            $json = $updated ? ['status' => 1, 'msg' => "Infos mise à jour avec succès"] : ['status' => 0, 'msg' => "Oops ! Erreur inattendue. Contacter l'administrateur svp !"];
        } else {
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /**
     * To delete Category
     */
    public function delete()
    {
        $this->genlib->ajaxOnly();

        $category_id = $this->input->post('_aId');
        $new_value = $this->genmod->getTableCol('categories', 'deleted', 'categoryId', $category_id) == 1 ? 0 : 1;

        $done = $this->couts_model->delete($category_id, $new_value);

        $json['status'] = $done ? 1 : 0;
        $json['_nv'] = $new_value;
        $json['_aId'] = $category_id;

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
