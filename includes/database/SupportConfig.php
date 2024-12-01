<?php
 /**
 * The Tickets Database Configuration class of the plugin.
 * Defines all DB interraction for Tickets Actions.
 * @since      1.0.0
 * @package    Escrowtics
 */	
	
namespace Escrowtics\database; 

defined('ABSPATH') or die();
   
class SupportConfig {
  
	public $ticketsMetaTable; 
	public $usersTable;
	public $ticketsTable;
  
	public function __construct() {
		global $wpdb; 
		$this->ticketsMetaTable = $wpdb->prefix."escrowtics_tickets_meta";
		$this->usersTable       = $wpdb->prefix."escrowtics_users";
		$this->ticketsTable     = $wpdb->prefix."escrowtics_support_tickets";
	}
	

	//Insert user
	public function insertData($table, $data) {
		global $wpdb;	
		$wpdb->insert($table, $data);
	}
	
	//Fetch last inserted ticket
	public function lastInsertedTicketID() {
	   global $wpdb;
	   $sql = "SELECT ticket_id FROM $this->ticketsTable ORDER BY ticket_id DESC LIMIT 0, 1"; 
	   $last_insert_id = $wpdb->get_var($sql);
	   return $last_insert_id;
	}

  
	//Fetch user records to display on useres table
	public function displayTickets() {
	   global $wpdb;
	   $sql = "SELECT * FROM $this->ticketsTable ORDER BY ticket_id DESC"; 
	   $data = $wpdb->get_results($sql, ARRAY_A);
	   return $data;
	}
  
  
	//Get user info by ID
	public function getTicketByID($id) {
	   global $wpdb;
	   $sql = "SELECT * FROM $this->ticketsTable WHERE ticket_id = %d";
	   $row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
	   return $row[0];
	}
  

	//Count Total Number of Tickets 
	public function totalTicketCount(){
	   global $wpdb;  
	   $sql = "SELECT COUNT(*) FROM $this->ticketsTable";
	   $rowCount = $wpdb->get_var($sql);
	   return $rowCount;
	}
	
	
	//Get All User's Tickets
	public function userTickets($username){
	   global $wpdb; 
	   $sql = "SELECT * FROM $this->ticketsTable WHERE user = %s";
	   $data = $wpdb->get_results($wpdb->prepare($sql, $username), ARRAY_A);
	   return $data;
	}
	
	//Count User Tickets
	public function userTicketCount($username){
	   global $wpdb;  
	   $sql = "SELECT COUNT(*) FROM $this->ticketsTable WHERE user = %s";
	   $rowCount = $wpdb->get_var($wpdb->prepare($sql, $username));
	   return $rowCount;
	}
	
	//Count Total Ticket Meta Count 
	public function ticketMetaCount($id){
		global $wpdb;  
		$sql = "SELECT COUNT(*) FROM $this->ticketsMetaTable WHERE ticket_id = %d";
		$rowCount = $wpdb->get_var($wpdb->prepare($sql, $id));
		return $rowCount;
	}
	
	
	//Fetch Ticket Meta by ID
	public function getTicketMetaByID($id) {   
		global $wpdb;
		$sql = "SELECT * FROM $this->ticketsMetaTable WHERE ticket_id = %d";
		$row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
		return $row;
	}
  

   //Update user data
	public function updateTicket($data) {
		global $wpdb;
		$wpdb->update($this->ticketsTable, $data, array('ticket_id' => $data['ticket_id']) );
	}
   
  
	//Delete user data from user table
	public function deleteTicket($userid) {
		global $wpdb;	
		$where = array('ticket_id' => $userid); 
		$wpdb->delete($this->ticketsTable, $where);
		$wpdb->delete($this->ticketsMetaTable, $where);
	}
  
  
	//Delete Multiple user data from user table
	public function deleteTickets($multid) {
		global $wpdb;
		$ids = explode(',', $multid);
		foreach	($ids as $id) {
			$where = array('ticket_id' => $id); 
			$wpdb->delete($this->ticketsTable, $where);
			$wpdb->delete($this->ticketsMetaTable, $where);
		}
	}

 

}
