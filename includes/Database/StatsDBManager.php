<?php
 /**
 * The Stats Database Interaction class of the plugin.
 * Defines all DB interraction for Stats variables.
 * @since      1.0.0
 * @package    Escrowtics
 */
	defined('ABSPATH') || exit;
	
	class StatsDBManager {
		
		public $escrowsTable;
		public $escrowMetaTable;
		public $transactionsLogTable;
		public $dbbackupTable;
		public $notificationsTable;
		public $usersTable;
		
        public function __construct()
        {
            global $wpdb; 
			$this->escrowsTable          = $wpdb->prefix."escrowtics_escrows";
			$this->escrowMetaTable       = $wpdb->prefix."escrowtics_escrow_meta";
			$this->transactionsLogTable  = $wpdb->prefix."escrowtics_transactions_log";
			$this->dbbackupTable         = $wpdb->prefix."escrowtics_dbbackups";
			$this->notificationsTable    = $wpdb->prefix."escrowtics_notifications";
		
        }
	  
		//Count escrows
		public function getTotalEscrowCount(){
			 global $wpdb; 
			 $sql = "SELECT COUNT(*) FROM $this->escrowsTable";
			 $rowCount = $wpdb->get_var($sql);
			 return $rowCount;
		}
		  
		  
		//Count last updated escrows (within 24hrs)
		public function recentEscrowCount(){
			 global $wpdb;  
			 $oneday = date('Y-m-d H:i:s', strtotime( "-1 day" ));  
			 $sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE creation_date > %d";
			 $rowCount = $wpdb->get_var($wpdb->prepare($sql, $oneday));
			 return $rowCount;
		}


		// Get top 10 Escrow Payers
		public function topEscrowPayers(){
			 global $wpdb;	
			 $sql = "SELECT payer, count(*) FROM $this->escrowsTable GROUP BY payer ORDER BY `count(*)` DESC LIMIT 10";
			 $data = $wpdb->get_results($sql, ARRAY_A);
			 return $data;
		}
		
		
		// Get top 10 Escrow Earners
		public function topEscrowEarners(){
			 global $wpdb;	
			 $sql = "SELECT earner, count(*) FROM $this->escrowsTable GROUP BY earner ORDER BY `count(*)` DESC LIMIT 10";
			 $data = $wpdb->get_results($sql, ARRAY_A);
			 return $data;
		}
		  
		  
		//Count Escrows per Month for a Specific Year
		public function monthlyEscrowsPerYr($month, $yr){
			 global $wpdb;		   
			 $sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE EXTRACT(MONTH FROM creation_date) = %d AND EXTRACT(YEAR FROM creation_date) = %d";
			 $rowCount =  $wpdb->get_var($wpdb->prepare($sql, $month, $yr));
			 return $rowCount;
		}
		  
		  
		  
		// Get total number of Users avaible
		public function getTotalUserCount() {
			$user_counts = count_users();

			// Check if the role exists in the counts
			if (isset($user_counts['avail_roles']['escrowtics_user'])) {
				return $user_counts['avail_roles']['escrowtics_user'];
			}

			// If no users with the role exist, return 0
			return 0;
		}
			
		
		// Get total amount in active escrow transactions 
		public function totalAmtInEscrowsTransactions(){
			if($this->getTotalEscrowCount() > 0){
				global $wpdb; 
				$sql = "SELECT SUM(amount) FROM $this->escrowMetaTable WHERE status = 'Pending'";
				$bal = $wpdb->get_var($sql);
				return $bal;
			} else {
				return 0;
			}
			 
		}
		
	  
	   //Count Database Backups
        public function dbBackupsCount(){
		    global $wpdb; 
            $sql = "SELECT COUNT(*) FROM $this->dbbackupTable";
		    $rowCount = $wpdb->get_var($sql);
            return $rowCount;
        }
	    
	   
	   
   }
