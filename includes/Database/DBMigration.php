<?php
/**
 * Database Migration class of the plugin.
 * Handles database table creation and setup on activation.
 *
 * @since 1.0.0
 * @package Escrowtics
 */

namespace Escrowtics\Database;

defined('ABSPATH') || exit;

class DBMigration {
	
    private $tables;

    /**
     * Constructor to initialize table names.
     */
    public function __construct()
    {
        global $wpdb;

        $this->tables = [
            'escrowsTable'           => $wpdb->prefix . 'escrowtics_escrows',
            'escrowMetaTable'        => $wpdb->prefix . 'escrowtics_escrow_meta',
			'transactionLogTable'  	 => $wpdb->prefix . 'escrowtics_transactions_log',
            'dbbackupTable'          => $wpdb->prefix . 'escrowtics_dbbackups',
            'notificationsTable'     => $wpdb->prefix . 'escrowtics_notifications',
            'invoicesTable'          => $wpdb->prefix . 'escrowtics_invoices',
            'disputesTable'          => $wpdb->prefix . 'escrowtics_disputes',
            'disputesMetaTable'      => $wpdb->prefix . 'escrowtics_disputes_meta',
        ];
    }

    /**
     * Registers hooks for database migration.
     */
    public function register()
    {
        add_action('escrot_db_migration', [$this, 'createDBTables']);
    }

    /**
     * Creates database tables using dbDelta.
     */
    public function createDBTables(){
		
        global $wpdb;
        
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sqls = [];
		
		$charset_collate = $wpdb->get_charset_collate();

        // Define the SQL for each table
        $sqls[] = "CREATE TABLE {$this->tables['escrowsTable']} (
					escrow_id INT(30) NOT NULL AUTO_INCREMENT,
					ref_id VARCHAR(30) NOT NULL,
					payer VARCHAR(200) NOT NULL,
					earner VARCHAR(200) NOT NULL,
					creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (escrow_id)
				) $charset_collate;";

        $sqls[] = "CREATE TABLE {$this->tables['escrowMetaTable']} (
					meta_id INT(30) NOT NULL AUTO_INCREMENT,
					escrow_id INT(30) NOT NULL,
					amount VARCHAR(500) NOT NULL,
					payable_amount VARCHAR(500) NOT NULL,
					title VARCHAR(500) NOT NULL,
					details LONGTEXT NOT NULL,
					status VARCHAR(5000) NOT NULL,
					creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (meta_id)
				) $charset_collate;"; 
				
		$sqls[] = "CREATE TABLE {$this->tables['transactionLogTable']} (
					log_id INT(30) NOT NULL AUTO_INCREMENT,
					ref_id VARCHAR(30) NOT NULL,
					user_id VARCHAR(30) NOT NULL,
					subject VARCHAR(30) NOT NULL,
					details LONGTEXT NOT NULL,
					amount VARCHAR(500) NOT NULL,
					balance VARCHAR(500) NOT NULL,
					creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (log_id)
				) $charset_collate;"; 		
				
		$sqls[] = "CREATE TABLE {$this->tables['dbbackupTable']} (
					backup_id INT(30) NOT NULL AUTO_INCREMENT,
					creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					backup_url VARCHAR(500) NOT NULL,
					backup_path VARCHAR(1000) NOT NULL,
					mode VARCHAR(30) NOT NULL,
					PRIMARY KEY (backup_id)
				) $charset_collate;";

        $sqls[] = "CREATE TABLE {$this->tables['notificationsTable']} (
					notification_id INT(30) NOT NULL AUTO_INCREMENT,
					user_id VARCHAR(30) NOT NULL,
					subject_id VARCHAR(30) NOT NULL,
					subject VARCHAR(250) NOT NULL,
					message VARCHAR(1000) NOT NULL,
					status INT(30) NOT NULL,
					date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (notification_id)
				) $charset_collate;";

        $sqls[] = "CREATE TABLE {$this->tables['invoicesTable']} (
					id INT(30) NOT NULL AUTO_INCREMENT,
					code VARCHAR(300) NOT NULL,
					user_id VARCHAR(30) NOT NULL,
					address VARCHAR(300) NOT NULL,
					amount VARCHAR(30) NOT NULL,
					payment_method VARCHAR(50) NOT NULL,
					status VARCHAR(250) NOT NULL,
					product VARCHAR(30) NOT NULL,
					ip VARCHAR(1000) NOT NULL,
					creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (id)
				) $charset_collate;";

		$sqls[] = "CREATE TABLE {$this->tables['disputesTable']} (
					dispute_id INT(30) NOT NULL AUTO_INCREMENT,
					ref_id VARCHAR(100) NOT NULL,
					escrow_id VARCHAR(100) NOT NULL,
					reason VARCHAR(300) NOT NULL,
					complainant VARCHAR(300) NOT NULL,
					accused VARCHAR(300) NOT NULL,
					accused_role VARCHAR(300) NOT NULL,
					resolution_requested VARCHAR(500) NOT NULL,
					status VARCHAR(250) NOT NULL,
					priority VARCHAR(30) NOT NULL,
					last_updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (dispute_id)
				) $charset_collate;";

		$sqls[] = "CREATE TABLE {$this->tables['disputesMetaTable']} (
					meta_id INT(30) NOT NULL AUTO_INCREMENT,
					dispute_id VARCHAR(30) NOT NULL,
					meta_value LONGTEXT NOT NULL,
					meta_type VARCHAR(30) NOT NULL,
					author VARCHAR(100) NOT NULL,
					creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (meta_id)
				) $charset_collate;";

        
        foreach ($sqls as $sql) {
            dbDelta($sql); //create table
        }
		
		
    }
	
}
