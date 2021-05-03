<?php
defined('BASEPATH') or exit('');

class Backup extends CI_Controller
{

    public function db_backup()
    {

        $prefs = array('ignore' => array('backups'),                     // List of tables to omit from the backup
            'format' => 'txt',                       // gzip, zip, txt
            'filename' => 'nyota' . date('Y-M-d') . '.sql',              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE,                        // Whether to add INSERT data to backup file
            'newline' => "\n"                         // Newline character used in backup file
        );

        $dir = __DIR__ . '/../../backups/';
        if (!is_dir($dir)) {
            mkdir($dir,0755, true);
        }

        $fichier = $dir . $prefs['filename'] . '.gz';

        $this->load->dbutil();


// Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup($prefs);

        $this->load->model(['backupModel']);

        $result = $this->backupModel->create($prefs['filename'], realpath($fichier));

// Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file($fichier, $backup);


    }
}