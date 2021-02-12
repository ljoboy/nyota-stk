<?php
defined('BASEPATH') or exit('');

class BackupModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($filename, $fileUrl)
    {
        $data = ['file_name' => $filename, 'file_url' => $fileUrl];

        $this->db->insert('backups', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getNotOnline()
    {
        $this->db->where('online', 0);
        $run_q = $this->db->get('backups');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return false;
        }
    }

    public function updateOnlineStatus($id)
    {
        $this->db->where('id', $id);
        $this->db->set('online', 1);

        $this->db->update('backups');

        if (!$this->db->error()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
