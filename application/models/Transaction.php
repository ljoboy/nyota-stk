<?php

defined('BASEPATH') or exit('');

class Transaction extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Get all transactions
     * @param string $orderBy
     * @param string $orderFormat
     * @param int $start
     * @param int $limit
     * @return array|null
     */
    public function getAll($orderBy, $orderFormat, $start, $limit, $dette = false)
    {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.first_name || ' ' || admin.last_name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email, transactions.pos, transactions.cash
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                GROUP BY ref
                ORDER BY {$orderBy} {$orderFormat}
                LIMIT {$limit} OFFSET {$start}";

            $run_q = $this->db->query($q);
        } else {
            $this->db->select('transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                CONCAT_WS(" ", admin.first_name, admin.last_name) as "staffName",
                transactions.cust_name, transactions.cust_phone, transactions.cust_email, transactions.pos, transactions.cash, ');

            $this->db->select_sum('transactions.quantity');

            if ($dette) {
                $this->db->where('transactions.pos >', '0');
                $this->db->where('transactions.modeOfPayment !=', 'Cash');
            }

            $this->db->join('admin', 'transactions.staffId = admin.id', 'LEFT');
            $this->db->limit($limit, $start);
            $this->db->group_by('transactions.ref');
            $this->db->order_by($orderBy, $orderFormat);

            $run_q = $this->db->get('transactions');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return null;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     *
     * @param type $_iN item Name
     * @param type $_iC item Code
     * @param type $desc Desc
     * @param type $q quantity bought
     * @param type $_up unit price
     * @param type $_tp total price
     * @param type $_tas total amount spent
     * @param type $_at amount tendered
     * @param type $_cd change due
     * @param type $_mop mode of payment
     * @param type $_tt transaction type whether (sale{1} or return{2})
     * @param type $ref
     * @param float $_va VAT Amount
     * @param float $_vp VAT Percentage
     * @param float $da Discount Amount
     * @param float $dp Discount Percentage
     * @param {string} $cn Customer Name
     * @param {string} $cp Customer Phone
     * @param {string} $ce Customer Email
     * @return boolean
     */
    public function add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, $_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce, $ca, $pos)
    {
        $data = ['itemName' => $_iN, 'itemCode' => $_iC, 'description' => $desc, 'quantity' => $q, 'unitPrice' => $_up, 'totalPrice' => $_tp, 'amountTendered' => $_at, 'changeDue' => $_cd, 'modeOfPayment' => $_mop, 'transType' => $_tt, 'staffId' => $this->session->admin_id, 'totalMoneySpent' => $_tas, 'ref' => $ref, 'vatAmount' => $_va, 'vatPercentage' => $_vp, 'discount_amount' => $da, 'discount_percentage' => $dp, 'cust_name' => $cn, 'cust_phone' => $cp, 'cust_email' => $ce, 'cash' => $ca, 'pos' => $pos];

        //set the datetime based on the db driver in use
        $this->db->platform() == "sqlite3" ? $this->db->set('transDate', "datetime('now')", FALSE) : $this->db->set('transDate', "NOW()", FALSE);

        $this->db->insert('transactions', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Primarily used to check whether a particular ref exists in db
     * @param type $ref
     * @return boolean
     */
    public function isRefExist($ref)
    {
        $q = "SELECT DISTINCT ref FROM transactions WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    public function transSearch($value)
    {
        $this->db->select('transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                CONCAT_WS(" ", admin.first_name, admin.last_name) as "staffName",
                transactions.cust_name, transactions.cust_phone, transactions.cust_email');
        $this->db->select_sum('transactions.quantity');
        $this->db->join('admin', 'transactions.staffId = admin.id', 'LEFT');
        $this->db->like('ref', $value);
        $this->db->or_like('itemName', $value);
        $this->db->or_like('itemCode', $value);
        $this->db->group_by('ref');

        $run_q = $this->db->get('transactions');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        } else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Get all transactions with a particular ref
     * @param string $ref
     * @return boolean
     */
    public function gettransinfo($ref)
    {
        $q = "SELECT * FROM transactions WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return $run_q->result_array();
        } else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * selects the total number of transactions done so far
     * @return boolean
     */
    public function totalTransactions($dette = false)
    {
        $q = "SELECT count(DISTINCT REF) as 'totalTrans' FROM transactions";

        if ($dette) {
            $q .= " WHERE (modeOfPayment != 'Cash') AND (pos > 0)";
        }

        $run_q = $this->db->query($q);

        if ($run_q->num_rows() > 0) {
            foreach ($run_q->result() as $get) {
                return $get->totalTrans;
            }
        } else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Calculates the total amount earned today
     * @return boolean
     */
    public function totalEarnedToday()
    {
        $q = "SELECT totalMoneySpent FROM transactions WHERE DATE(transDate) = CURRENT_DATE";

        $run_q = $this->db->query($q);

        if ($run_q->num_rows()) {
            $totalEarnedToday = 0;

            foreach ($run_q->result() as $get) {
                $totalEarnedToday += $get->totalMoneySpent;
            }

            return $totalEarnedToday;
        } else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    //Not in use yet
    public function totalEarnedOnDay($date)
    {
        $q = "SELECT SUM(totalPrice) as 'totalEarnedToday' FROM transactions WHERE DATE(transDate) = {$date}";

        $run_q = $this->db->query($q);

        if ($run_q->num_rows() > 0) {
            foreach ($run_q->result() as $get) {
                return $get->totalEarnedToday;
            }
        } else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    public function getDateRange($from_date, $to_date)
    {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.first_name || ' ' || admin.last_name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                WHERE 
                date(transactions.transDate) >= {$from_date} AND date(transactions.transDate) <= {$to_date}
                GROUP BY ref
                ORDER BY transactions.transId DESC";

            $run_q = $this->db->query($q);
        } else {
            $this->db->select('transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                    transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                    CONCAT_WS(" ", admin.first_name, admin.last_name) AS "staffName",
                    transactions.cust_name, transactions.cust_phone, transactions.cust_email');

            $this->db->select_sum('transactions.quantity');

            $this->db->join('admin', 'transactions.staffId = admin.id', 'LEFT');

            $this->db->where("DATE(transactions.transDate) >= ", $from_date);
            $this->db->where("DATE(transactions.transDate) <= ", $to_date);

            $this->db->order_by('transactions.transId', 'DESC');

            $this->db->group_by('ref');

            $run_q = $this->db->get('transactions');
        }

        return $run_q->num_rows() ? $run_q->result() : FALSE;
    }

    public function payment($ref, $percu, $retourne)
    {
        $paye = $percu - $retourne;
        $data = ["staff_id" => $this->session->admin_id, "ref" => $ref, "montant_percu" => $percu, "montant_retourne" => $retourne, "montant_paye" => $paye];

        $this->db->trans_start();
        $this->posPayment($ref, $paye);
        $this->db->insert('payements', $data);
        $this->db->trans_complete();

        if ($this->db->affected_rows() ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function posPayment($ref, $paye)
    {
        $trans = $this->getOneTransByRef($ref);

        $this->db->set('pos',  ($trans->pos - $paye));
        $this->db->set('cash', (float) ($trans->cash + $paye));
        $this->db->where('ref', $ref);
        $query = $this->db->update('transactions');

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $ref
     * @return false
     */
    public function getPOS($ref)
    {
        $this->db->select("pos");
        $this->db->where("ref", $ref);
        $q = $this->db->get("transactions");

        return $q->num_rows() ? $q->row() : false;
    }

    /**
     * @param $ref
     * @return null
     */
    public function getOneTransByRef($ref)
    {
        $q = "SELECT * FROM transactions WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return $run_q->row();
        } else {
            return null;
        }
    }
}
