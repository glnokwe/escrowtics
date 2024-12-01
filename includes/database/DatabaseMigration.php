<?php
/**
 * Database Migration class of the plugin.
 * Creates all database tables on activation.
 * @since      1.0.0
 * @package    Escrowtics
 */
	
    namespace Escrowtics\database;
	
	defined('ABSPATH') or die();

    class DatabaseMigration {
	
			public $escrowsTable;
		    public $escrowMetaTable;
	        public $transactionsLogsTable;
			public $dbbackupTable;
			public $notificationsTable;
			public $usersTable;
			public $invoicesTable;
			public $ticketsTable;     
			public $ticketsMetaTable; 
	
	
	    public function __construct() {
			
            global $wpdb; 
			$this->escrowsTable           = $wpdb->prefix."escrowtics_escrows";
		    $this->escrowMetaTable        = $wpdb->prefix."escrowtics_escrow_meta";
	        $this->transactionsLogsTable  = $wpdb->prefix."escrowtics_transactions_logs";
			$this->dbbackupTable          = $wpdb->prefix."escrowtics_dbbackups";
			$this->notificationsTable     = $wpdb->prefix."escrowtics_notifications";
			$this->usersTable             = $wpdb->prefix."escrowtics_users";
			$this->invoicesTable          = $wpdb->prefix."escrowtics_payment_invoices";
			$this->ticketsTable           = $wpdb->prefix."escrowtics_support_tickets";
			$this->ticketsMetaTable       = $wpdb->prefix."escrowtics_tickets_meta";
		    
        }
	

	    public function register(){
		
	       add_action( 'escrot_db_migration', array( $this, 'createDBtables' ) );
		
	    }


        public function createDBtables() {
		    
            global $wpdb;
			
			//Get All Escrowtics Table Names From the Database			
	        $tables = $wpdb->get_col("SHOW TABLES like '{$wpdb->prefix}escrowtics%'");
			
	
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
             
			if(!in_array($this->escrowsTable, $tables)){ 
               $sql = "CREATE TABLE $this->escrowsTable (
               escrow_id int NOT NULL AUTO_INCREMENT,
			   ref_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
               earner varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
               payer varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
               creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
               UNIQUE KEY id (escrow_id)
               ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
               dbDelta($sql);
            }
			
			if(!in_array($this->escrowMetaTable, $tables)){ 
                $sql = "CREATE TABLE $this->escrowMetaTable (
                 meta_id int NOT NULL AUTO_INCREMENT,
                 escrow_id int NOT NULL,
                 amount varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 title varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 details longtext CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 status varchar(5000) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (meta_id)
                ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
                dbDelta($sql);
            }

            if(!in_array($this->dbbackupTable, $tables)){ 
                $sql = "CREATE TABLE $this->dbbackupTable (
                backup_id int NOT NULL AUTO_INCREMENT,
                creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                backup_url varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                backup_path varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                mode varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                UNIQUE KEY id (backup_id)
                ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
                dbDelta($sql);
			}

            if(!in_array($this->transactionsLogsTable, $tables)){ 
                $sql = "CREATE TABLE  $this->transactionsLogsTable(
                id int NOT NULL AUTO_INCREMENT,
				ref_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				user_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				subject varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				details longtext CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				amount varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                balance varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (id)
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
                dbDelta($sql);
            }

            if(!in_array($this->notificationsTable, $tables)){ 
                $sql = "CREATE TABLE $this->notificationsTable (
                notification_id int NOT NULL AUTO_INCREMENT,
                user_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
                subject_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                subject varchar(250) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                message varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                status int NOT NULL,
                date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (notification_id)
                ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
                dbDelta($sql);
            }
			
			if(!in_array($this->usersTable, $tables)){ 
                $sql = "CREATE TABLE $this->usersTable (
                 id int NOT NULL AUTO_INCREMENT,
				 user_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 username varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                 firstname varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                 lastname varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                 email varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                 phone varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 address varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 country varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                 company varchar(200) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 website varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 bio longtext CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                 user_image varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 balance varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 status varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				 creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                 UNIQUE KEY id (id)
                 ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
                dbDelta($sql);
            }

            if(!in_array($this->invoicesTable, $tables)){ 
                $sql = "CREATE TABLE $this->invoicesTable (
                id int(30) NOT NULL AUTO_INCREMENT,
				code varchar(300) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				user_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                address varchar(300) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
                amount varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                status varchar(250) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				product varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                ip varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (id)
                ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
                dbDelta($sql);
            }
			
			
			if(!in_array($this->ticketsTable, $tables)){ 
                $sql = "CREATE TABLE $this->ticketsTable (
                ticket_id int(30) NOT NULL AUTO_INCREMENT,
				ref_id varchar(300) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				user varchar(300) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                department varchar(300) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
                subject varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                status varchar(250) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
				priority varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                last_updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (ticket_id)
                ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
                dbDelta($sql);
            }
			
			
			if(!in_array($this->ticketsMetaTable, $tables)){ 
                $sql = "CREATE TABLE $this->ticketsMetaTable (
                meta_id int NOT NULL AUTO_INCREMENT,
				ticket_id varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                meta_value longtext CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                meta_type varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                author varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
                creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (meta_id)
                ) DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci";
                dbDelta($sql);
            }
            

       }
 
 
    }











