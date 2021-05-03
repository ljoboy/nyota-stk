<?php

defined('BASEPATH') or exit('');

class Misc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function totalEarnedToday()
    {
        $this->genlib->checkLogin();

        $this->genlib->ajaxOnly();

        $this->load->model('transaction');

        $total_earned_today = $this->transaction->totalEarnedToday();

        $json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /**
     * check if admin's session is still on
     */
    public function check_session_status()
    {
        if (isset($_SESSION['admin_id']) && ($_SESSION['admin_id'] !== false) && ($_SESSION['admin_id'] !== "")) {
            $json['status'] = 1;

            //update user's last seen time
            //update_last_seen_time($id, $table_name)
            $this->genmod->update_last_seen_time($_SESSION['admin_id'], 'admin');
        } else {
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    public function dbmanagement()
    {
        $this->genlib->checkLogin();

        $this->genlib->superOnly();

        $data['pageContent'] = $this->load->view('dbbackup', '', TRUE);
        $data['pageTitle'] = "Base des données";

        $this->load->view('main', $data);
    }


    /**
     * Save locally and remotely the database
     *
     */
    public function dldb()
    {
        $data = [];
        $this->genlib->checkLogin();

        $this->genlib->superOnly();

        $prefs = array('ignore' => array('backups'), // List of tables to omit from the backup
            'format' => 'txt',                       // gzip, zip, txt
            'filename' => 'nyota_' . date('Y-M-d_') . time() . '.sql', // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"  // Newline character used in backup file
        );

        $dir = __DIR__ . '/../../backups/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $fichier = $dir . $prefs['filename'];

        $this->load->dbutil();


// Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup($prefs);

        $this->load->model(['backupModel']);


// Load the file helper and write the file to your server
        $this->load->helper('file');
        $write = write_file($fichier, $backup);

        $result = $this->backupModel->create($prefs['filename'], realpath($fichier));

        $online_res = false;
        if ($result === true) {
            $online_res = $this->save_online();
            $data['online_msg'] = $online_res ? "Base des données sauvegardée en ligne" : "La base des données n'a pas été sauvegardé en ligne";
        }

        if (is_dir($dir) && file_exists($fichier) && $write && $result) {
            $data['msg'] = "Base des données sauvegardée avec succès";
            $data['status'] = 1;
        } else {
            $msg = "Un problème est survénu lors ";
            $data['msg'] .= !is_dir($dir) ? "$msg de la création du dossier <br/>" : "";
            $data['msg'] .= !file_exists($fichier) ? "$msg de la crétaion du projet <br/> " : "";
            $data['msg'] .= !$write ? "$msg de l'écriture dans le fichier <br/>" : "";
            $data['msg'] .= !$result ? "$msg lors de l'enregistrement dans la base des données" : "";
            $data['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    /**
     *
     */
    public function importdb()
    {
        $this->genlib->checkLogin();

        $this->genlib->superOnly();

        $dir = __DIR__ . '/../../backups/restores/';

        $config['upload_path'] = $dir;//db files are stored in the basepath
        $config['allowed_types'] = 'sql';
        $config['file_ext_tolower'] = TRUE;
        $config['max_size'] = 200000;//in kb
        $config['overwrite'] = TRUE;//overwrite the previous file

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $this->load->library('upload', $config);//load CI's 'upload' library

        $this->upload->initialize($config, TRUE);

        if ($this->upload->do_upload('dbfile') == FALSE) {
            $json['msg'] = $this->upload->display_errors();
            $json['status'] = 0;
        } else {
            $json['msg'] = "Base des données récupérée avec succès";
            $json['status'] = 1;
        }

        $file_name = $this->upload->data();
        $file_name = $file_name['file_name'];

        $this->dbup($file_name);

        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    private function dbup($file_path)
    {
        //increase execution time
        if (function_exists("set_time_limit") === true && @ini_get("safe_mode") == 0) {
            @set_time_limit(60*10);
        }

        $isi_file = file_get_contents(BASEPATH . "../backups/restores/" . $file_path);
        $queries = explode(";", rtrim($isi_file, "\n;"));
        $isComment = false;

        foreach ($queries as $query) {
            $start = substr(trim($query), 0, 2);

            if ($start === '/*') {
                $isComment = true;
            } else if ($start === '*/') {
                $isComment = false;
            } else if ($start !== '--' && $start !== '//' && $query !== '' && $query[0] !== '#' && $isComment === false)  {
                $this->db->query($query);
            }
        }
    }

    private function save_online()
    {
        $this->load->model("backupModel");

        $backups = $this->backupModel->getNotOnline();

        $res = false;
        foreach ($backups as $backup) {
            $res = false;
            $file = $backup->file_url;
            $data = array("file" => new CURLFile($file), "data" => '{"foldername":"nyota"}');
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, 'https://backups.zxconnect.org/');
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data;',));
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            $final = curl_exec($handle);
            $result = json_decode($final);
            if ($result->success === 1) {
                $this->backupModel->updateOnlineStatus($backup->id);
                $res = true;
            }
            curl_close($handle);

        }

        return $res;

    }
}