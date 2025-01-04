<?php
defined('BASEPATH') or exit('');
require_once 'functions.php';

class Transactions extends CI_Controller
{
    private $total_before_discount = 0, $discount_amount = 0, $vat_amount = 0, $eventual_total = 0;

    public function __construct()
    {
        parent::__construct();

        $this->genlib->checkLogin();

        $this->load->model(['transaction', 'item']);
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function index()
    {
        $transData['items'] = $this->item->getActiveItems('name', 'DESC');//get items with at least one qty left, to be used when doing a new transaction

        $data['pageContent'] = $this->load->view('transactions/transactions', $transData, TRUE);
        $data['pageTitle'] = "Transactions";

        $this->load->view('main', $data);
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    /**
     * latr_ = "Load All Transactions"
     */
    public function latr_()
    {
        $this->load->library('pagination');
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "transId";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "DESC";
        $dette = $this->input->get('dette', TRUE) ? $this->input->get('dette', TRUE) : false;

        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration

        if (!$dette) {
            $totalTransactions = $this->transaction->totalTransactions();
            $data['allTransactions'] = $this->transaction->getAll($orderBy, $orderFormat, $start, $limit);
        } else {
            $totalTransactions = $this->transaction->totalTransactions($dette);
            $data['allTransactions'] = $this->transaction->getAll($orderBy, $orderFormat, $start, $limit, $dette);
        }

        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalTransactions, "transactions/latr_", $limit, ['onclick' => 'return latr_(this.href);']);

        $this->pagination->initialize($config);//initialize the library class

        //get all transactions from db
        $data['range'] = $totalTransactions > 0 ? ($start + 1) . "-" . ($start + count($data['allTransactions'])) . " sur " . $totalTransactions : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start + 1;

        $json['transTable'] = $this->load->view('transactions/transtable', $data, TRUE);//get view with populated transactions table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     * nso_ = "New Sales Order"
     */
    public function nso_()
    {
        $this->genlib->ajaxOnly();

        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        $_mop = $this->input->post('_mop', TRUE);//mode of payment
        $_at = round($this->input->post('_at', TRUE), 2);//amount tendered
        $_cd = $this->input->post('_cd', TRUE);//change due
        $cash = $this->input->post('ca', TRUE);//cash Amount
        $pos = $this->input->post('pos', TRUE);//pos Amount
        $cumAmount = $this->input->post('_ca', TRUE);//cumulative amount
        $vatPercentage = $this->input->post('vat', TRUE);//vat percentage
        $discount_percentage = $this->input->post('discount', TRUE);//discount percentage
        $cust_name = $this->input->post('cn', TRUE);
        $cust_phone = $this->input->post('cp', TRUE);
        $cust_email = $this->input->post('ce', TRUE);

        /*
         * Loop through the arrOfItemsDetails and ensure each item's details has not been manipulated
         * The unitPrice must match the item's unit price in db, the totPrice must match the unitPrice*qty
         * The cumAmount must also match the total of all totPrice in the arr in addition to the amount of 
         * VAT (based on the vat percentage) and minus the $discount_percentage (if available)
         */

        $allIsWell = $this->validateItemsDet($arrOfItemsDetails, $cumAmount, $_at, $vatPercentage, $discount_percentage, $cash, $pos);

        if ($allIsWell) {//insert each sales order into db, generate receipt and return info to client

            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertTrToDb($arrOfItemsDetails, $_mop, $_at, $cumAmount, $_cd, $this->vat_amount, $vatPercentage, $this->discount_amount, $discount_percentage, $cust_name, $cust_phone, $cust_email, $cash, $pos);

            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction traitée avec succès" : "Impossible de traiter votre demande pour le moment. Veuillez réessayer plus tard" . "ou contactez le service technique pour obtenir de l'aide";
            $json['transReceipt'] = $returnedData['transReceipt'];

            $json['totalEarnedToday'] = number_format($this->transaction->totalEarnedToday());

            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails) . " articles totalisant USD" . number_format($cumAmount, 2) . " avec le numéro de référence {$returnedData['transRef']} a été acheté";

            $this->genmod->addevent("Nouvelle transaction", $returnedData['transRef'], $eventDesc, 'transactions', $this->session->admin_id);
        } else {//return error msg
            $json['status'] = 0;
            $json['msg'] = "La transaction n'a pas pu être traitée. Veuillez vous assurer qu'il n'y a pas d'erreur. Merci";
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     * @param $arrOfItemsInfo
     * @param $cumAmountFromClient
     * @param $amountTendered
     * @param $vatPercentage
     * @param $discount_percentage
     * @param $ca
     * @param $pos
     * @return bool
     */
    private function validateItemsDet($arrOfItemsInfo, $cumAmountFromClient, $amountTendered, $vatPercentage, $discount_percentage, $ca, $pos): bool
    {
        $error = 0;


        if (((float)$ca + (float)$pos) !== (float)$cumAmountFromClient) {
            return false;
        }

        //loop through the item's info and validate each
        //return error if at least one seems suspicious (i.e. fails validation)
        foreach ($arrOfItemsInfo as $get) {
            $itemCode = $get->_iC;//use this to get the item's unit price, then multiply it with the qty sent from client
            $qtyToBuy = $get->qty;
            $unitPriceFromClient = $get->unitPrice;
            $unitPriceInDb = $this->genmod->gettablecol('items', 'unitPrice', 'code', $itemCode);
            $totPriceFromClient = $get->totalPrice;

            //ensure both unit price matches
            $unitPriceInDb == $unitPriceFromClient ? "" : $error++;

            $expectedTotPrice = round($qtyToBuy * $unitPriceInDb, 2);//calculate expected totPrice

            //ensure both matches
            $expectedTotPrice == $totPriceFromClient ? "" : $error++;

            //no need to validate others, just break out of the loop if one fails validation
            if ($error > 0) {
                return FALSE;
            }

            $this->total_before_discount += $expectedTotPrice;
        }

        /**
         * We need to save the total price before tax, tax amount, total price after tax, discount amount, eventual total
         */

        $expectedCumAmount = $this->total_before_discount;

        //now calculate the discount amount (if there is discount) based on the discount percentage and subtract it(discount amount) 
        //from $total_before_discount
        if ($discount_percentage) {
            $this->discount_amount = $this->getDiscountAmount($expectedCumAmount, $discount_percentage);

            $expectedCumAmount = round($expectedCumAmount - $this->discount_amount, 2);
        }

        //add VAT amount to $expectedCumAmount is VAT percentage is set
        if ($vatPercentage) {
            //calculate vat amount using $vatPercentage and add it to $expectedTotPrice
            $this->vat_amount = $this->getVatAmount($expectedCumAmount, $vatPercentage);

            //now add the vat amount to expected total price
            $expectedCumAmount = round($expectedCumAmount + $this->vat_amount, 2);
        }

        //check if cum amount also matches and ensure amount tendered is not less than $expectedCumAmount
        if (($expectedCumAmount != $cumAmountFromClient) || ($expectedCumAmount > $amountTendered)) {
            return FALSE;
        }

        //if code execution reaches here, it means all is well
        $this->eventual_total = $expectedCumAmount;
        return TRUE;
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     * @param $arrOfItemsDetails
     * @param $_mop
     * @param $_at
     * @param $cumAmount
     * @param $_cd
     * @param $vatAmount
     * @param $vatPercentage
     * @param $discount_amount
     * @param $discount_percentage
     * @param $cust_name
     * @param $cust_phone
     * @param $cust_email
     * @param $ca
     * @param $pos
     * @return array|false
     */
    private function insertTrToDb($arrOfItemsDetails, $_mop, $_at, $cumAmount, $_cd, $vatAmount, $vatPercentage, $discount_amount, $discount_percentage, $cust_name, $cust_phone, $cust_email, $ca, $pos)
    {
        $allTransInfo = [];//to hold info of all items' in transaction

        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        do {
            $ref = strtoupper(generateRandomCode('numeric', 6, 10, ""));
        } while ($this->transaction->isRefExist($ref));

        //loop through the items' details and insert them one by one
        //start transaction
        $this->db->trans_start();

        foreach ($arrOfItemsDetails as $get) {
            $itemCode = $get->_iC;
            $itemName = $this->genmod->getTableCol('items', 'name', 'code', $itemCode);
            $qtySold = $get->qty;//qty selected for item in loop
            $unitPrice = $get->unitPrice;//unit price of item in loop
            $totalPrice = $get->totalPrice;//total price for item in loop

            /*
             * add transaction to db
             * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, $_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             */
            $transId = $this->transaction->add($itemName, $itemCode, "", $qtySold, $unitPrice, $totalPrice, $cumAmount, $_at, $_cd, $_mop, 1, $ref, $vatAmount, $vatPercentage, $discount_amount, $discount_percentage, $cust_name, $cust_phone, $cust_email, $ca, $pos);

            $allTransInfo[$transId] = ['itemName' => $itemName, 'quantity' => $qtySold, 'unitPrice' => $unitPrice, 'totalPrice' => $totalPrice];

            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)
            $this->item->decrementItem($itemCode, $qtySold);
        }

        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            $dataToReturn = [];

            //get transaction date in db, to be used on the receipt. It is necessary since date and time must matc
            $dateInDb = $this->genmod->getTableCol('transactions', 'transDate', 'transId', $transId);

            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genTransReceipt($allTransInfo, $cumAmount, $_at, $_cd, $ref, $dateInDb, $_mop, $vatAmount, $vatPercentage, $discount_amount, $discount_percentage, $cust_name, $cust_phone, $cust_email, $ca, $pos);
            $dataToReturn['transRef'] = $ref;

            return $dataToReturn;
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
     * @param $allTransInfo
     * @param $cumAmount
     * @param $_at
     * @param $_cd
     * @param $ref
     * @param $transDate
     * @param $_mop
     * @param $vatAmount
     * @param $vatPercentage
     * @param $discount_amount
     * @param $discount_percentage
     * @param $cust_name
     * @param $cust_phone
     * @param $cust_email
     * @param $cash
     * @param $pos
     * @return object|string
     */
    private function genTransReceipt($allTransInfo, $cumAmount, $_at, $_cd, $ref, $transDate, $_mop, $vatAmount, $vatPercentage, $discount_amount, $discount_percentage, $cust_name, $cust_phone, $cust_email, $cash, $pos)
    {
        $data['allTransInfo'] = $allTransInfo;
        $data['cumAmount'] = $cumAmount;
        $data['amountTendered'] = $_at;
        $data['changeDue'] = $_cd;
        $data['ref'] = $ref;
        $data['transDate'] = $transDate;
        $data['_mop'] = $_mop;
        $data['vatAmount'] = $vatAmount;
        $data['vatPercentage'] = $vatPercentage;
        $data['discountAmount'] = $discount_amount;
        $data['discountPercentage'] = $discount_percentage;
        $data['cust_name'] = $cust_name;
        $data['cust_phone'] = $cust_phone;
        $data['cust_email'] = $cust_email;
        $data['cash'] = $cash;
        $data['pos'] = $pos;

        //generate and return receipt
        $transReceipt = $this->load->view('transactions/transreceipt', $data, TRUE);

        return $transReceipt;
    }



    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    /**
     * vtr_ = "View transaction's receipt"
     * Used when a transaction's ref is clicked
     */
    public function vtr_()
    {
        $this->genlib->ajaxOnly();

        $ref = $this->input->post('ref');

        $transInfo = $this->transaction->getTransInfo($ref);

        //loop through the transInfo to get needed info
        if ($transInfo) {
            $json['status'] = 1;

            $cumAmount = $transInfo[0]['totalMoneySpent'];
            $amountTendered = $transInfo[0]['amountTendered'];
            $changeDue = $transInfo[0]['changeDue'];
            $transDate = $transInfo[0]['transDate'];
            $modeOfPayment = $transInfo[0]['modeOfPayment'];
            $vatAmount = $transInfo[0]['vatAmount'];
            $vatPercentage = $transInfo[0]['vatPercentage'];
            $discountAmount = $transInfo[0]['discount_amount'];
            $discountPercentage = $transInfo[0]['discount_percentage'];
            $cust_name = $transInfo[0]['cust_name'];
            $cust_phone = $transInfo[0]['cust_phone'];
            $cust_email = $transInfo[0]['cust_email'];
            $cash = $transInfo[0]['cash'];
            $pos = $transInfo[0]['pos'];

            $json['transReceipt'] = $this->genTransReceipt($transInfo, $cumAmount, $amountTendered, $changeDue, $ref, $transDate, $modeOfPayment, $vatAmount, $vatPercentage, $discountAmount, $discountPercentage, $cust_name, $cust_phone, $cust_email, $cash, $pos);
        } else {
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     * @param $cumAmount
     * @param $vatPercentage
     * @return float|int
     */
    private function getVatAmount($cumAmount, $vatPercentage)
    {
        $vatAmount = ($vatPercentage / 100) * $cumAmount;

        return $vatAmount;
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */


    /**
     * @param $cum_amount
     * @param $discount_percentage
     * @return float|int
     */
    private function getDiscountAmount($cum_amount, $discount_percentage)
    {
        $discount_amount = ($discount_percentage / 100) * $cum_amount;

        return $discount_amount;
    }

    /*
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    */

    public function report($from_date, $to_date = '')
    {
        //get all transactions from db ranging from $from_date to $to_date
        $data['from'] = $from_date;
        $data['to'] = $to_date ? $to_date : date('Y-m-d');

        $data['allTransactions'] = $this->transaction->getDateRange($from_date, $to_date);

        $this->load->view('transactions/transReport', $data);
    }

    public function payment()
    {
        $this->genlib->ajaxOnly();

        $ref = $this->input->post('ref');
        $percu = $this->input->post('montantPercu');
        $retourne = $this->input->post('monnaieDue');


        $verify = $this->verify_payment($ref, $percu, $retourne);

        $data = [];
        if ($verify) {
            $this->transaction->payment($ref, $percu, $retourne);
            $data['message'] = "Paiment effctué avec succès.";
            $data['status'] = 1;
        } else {
            $data['message'] = "Un problème est survenu, veuillez vérifier les informations fournies.";
            $data['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    private function verify_payment($ref, $percu, $retourne)
    {
        $montant = $this->transaction->getPOS($ref);
        $montant_paye = ($percu - $retourne);

        if ($montant_paye > $montant->pos || $montant_paye <= 0) {
            return false;
        }

        return true;
    }

    public function dettes()
    {
        $transData['items'] = $this->item->getActiveItems('name', 'DESC');//get items with at least one qty left, to be used when doing a new transaction

        $data['pageContent'] = $this->load->view('transactions/dettes', $transData, TRUE);
        $data['pageTitle'] = "Dettes";

        $this->load->view('main', $data);
    }

    /**
     * Genere un xlsx
     */
    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "transactions.xls";
        $judul = "Transactions";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Ref");
        xlsWriteLabel($tablehead, $kolomhead++, "Nom");
        xlsWriteLabel($tablehead, $kolomhead++, "Code");
        xlsWriteLabel($tablehead, $kolomhead++, "Description");
        xlsWriteLabel($tablehead, $kolomhead++, "Quantité");
        xlsWriteLabel($tablehead, $kolomhead++, "Prix unitaire");
        xlsWriteLabel($tablehead, $kolomhead++, "Prix total");
        xlsWriteLabel($tablehead, $kolomhead++, "");

        $items = $this->item->getAll();

        foreach ($items as $data) {
            $kolombody = 0;

            //changer xlsWriteLabel en xlsWriteNumber pour les colonnes numériques
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->name);
            xlsWriteLabel($tablebody, $kolombody++, $data->code);
            xlsWriteLabel($tablebody, $kolombody++, $data->description);
            xlsWriteNumber($tablebody, $kolombody++, $data->unitPrice);
            xlsWriteNumber($tablebody, $kolombody++, $data->quantity);
            xlsWriteLabel($tablebody, $kolombody++, $data->dateAdded);
            xlsWriteLabel($tablebody, $kolombody++, $data->lastUpdated);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }
}
