<?php
 /**
 * Escrows Database Configuration class of the plugin.
 * Defines all DB interraction for Escrow Actions.
 * @since      1.0.0
 * @package    Escrowtics
 */
 
 
namespace Escrowtics\database; 	

defined('ABSPATH') or die();

if (!class_exists('WP_List_Table')) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

use WP_List_Table;
   
class EscrowConfig extends WP_List_Table {
  
	public $escrowsTable;
	public $escrowMetaTable;
	public $transactionsLogsTable;
	public $dbbackupTable;
	public $notificationsTable;
	public $usersTable;
	public $invoicesTable;
	
	public function __construct()
	{
		global $wpdb; 
		$this->escrowsTable          = $wpdb->prefix."escrowtics_escrows";
		$this->escrowMetaTable       = $wpdb->prefix."escrowtics_escrow_meta";
		$this->transactionsLogsTable = $wpdb->prefix."escrowtics_transactions_logs";
		$this->dbbackupTable         = $wpdb->prefix."escrowtics_dbbackups";
		$this->notificationsTable    = $wpdb->prefix."escrowtics_notifications";
		$this->usersTable            = $wpdb->prefix."escrowtics_users";
		$this->invoicesTable         = $wpdb->prefix."escrowtics_payment_invoices";
	
	}
	
	
	//Fetch Last Inserted ID
	public function lastID($id, $table) {
	   global $wpdb;
	   $sql = "SELECT $id FROM $table ORDER BY $id DESC LIMIT 0, 1"; 
	   $last_insert_id = $wpdb->get_var($sql);
	   return $last_insert_id;
	}
	
	
	//Insert data into database
	public function insertData($table, $data){
		global $wpdb; 
		$wpdb->insert($table, $data);
	}

	//Update Escrow
	public function updateData($table, $data, $where) {
		global $wpdb;
		$wpdb->update($table, $data, $where);
	}

	
	//Fetch all escrows
	public function displayEscrows(){
		global $wpdb; 
		$sql = "SELECT * FROM $this->escrowsTable ORDER BY escrow_id DESC";
		$data = $wpdb->get_results($sql, ARRAY_A);
		return $data;
	}
	
	
	
	//Fetch recent escrows (first 5)
	public function displayDashEscrows(){
		global $wpdb; 
		$sql ="SELECT * FROM $this->escrowsTable ORDER BY escrow_id DESC LIMIT 0, 7";
		$data = $wpdb->get_results($sql, ARRAY_A);
		return $data;
	}

  
	//Fetch single Escrow by ID
	public function getEscrowByID($id) {   
		global $wpdb;
		$sql = "SELECT * FROM $this->escrowsTable WHERE escrow_id = %d";
		$row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
		return $row[0];
	}
  
	//Count all escrows.
	public function totalEscrowCount(){
		global $wpdb;  
		$sql = "SELECT COUNT(*) FROM $this->escrowsTable";
		$rowCount = $wpdb->get_var($sql);
		return $rowCount;
	}
	
	
	//Check Earner already exist in payer's escrow list.
	public function earnerExistInPayerList($payer, $earner){
		global $wpdb;  
		$sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE payer = %s AND earner = %s";
		$rowCount = $wpdb->get_var($wpdb->prepare($sql, [$payer, $earner]));
		if($rowCount > 0){
			return true;
		} else {
			return false;
		}
	}
	
	//Check if Escrow Exist
	public function checkEscrow($id){
	   global $wpdb; 
	   $sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE escrow_id = %d";
	   $rowCount = $wpdb->get_var($wpdb->prepare($sql, $id));
	   return $rowCount;
	   wp_die();
	}
	
  
	//Delete escrow and associated data
	public function deleteEscrow($escrow_id) {
		
		global $wpdb;
	 
		$where = array('escrow_id' => $escrow_id); 
		$where_noty = array('subject_id' => $escrow_id);
		$wpdb->delete($this->escrowsTable, $where);
		$wpdb->delete($this->escrowMetaTable, $where);
		$wpdb->delete($this->notificationsTable, $where_noty);
	 
	}
	
	// Delete Multiple Escrows and associated data
	public function deleteEscrows($multid) {
		
		global $wpdb;
		$ids = explode(',', $multid);
		foreach	($ids as $id) {
			$where = array('escrow_id' => $id); 
			$where_noty = array('subject_id' => $id);
			$wpdb->delete($this->escrowsTable, $where);
			$wpdb->delete($this->escrowMetaTable, $where);
			$wpdb->delete($this->notificationsTable, $where_noty);
		}
	
	}
	
