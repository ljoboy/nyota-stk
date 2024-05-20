<?php
defined('BASEPATH') or exit('');

class Backup extends CI_Controller
{

    public function db_backup()
    {
        // Load the DB utility class
        $this->load->dbutil();

// Backup your entire database and assign it to a variable

        $j = realpath(__DIR__ . "/../../public/db") . DIRECTORY_SEPARATOR . "backup.sql";
        $prefs = array(
            'tables'        => array(),   // Array of tables to back up.
            'ignore'        => array(),                     // List of tables to omit from the backup
            'format'        => 'txt',                       // gzip, zip, txt
            'filename'      => $j,              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
            'newline'       => "\n"                         // Newline character used in backup file
        );
        $backup = $this->dbutil->backup($prefs);

// Load the file helper and write the file to your server

        $this->load->helper('file');
        $k = write_file($j, $backup);
        if ($k) {
            echo "Good";
        } else {
            echo 'Not good';
        }
    }

    public function db_upload()
    {
        $filename = realpath(__DIR__ . "/../../public/db/backup.sql");
        $file = new CURLFile($filename, mime_content_type($filename), "backup-" . time() . ".sql");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('db' => $file));
        curl_setopt($ch, CURLOPT_URL, 'http://stk.test/backup/upload');
        curl_exec($ch);
        curl_close($ch);
    }

    public function upload()
    {
        $config['upload_path'] = './public/uploaded_db/';
        $config['allowed_types'] = 'sql';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('db')) {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
//            $this->load->view('files/upload_form', $error);
        } else {
            $db_file = $this->upload->data();
            $this->load->model('backupModel');
            $this->backupModel->toDb($db_file['full_path']);
            echo "okay...";
        }
    }
}