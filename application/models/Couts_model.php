<?php
defined('BASEPATH') or exit('');

class Couts_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     * @param $couts_montant
     * @param $couts_motif
     * @param $couts_auteur
     * @param $couts_dateSortie
     * @return bool
     */
    public function add($couts_montant, $couts_motif, $couts_auteur, $couts_dateSortie)
    {
        $data = ['montant' => $couts_montant, 'motif' => $couts_motif, 'author' => $couts_auteur, 'date_sortie' => $couts_dateSortie, 'staffId' => $this->session->admin_id];

        //set the datetime based on the db driver in use
        $this->db->platform() == "sqlite3" ? $this->db->set('created_on', "datetime('now')", FALSE) : $this->db->set('created_on', "NOW()", FALSE);

        $this->db->insert('couts', $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
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
     * Get some details about a couts
     * @param $id
     * @return false
     */
    public function get_couts_info($id)
    {
        $this->db->select('coutsId, montant, motif, author,date_sortie,staffId');
        $this->db->where('coutsIds', $id);

        $run_q = $this->db->get('couts');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
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
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param string $limit
     * @return array|false
     */
    public function getAll($orderBy = "date_sortie", $orderFormat = "ASC", $start = 0, $limit = null)
    {
        $this->db->select('coutsId, montant, motif, author,date_sortie,staffId, couts.created_on, couts.lastUpdate, couts.deleted,
                            CONCAT_WS(" ", admin.first_name, admin.last_name) as "staffName"');
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        $this->db->join('admin', 'couts.staffId = admin.id', 'LEFT');

        $run_q = $this->db->get('couts');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
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
     *
     * @param type $coutsId
     * @param type $new_value
     * @return boolean
     */
    public function delete($coutsId, $new_value)
    {
        $this->db->where('coutsId', $coutsId);
        $this->db->update('couts', ['deleted' => $new_value]);

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
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
     *
     * @param $value
     * @return boolean
     */
    public function coutsSearch($value)
    {
        $this->db->select('couts.montant, couts.motif, couts.author, couts.staffId,
                couts.date_sortie, couts.lastUpdated, CONCAT_WS(" ", admin.first_name, admin.last_name) as "staffName"');
        $this->db->join('admin', 'couts.staffId = admin.id', 'LEFT');
        $this->db->like('motif', $value);
        $this->db->or_like('author', $value);
        $this->db->group_by('ref');

        $run_q = $this->db->get('couts');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
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

    public function update($coutsId, $couts_montant, $couts_motif, $couts_auteur, $couts_dateSortie)
    {
        $data = ['montant' => $couts_montant, 'motif' => $couts_motif, 'author' => $couts_auteur, 'date_sortie' => $couts_dateSortie, 'staffId' => $this->session->admin_id];

        $this->db->where('coutsId', $coutsId);

        $this->db->update('couts', $data);

        return TRUE;
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    function get_all()
    {
        $this->db->order_by('coutsId', 'DESC');
        return $this->db->get('couts')->result();
    }

    /**
     * @return int
     */
    public function getCount(): ?int
    {
       return $this->db->count_all_results('couts');
    }
}