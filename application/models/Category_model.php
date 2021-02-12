<?php
defined('BASEPATH') or exit('');

class Category extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $name
     * @param $description
     * @return false
     */
    public function add($name, $description)
    {
        $data = ['nom' => $name, 'description' => $description];

        $this->db->set('created_on', "NOW()", FALSE);

        $this->db->insert('categories', $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    /**
     * @param $categoryId
     * @param $name
     * @param $description
     * @return bool
     */
    public function edit($categoryId, $name, $description)
    {
        $data = ['nom' => $name, 'description' => $description];

        $this->db->where('id', $categoryId);
        $this->db->update('categories', $data);

        return TRUE;
    }

    public function getAll($orderBy = "created_on", $orderFormat = "ASC", $start = 0, $limit = null)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get('categories');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return FALSE;
        }
    }
}
