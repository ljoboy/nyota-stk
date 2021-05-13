<?php

defined('BASEPATH') or exit('');

class Category_model extends CI_Model
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

        $this->db->set('created_on', "NOW()", false);

        $this->db->insert('categories', $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * @param $categoryId
     * @param $itemId
     * @return false
     */
    public function setItemCategory($categoryId, $itemId)
    {
        if (is_array($categoryId)) {
            foreach ($categoryId as $id) {
                $data = ['id_item' => $itemId, 'id_category' => $id];

                $this->db->insert('item_category', $data);
            }
        } else {
            $data = ['id_item' => $itemId, 'id_category' => $categoryId];

            $this->db->insert('item_category', $data);
        }

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * @param $categoryId
     * @param $itemId
     * @return bool
     */
    public function updateItemCategory($categoryId, $itemId)
    {
        if (is_array($categoryId)) {
            $this->db->select('*');
            $this->db->where('id_item', $itemId);
            $result = $this->db->get('item_category');
            if ($result->num_rows() > 0) {
                $item_categories = $result->result();

                /**
                 * Here we delete all categories of the item
                 **/
                foreach ($item_categories as $item_categorie) {
                    $this->db->where('id', $item_categorie->id)->delete('item_category');
                }

                /**
                 * Here we insert new categories of the item
                 **/
                foreach ($categoryId as $id) {
                    $data = ['id_item' => $itemId, 'id_category' => $id];

                    $this->db->insert('item_category', $data);
                }
            } else {
                foreach ($categoryId as $id) {
                    $data = ['id_item' => $itemId, 'id_category' => $id];

                    $this->db->insert('item_category', $data);
                }
            }
        } else {
            $data = ['id_item' => $itemId, 'id_category' => $categoryId];

            $this->db->insert('item_category', $data);
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
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

        return true;
    }

    /**
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param null $limit
     * @return false
     */
    public function getAll($orderBy = "created_on", $orderFormat = "ASC", $start = 0, $limit = null)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get('categories');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return false;
        }
    }

    /**
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param string|null $limit
     * @return mixed
     */
    public function getAllItemCategories(string $orderBy = "created_on", string $orderFormat = "ASC", int $start = 0, string $limit = null)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        $this->db->join('categories', 'item_category.id_category = categories.id', 'LEFT');
        $this->db->join('items', 'item_category.id_item = items.id', 'LEFT');
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get('item_category');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return false;
        }
    }

    /**
     * @param $idCategory
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param null $limit
     * @return false
     */
    public function getItems($idCategory, $orderBy = "created_on", $orderFormat = "ASC", $start = 0, $limit = null)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        $this->db->join('categories', "item_category.id_category = $idCategory", 'LEFT');
        $this->db->join('items', 'item_category.id_item = items.id', 'LEFT');
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get('item_category');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return false;
        }
    }

    /**
     * @param $id_category
     * @return bool
     */
    public function deleteItemCategories($id_category)
    {
        $this->db->select('*');
        $this->db->where('id_category', $id_category);
        $result = $this->db->get('item_category');

        if ($result->num_rows() > 0) {
            $item_categories = $result->result();

            /**
             * Here we delete all categories of the item
             **/
            foreach ($item_categories as $item_categorie) {
                $this->db->where('id', $item_categorie->id)->delete('item_category');
            }
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
