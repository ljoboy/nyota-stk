<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Commande extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->genlib->checkLogin();
        $this->genlib->superOnly();
        $this->load->model(['commandModel', 'item', 'supplierModel']);
    }

    public function index()
    {
        $items = $this->item->getAll();
        $suppliers = $this->supplierModel->getAll();
        $itemSuppliers = $this->supplierModel->getAllItemSupplier();
        $data['pageContent'] = $this->load->view('commandes', compact('itemSuppliers', 'items', 'suppliers'), TRUE);
        $data['pageTitle'] = "Commandes";

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
        $data['allCommandes'] = $this->commandModel->getAllNotSend($orderBy, $orderFormat, $start, $limit);
        $data['items'] = $this->item->getAll();
        $totalsuppliers = count($data['allCommandes'] ?? []);
        $config = $this->genlib->setPaginationConfig($totalsuppliers, "commande/laad_", $limit, ['class' => 'lnp']);

        $this->pagination->initialize($config);//initialize the library class

        //get all couts from db

        $data['range'] = ($totalsuppliers > 0) ? ($start + 1) . "-" . ($start + count($data['allCommandes'])) . " sur " . $totalsuppliers : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;

        $json['commandesTable'] = $this->load->view('commandes/commandslist', $data, TRUE);//get view with populated couts table
        $data['allCommandes'] = $this->commandModel->getAllSend($orderBy, $orderFormat, $start, $limit);
        $json['sendTable'] = $this->load->view('commandes/sentlist', $data, TRUE);//get view with populated couts table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function add()
    {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('item_id', 'Article', ['required'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('supplier_id', 'Fournisseur', ['required'], ['required' => "Champ obligatoire"]);
        $this->form_validation->set_rules('qty', 'Quantité', ['required'], ['required' => "Champ obligatoire"]);


        if ($this->form_validation->run() !== FALSE) {
            $inserted = $this->commandModel->add(set_value('item_id'), set_value('supplier_id'), set_value('qty'));
            $json = $inserted ? ['status' => 1, 'msg' => "Fournisseur enregistrée avec succès"] : ['status' => 0, 'msg' => "Oops ! Une erreur inattendue. Veuillez contacter l'administrateur."];
        } else {
            $json = $this->form_validation->error_array();//get an array of all errors

            $json['msg'] = "Un ou plusieurs champs obligatoires sont vides ou mal remplis";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function send()
    {
        $commandes = $this->commandModel->getAllNotSend();
        $i = 0;
        $items = [];
        $id = 0;
        foreach ($commandes as $commande) {
            $items[] = [$commande->item_name, $commande->quantity];
            if ($commande->supplier_id != $id && $id != 0) {
                $this->send_email($commande->supplier_email, $id, $items);
                $items = [];
                $i++;
            }
            $id = $commande->supplier_id;
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    private function send_email(string $supplier_email, int $supplier_id,array $items)
    {
        $this->load->config('email');
        $this->load->library('email');

        $from = 'procurement@quin-gradi.app';
        $to = $supplier_email;
        $lists = "";
        foreach ($items as $item) {
            $lists .= "Nom : {$item[0]}\n";
            $lists .= "Quantité : {$item[1]}\n";
            $lists .= "-----------------------\n";
        }
        $msg = "
Veuillez nous fournir :
-----------------------
{$lists}

        QUIN GRADI
        ";
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject('Demande de stock');
        $this->email->message($msg);

        if ($this->email->send()) {
            $this->commandModel->sended($supplier_id);
        } else {
            show_error($this->email->print_debugger());
        }
    }

}