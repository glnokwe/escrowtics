<?php
 /**
 * The Users Database Configuration class of the plugin.
 * Defines all DB interraction for Users Actions.
 * @since      1.0.0
 * @package    Escrowtics
 */	
	
	namespace Escrowtics\database; 
	
	defined('ABSPATH') or die();
	   
	class UsersConfig {
		
		private $escrowsTable;
		private $escrowMetaTable;
		private $transactionsLogsTable;
		private $notificationsTable;
		private $usersTable;
		private $invoicesTable;
		private $ticketsTable;     
		private $ticketMetaTable; 
	  
	  
        public function __construct()
        {
            global $wpdb; 
		    $this->escrowsTable          = $wpdb->prefix."escrowtics_escrows";
		    $this->escrowMetaTable       = $wpdb->prefix."escrowtics_escrow_meta";
	        $this->transactionsLogsTable = $wpdb->prefix."escrowtics_transactions_logs";
			$this->notificationsTable    = $wpdb->prefix."escrowtics_notifications";
			$this->usersTable            = $wpdb->prefix."escrowtics_users";
			$this->invoicesTable         = $wpdb->prefix."escrowtics_payment_invoices";
			$this->ticketsTable          = $wpdb->prefix."escrowtics_support_tickets";
			$this->ticketMetaTable       = $wpdb->prefix."escrowtics_tickets_meta";
        }
		
		
		//Notify Admin
		public function notifyAdmin($data){
            global $wpdb; 
            $wpdb->insert($this->notificationsTable, $data);
		
		}
		
		//Fetch last inserted user
        public function lastInsertedUserID() {
		   global $wpdb;
		   $sql = "SELECT user_id FROM $this->usersTable ORDER BY user_id DESC LIMIT 0, 1"; 
		   $last_insert_id = $wpdb->get_var($sql);
           return $last_insert_id;
        }

	    //Insert user
        public function insertUser($data) {
            global $wpdb;	
            $wpdb->insert($this->usersTable, $data);
	    }
	  
	  
        //Fetch user records to display on useres table
        public function displayUsers() {
		   global $wpdb;
           $sql = "SELECT * FROM $this->usersTable ORDER BY user_id DESC"; 
		   $data = $wpdb->get_results($sql, ARRAY_A);
           return $data;
        }
	  
	  
        //Get user info by ID
        public function getUserByID($id) {
		   global $wpdb;
           $sql = "SELECT * FROM $this->usersTable WHERE user_id = %d";
           $row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
           return $row[0];
        }
		
		//get cutomer id by email
        public function getUserIDByEmail($email) {
		   global $wpdb;
           $sql = "SELECT * FROM $this->usersTable WHERE email = %s";
           $row = $wpdb->get_results($wpdb->prepare($sql, $email), ARRAY_A);
           return $row[0]['user_id'];
        }
		
		 //Check if User Exist by Email
        public function checkUserByEmail($email){
		   global $wpdb; 
           $sql = "SELECT COUNT(*) FROM $this->usersTable WHERE email = %s";
		   $rowCount = $wpdb->get_var($wpdb->prepare($sql, $email));
           return $rowCount;
		   wp_die();
        }
	  
	
	    //Count Total Number of Rows   
        public function totalUserCount(){
           global $wpdb;  
           $sql = "SELECT COUNT(*) FROM $this->usersTable";
		   $rowCount = $wpdb->get_var($sql);
           return $rowCount;
        }
		
	    //Count Total Number of Escrows Per User  
        public function userEscrowsCount($username){
		   global $wpdb; 
           $sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE payer = %s";
		   $rowCount = $wpdb->get_var($wpdb->prepare($sql, $username));
           return $rowCount;
        }
		
		
		//Count Total Number of Escrows Per User  
        public function userEarningsCount($username){
		   global $wpdb; 
           $sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE earner = %s";
		   $rowCount = $wpdb->get_var($wpdb->prepare($sql, $username));
           return $rowCount;
        }
		
		
		//Get All User's Escrows
		public function userEscrows($username){
		   global $wpdb; 
           $sql = "SELECT * FROM $this->escrowsTable WHERE payer = %s";
		   $data = $wpdb->get_results($wpdb->prepare($sql, $username), ARRAY_A);
           return $data;
        }
		
		
		//Get All User's Earnings
		public function userEarnings($username){
		   global $wpdb; 
           $sql = "SELECT * FROM $this->escrowsTable WHERE earner = %s";
		   $data = $wpdb->get_results($wpdb->prepare($sql, $username), ARRAY_A);
           return $data;
        }
		
		//Count Total Escrow Meta Count 
        public function escrowMetaCount($id){
		    global $wpdb;  
            $sql = "SELECT COUNT(*) FROM $this->escrowMetaTable WHERE escrow_id = %d";
		    $rowCount = $wpdb->get_var($wpdb->prepare($sql, $id));
            return $rowCount;
        }
		
		
		//Fetch Escrow Meta by ID
        public function getEscrowMetaByID($id) {   
		    global $wpdb;
            $sql = "SELECT * FROM $this->escrowMetaTable WHERE escrow_id = %d";
            $row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
            return $row;
        }
		
		//Count User Tickets
		public function userTicketCount($username){
		   global $wpdb;  
		   $sql = "SELECT COUNT(*) FROM $this->ticketsTable WHERE user = %s";
		   $rowCount = $wpdb->get_var($wpdb->prepare($sql, $username));
		   return $rowCount;
		}
		
		//Get ticket info by ID
		public function getTicketByID($id) {
		   global $wpdb;
		   $sql = "SELECT * FROM $this->ticketsTable WHERE ticket_id = %d";
		   $row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
		   return $row[0];
		}
		
		//Fetch Ticket Meta by ID
		public function getTicketMetaByID($id) {   
			global $wpdb;
			$sql = "SELECT * FROM $this->ticketMetaTable WHERE ticket_id = %d";
			$row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
			return $row;
		}
		
		
		//Get All User's Tickets
		public function userTickets($username){
		   global $wpdb; 
		   $sql = "SELECT * FROM $this->ticketsTable WHERE user = %s";
		   $data = $wpdb->get_results($wpdb->prepare($sql, $username), ARRAY_A);
		   return $data;
		}
			
		//Fetch all escrows
        public function userTransactionLog(){
		    global $wpdb; 
			$sql = "SELECT * FROM $this->transactionsLogsTable WHERE user_id = %d ORDER BY id DESC";
            $data = $wpdb->get_results($wpdb->prepare($sql, get_current_user_id()), ARRAY_A);
            return $data;
        }
		
		
		//Count Total Log Per User  
        public function userLogCount(){
		    global $wpdb; 
            $sql = "SELECT COUNT(*) FROM $this->transactionsLogsTable WHERE user_id = %d";
		    $rowCount = $wpdb->get_var($wpdb->prepare($sql, get_current_user_id()));
            return $rowCount;
        }
		
		
		//Fetch all escrows
        public function userFilteredInvoices($subject){
		    global $wpdb; 
			$sql = "SELECT * FROM $this->invoicesTable WHERE user_id = %d AND product = %s ORDER BY id DESC";
            $data = $wpdb->get_results($wpdb->prepare($sql, get_current_user_id(), $subject), ARRAY_A);
            return $data;
        }
		
		
		//Count Total Log Per User  
        public function userFilteredInvoicesCount($subject){
		    global $wpdb; 
            $sql = "SELECT COUNT(*) FROM $this->invoicesTable WHERE user_id = %d AND product = %s";
		    $rowCount = $wpdb->get_var($wpdb->prepare($sql, get_current_user_id(), $subject));
            return $rowCount;
        }
	  
   
       //Update user data
        public function updateUser($data) {
		    global $wpdb;
		    $wpdb->update($this->usersTable, $data, array('user_id' => $data['user_id']) );
        }
	   
	  
        //Delete user data from user table
        public function deleteUser($userid) {
            global $wpdb;	
		    $where = array('user_id' => $userid); 
		    $wpdb->delete($this->usersTable, $where);
			$wpdb->delete($this->notificationsTable, $where);
			$wpdb->delete($this->escrowsTable, $where);
			wp_delete_user($userid);
        }
	  
	  
	    //Delete Multiple user data from user table
        public function deleteUsers($multid) {
			global $wpdb;
			$ids = explode(',', $multid);
			foreach	($ids as $id) {
				$where = array('user_id' => $id); 
				$wpdb->delete($this->usersTable, $where);
				$wpdb->delete($this->notificationsTable, $where);
				$wpdb->delete($this->escrowsTable, $where);
				wp_delete_user($id);
			}
        }
	  
	  
	
	    //Verify User Email  
        public function verifyUserEmail($UserEmail) {
            global $wpdb; 	
		    $sql = "SELECT COUNT(*) FROM $this->usersTable WHERE email = %s";
		    $rowCount = $wpdb->get_var($wpdb->prepare($sql, $UserEmail));
 
            if($rowCount == 0){
             echo "not_taken";
            } else {
             echo "taken";
            }
        }
		

	 
	
   }
