<?php
defined('BASEPATH') or exit('');

class CommandModel extends CI_Model
{
    private string $table = 'commandes';
    public function __construct()
    {
        parent::__construct();
    }

    /***
     * @param int $item_id
     * @param int $supplier_id
     * @param int $qty
     * @return int|null
     */
    public function add(int $item_id, int $supplier_id, int $qty): ?int
    {
        $data = [
            'ref' => strtoupper(generateRandomCode('numeric', 10, 20, "")),
            'item_id' => $item_id,
            'supplier_id' => $supplier_id,
            'quantity' => $qty,
        ];

        $this->db->insert($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    /**
     * @param int $supplier_id
     * @param array $item_ids
     * @return bool
     */
    public function setItemSupplier(int $supplier_id, array $item_ids): bool
    {
        $data = [];
        foreach ($item_ids as $item_id) {
            $data[] = [
                'supplier_id' => $supplier_id,
                'item_id' => $item_id
            ];
        }

        $this->db->insert_batch('item_supplier', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $phone_number
     * @param string $email
     * @param string $address
     * @return bool
     */
    public function edit(int $id, string $name, string $phone_number, string $email, string $address = ""): bool
    {
        $data = [
            'name' => $name,
            'phone_number' => $phone_number,
            'address' => $address,
            'email' => $email,
        ];

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return true;
    }

    /**
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param int|null $limit
     * @return null
     */
    public function getAllNotSend(string $orderBy = "created_at", string $orderFormat = "DESC", int $start = 0, int $limit = null)
    {
        $this->db->select('commandes.*, suppliers.name as supplier_name, items.name as item_name, suppliers.email as supplier_email');
        $this->db->where('sended_at');
        $this->db->join('items', 'commandes.item_id = items.id', 'LEFT');
        $this->db->join('suppliers', 'commandes.supplier_id = suppliers.id', 'LEFT');
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get($this->table);

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return null;
        }
    }
    /**
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param int|null $limit
     * @return null
     */
    public function getAllSend(string $orderBy = "created_at", string $orderFormat = "DESC", int $start = 0, int $limit = null)
    {
        $this->db->select('commandes.*, suppliers.name as supplier_name, items.name as item_name, suppliers.email as supplier_email');
        $this->db->where('sended_at !=', 'NULL');
        $this->db->join('items', 'commandes.item_id = items.id', 'LEFT');
        $this->db->join('suppliers', 'commandes.supplier_id = suppliers.id', 'LEFT');
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get($this->table);

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return null;
        }
    }

    /**
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param int|null $limit
     * @return false
     */
    public function getAllItemSupplier(string $orderBy = "created_at", string $orderFormat = "ASC", int $start = 0, int $limit = null)
    {
        $this->db->select('suppliers.*, items.name as item_name, items.id as item_id');
        $this->db->limit($limit, $start);
        $this->db->join('suppliers', 'item_supplier.supplier_id = suppliers.id', 'LEFT');
        $this->db->join('items', 'item_supplier.item_id = items.id', 'LEFT');
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get('item_supplier');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return false;
        }
    }

    /**
     * @param int $supplier_id
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param int|null $limit
     * @return false
     */
    public function getItems(int $supplier_id, string $orderBy = "created_at", string $orderFormat = "ASC", int $start = 0, int $limit = null)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        $this->db->join('suppliers', "item_supplier.supplier_id = {$supplier_id}", 'LEFT');
        $this->db->join('items', 'item_supplier.item_id = items.id', 'LEFT');
        $this->db->order_by($orderBy, $orderFormat);

        $run_q = $this->db->get('item_supplier');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return false;
        }
    }

    /**
     * @param int $supplier_id
     * @return bool
     */
    public function deleteItemSupplier(int $supplier_id): bool
    {
        $this->db->select('*');
        $this->db->where('supplier_id', $supplier_id);
        $result = $this->db->get('item_supplier');

        if ($result->num_rows() > 0) {
            $item_suppliers = $result->result();

            /**
             * Here we delete all categories of the item
             **/
            foreach ($item_suppliers as $item_supplier) {
                $this->db->where('id', $item_supplier->id)->delete('item_supplier');
            }
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sended(int $supplier_id)
    {
        $this->db->set('sended_at', date('Y-m-d H:i:s'));
        $this->db->where('supplier_id', $supplier_id);
        $this->db->update($this->table);

        return true;
    }
}