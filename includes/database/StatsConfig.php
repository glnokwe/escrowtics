<?php
 /**
 * The Stats Database Configuration class of the plugin.
 * Defines all DB interraction for Stats variables.
 * @since      1.0.0
 * @package    Escrowtics
 */
	defined('ABSPATH') or die();
	
	class StatsConfig {
		
		public $escrowsTable;
		public $escrowMetaTable;
		public $transactionsLogsTable;
		public $dbbackupTable;
		public $notificationsTable;
		public $usersTable;
		
        public function __construct()
        {
            global $wpdb; 
			$this->escrowsTable          = $wpdb->prefix."escrowtics_escrows";
			$this->escrowMetaTable       = $wpdb->prefix."escrowtics_escrow_meta";
			$this->transactionsLogsTable = $wpdb->prefix."escrowtics_transactions_logs";
			$this->dbbackupTable         = $wpdb->prefix."escrowtics_dbbackups";
			$this->notificationsTable    = $wpdb->prefix."escrowtics_notifications";
			$this->usersTable            = $wpdb->prefix."escrowtics_users";
		
        }
	  
		//Count escrows
		public function totalEscrowCount(){
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
		public function totalUserCount(){
			 global $wpdb; 
			 $sql = "SELECT COUNT(*) FROM $this->usersTable";
			 $rowCount = $wpdb->get_var($sql);
			 return $rowCount;
		}
		
		
		// Get total number of Users avaible
		public function totalBalance(){
			if($this->totalUserCount() > 0){
				global $wpdb; 
				$sql = "SELECT SUM(balance) FROM $this->usersTable";
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
