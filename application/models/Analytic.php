<?php
defined('BASEPATH') OR exit(':D');

class Analytic extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }


    /**
     * @param int $start
     * @param int $limit
     * @param string $order_by
     * @param string $order_format
     * @return bool
     */
    public function getDailyTrans($start=0, $limit=10, $order_by='DATE(transDate)', $order_format='DESC'){
        $this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", SUM(totalPrice) as "tot_earned", transDate');
        $this->db->order_by($order_by, $order_format);
        $this->db->limit($limit, $start);
        $this->db->group_by('DATE(transDate)');
        
        $run_q = $this->db->get('transactions');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }   
    
    
    
    /*public function getTimeOfDay(){
        $this->db->select('count(id) as "counter", visit_period');
        $this->db->order_by('counter', 'DESC');
        $this->db->group_by('visit_period');
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    
    public function getTotalToday(){
        $this->db->select('count(id) as "counter"');
        $this->db->where('DATE(visit_time)', date('Y-m-d'));
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->counter;
            }
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    
    public function getTotalThisMonth(){
        $this->db->select('count(id) as "counter"');
        $this->db->where('MONTH(visit_time)', date('n'));
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->counter;
            }
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    
    
    public function getTotalThisYear(){
        $this->db->select('count(id) as "counter"');
        $this->db->where('YEAR(visit_time)', date('Y'));
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->counter;
            }
        }
        
        else{
            return FALSE;
        }
    }*/

    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    /**
     * Get Transactions info by days
     * @return boolean
     */
    public function getTransByDays(){
		if($this->db->platform() == "sqlite3" ){
			$q = "SELECT 
				count(DISTINCT(ref)) as 'tot_trans', 
				SUM(quantity) as 'qty_sold', 
				SUM(totalPrice) as 'tot_earned',
				case cast (strftime('%w', transDate) as integer)
				  when 0 then 'Dimanche'
				  when 1 then 'Lundi'
				  when 2 then 'Mardi'
				  when 3 then 'Mercredi'
				  when 4 then 'Jeudi'
				  when 5 then 'Vendredi'
				  else 'Samedi' end as day
			  FROM transactions
			  GROUP BY day
			  ORDER BY tot_earned DESC";
			  
		  $run_q = $this->db->query($q, []);
		} else{
			$this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", SUM(totalPrice) as "tot_earned", DAYNAME(transDate) as "day"');
			$this->db->order_by('tot_earned', 'DESC');
			$this->db->group_by('day');
			$run_q = $this->db->get('transactions');
		}
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
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
     * Get Transactions info by months
     * @return boolean
     */
    public function getTransByMonths(){
		if($this->db->platform() == "sqlite3"){
			$q = "SELECT 
				count(DISTINCT(ref)) as 'tot_trans', 
				SUM(quantity) as 'qty_sold', 
				SUM(totalPrice) as 'tot_earned',
				case cast (strftime('%m', transDate) as integer)
				  when 01 then 'Janvier'
				  when 02 then 'Février'
				  when 03 then 'Mars'
				  when 04 then 'Avril'
				  when 05 then 'Mai'
				  when 06 then 'Juin'
				  when 07 then 'Juillet'
				  when 08 then 'Août'
				  when 09 then 'Septembre'
				  when 10 then 'Octobre'
				  when 11 then 'Novembre'
				  when 12 then 'Decembre' end as month
			  FROM transactions
			  GROUP BY month
			  ORDER BY tot_earned DESC";
			  
		  $run_q = $this->db->query($q, []);
		}
		
		
        else{
			$this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", SUM(totalPrice) as "tot_earned", MONTHNAME(transDate) as "month"');
			$this->db->order_by('tot_earned', 'DESC');
			$this->db->group_by('month');
        
			$run_q = $this->db->get('transactions');
		}
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
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
     * Get Transactions info by years
     * @return boolean
     */
    public function getTransByYears(){
		if($this->db->platform() == "sqlite3" ){
			$q = "SELECT 
				count(DISTINCT(ref)) as 'tot_trans', 
				SUM(quantity) as 'qty_sold', 
				SUM(totalPrice) as 'tot_earned',
				strftime('%Y', transDate) as 'year'
			  FROM transactions
			  GROUP BY year
			  ORDER BY tot_earned DESC";
			  
		  $run_q = $this->db->query($q, []);
		}
		
		
        else{
			$this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", SUM(totalPrice) as "tot_earned", YEAR(transDate) as "year"');
			$this->db->order_by('tot_earned', 'DESC');
			$this->db->group_by('year');
			
			$run_q = $this->db->get('transactions');
		}
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
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
    * Selects most bought items
    * @return boolean
    */
    public function topDemanded(){
        $q = "SELECT items.name, SUM(transactions.quantity) as 'totSold' FROM items 
                INNER JOIN transactions ON items.code=transactions.itemCode GROUP BY transactions.itemCode ORDER BY totSold DESC LIMIT 5";

        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
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
     * Selects least bought items
     * @return boolean
     */
    public function leastDemanded(){
        $q = "SELECT items.name, SUM(transactions.quantity) as 'totSold' FROM items 
                INNER JOIN transactions ON items.code=transactions.itemCode GROUP BY transactions.itemCode ORDER BY totSold ASC LIMIT 5";

        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
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
     * Items that has brought highest income (in total)
     * @return boolean
     */
    public function highestEarners(){
        $q = "SELECT items.name, SUM(transactions.totalPrice) as 'totEarned' FROM items 
                INNER JOIN transactions ON items.code=transactions.itemCode 
                GROUP BY transactions.itemCode 
                ORDER BY totEarned DESC LIMIT 5";

        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
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
    * Items that has brought lowest income (in total)
    * @return boolean
    */
    public function lowestEarners(){
        $q = "SELECT items.name, SUM(transactions.totalPrice) as 'totEarned' FROM items 
               INNER JOIN transactions ON items.code=transactions.itemCode 
               GROUP BY transactions.itemCode 
               ORDER BY totEarned ASC LIMIT 5";
       
        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
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
     * selects all transactions done within the last 24hrs
     * @return boolean
     */
    public function totalSalesToday(){
        $q = "SELECT SUM(quantity) as 'totalTransToday' FROM transactions WHERE DATE(transDate) = CURRENT_DATE";
       
        $run_q = $this->db->query($q);
       
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->totalTransToday;
            }
        }

        else{
            return FALSE;
        }
    }
}