	//Delete escrow meta data
	public function deleteEscrowMeta($meta_id) {
		global $wpdb;
		$where = array('meta_id' => $meta_id); 
		$wpdb->delete($this->escrowMetaTable, $where);
	}
	
	
	//Delete multiple escrow meta data
	public function deleteEscrowMetas($multid) {
		global $wpdb;
		$ids = explode(',', $multid);
		foreach	($ids as $id) {
			$where = array('meta_id' => $id); 
			$wpdb->delete($this->escrowMetaTable, $where);
		}
	}
	
	//Get user data from user id
	public function getUserByID($id) {
	   global $wpdb;
	   $sql = "SELECT * FROM $this->usersTable WHERE user_id = %d";
	   $row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
	   return $row[0];
	}
	
	
	/********************** Escrows Meta  ************************************/
	
	//Count Total Escrow Meta Count 
	public function escrowMetaCount($id){
		global $wpdb;  
		$sql = "SELECT COUNT(*) FROM $this->escrowMetaTable WHERE escrow_id = %d";
		$rowCount = $wpdb->get_var($wpdb->prepare($sql, $id));
		return $rowCount;
	}
	
	
	//Fetch Meta by ID
	public function getMetaByID($id) {   
		global $wpdb;
		$sql = "SELECT * FROM $this->escrowMetaTable WHERE meta_id = %d";
		$row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
		return $row[0];
	}
	
	//Fetch Escrow Meta by ID
	public function getEscrowMetaByID($id) {   
		global $wpdb;
		$sql = "SELECT * FROM $this->escrowMetaTable WHERE escrow_id = %d";
		$row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
		return $row;
	}
	
	
	//Fetch all escrows
	public function displayEscrowMeta($id){
		global $wpdb; 
		$sql = "SELECT * FROM $this->escrowMetaTable WHERE escrow_id = %d ORDER BY escrow_id DESC";
		$data = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
		return $data;
	}
	

	
	/********************** User Escrows  ************************************/
	
	//Count Total Escrows Per User  
	public function userEscrowsCount($username){
		global $wpdb; 
		$sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE payer = %s";
		$rowCount = $wpdb->get_var($wpdb->prepare($sql, $username));
		return $rowCount;
	}
	
	
	//Get User's Escrows
	public function userEscrows($username){
		global $wpdb; 
		$sql = "SELECT * FROM $this->escrowsTable WHERE payer = %s";
		$data = $wpdb->get_results($wpdb->prepare($sql, $username), ARRAY_A);
		return $data;
	}
	
	
	
   
	/****************************************** ESCROW SEARCH ************************************************/
	
	public function escrowSearchCount($text) { 
		global $wpdb; 	 
		$sql = "SELECT COUNT(*) FROM $this->escrowsTable WHERE earner like '%".$text."%' OR payer like '%".$text."%'";
		$rowCount = $wpdb->get_var($sql);
		return $rowCount;
	}
	
	 public function escrowSearchData($text) { 
		global $wpdb; 	 
		$sql = "SELECT * FROM $this->escrowsTable WHERE earner like '%".$text."%' OR payer like '%".$text."%'";
		$data = $wpdb->get_results($sql, ARRAY_A);
		return $data;
	}
	
	
	
	/****************************************** Escrow Transaction Log ************************************************/
	
	//Add Log
	public function logTransaction(array $data){
		global $wpdb; 
		$wpdb->insert($this->transactionsLogsTable, $data);
	}
	
	
	//Fetch All Admin Logs
	public function displayTransactionLog(){
		global $wpdb; 
		$sql = "SELECT * FROM $this->transactionsLogsTable WHERE user_id = %d ORDER BY id DESC";
		$data = $wpdb->get_results($wpdb->prepare($sql, 0), ARRAY_A);
		return $data;
	}
	
	
	//Count All Admin Logs 
	public function transactionLogCount(){
		global $wpdb; 
		$sql = "SELECT COUNT(*) FROM $this->transactionsLogsTable WHERE user_id = %d";
		$rowCount = $wpdb->get_var($wpdb->prepare($sql, 0));
		return $rowCount;
	}
	
	
	/****************************************** Escrow Payment invoices ************************************************/
	
	
	//Fetch All Invoices
	public function filteredInvoicesData($subject){
		global $wpdb; 
		$sql = "SELECT * FROM $this->invoicesTable WHERE product = %s ORDER BY id DESC";
		$data = $wpdb->get_results($wpdb->prepare($sql, $subject), ARRAY_A);
		return $data;
	}
	
	
	//Count All Invoices 
	public function filteredInvoicesCount($subject){
		global $wpdb; 
		$sql = "SELECT COUNT(*) FROM $this->invoicesTable WHERE product = %s";
		$rowCount = $wpdb->get_var($wpdb->prepare($sql, $subject));
		return $rowCount;
	}
	

}


 
