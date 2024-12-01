<?php
/**
 * The Tickets manager class of the plugin.
 * Defines all Tickets Actions.
 * @since      1.0.0
 * @package    Escrowtics
 */
	
namespace Escrowtics; 

use Escrowtics\database\SupportConfig; 

defined('ABSPATH') or die();
	
class SupportActions extends SupportConfig {
		
		
	public function register() {
	
		//Register Hooks 
		add_action( 'wp_ajax_escrot_tickets', array($this, 'actionDisplayTickets' ));
		add_action( 'wp_ajax_escrot_tickets_tbl', array($this, 'actionReloadTickets' ));
		add_action( 'wp_ajax_escrot_ticket_profile', array($this, 'actionDisplayTicketProfile' ));
		add_action( 'wp_ajax_escrot_insert_ticket', array($this, 'actionInsertTicket' ));
		add_action( 'wp_ajax_escrot_update_ticket', array($this, 'actionUpdateTicket' ));
		add_action( 'wp_ajax_escrot_ticket_data', array($this, 'actionGetTicketByID' ));
		add_action( 'wp_ajax_escrot_del_ticket', array($this, 'actionDeleteTicket' ));
		add_action( 'wp_ajax_escrot_del_tickets', array($this, 'actionDeleteTickets' ));
		add_action( 'wp_ajax_escrot_export_tickets_excel', array($this, 'exportToExcel' ));
		add_action( 'wp_ajax_escrot_reply_ticket', array($this, 'actionReplyTicket' ));
	
	}	

		
	//Insert new ticket
	public function actionInsertTicket() {	
		
		if(!check_ajax_referer( 'escrot_ticket_nonce', 'nonce' )) {
			wp_send_json(['status'=>'Error: Invalid nonce. Try reloading the page']); 
		}
		
		$form_data = ['user', 'subject', 'priority', 'department'];
		$data = escrot_get_form_data($form_data);
		
		$data["status"]  = 0;
		$data["ref_id"]  = escrot_unique_id();
		if(is_escrot_front_user()){
			$user_id = get_current_user_id();
			$username = escrot_get_user_data($user_id)['username'];
			$data["user"] = $username;
		} else {
			$user = get_user_by( 'login', $data["user"]);
			$user_id = $user->ID;
		}
		
		$this->insertData($this->ticketsTable, $data);
		
		$meta_val = ['message', 'attachment'];
		$meta_val_data = escrot_get_form_data($meta_val);
		
		$ticket_id = $this->lastInsertedTicketID();
		
		foreach($meta_val as $val){
			
			$meta_data = ['ticket_id' => $ticket_id];
			
			if(is_escrot_front_user()){
				$meta_data["author"] = 'User'; 
				$file = escrot_uploader('attachment');
			} else {
				$meta_data["author"] = 'Admin';
				$file = $meta_val_data['attachment'];
			} 
			
			if($val == 'message'){
				$meta_data["meta_type"] = "Text";
				$meta_data["meta_value"] = $meta_val_data['message'];
			} else {
				$meta_data["meta_type"] = "File";
				$meta_data["meta_value"] = $file;
			}
			
				
			if(!empty($meta_data["meta_value"])){
				$this->insertData($this->ticketsMetaTable, $meta_data);
			}
		}
		
		escrot_notify_new_ticket($ticket_id, $data["ref_id"], $username, $user_id);
		
		wp_send_json(['status'=>'success']);
  
	}


	//Display Tickets
	public function actionDisplayTickets() {	
	    $data_count = $this->totalTicketCount();
		$data  = $this->displayTickets();
		include_once ESCROT_PLUGIN_PATH."templates/support/tickets.php";		
		wp_die();
	}
	
	
	//Reload Tickets
	public function actionReloadTickets() {
		if(is_escrot_front_user()){
			$user_id = get_current_user_id();
			$username = escrot_get_user_data($user_id)['username'];
			$data_count = $this->userTicketCount($username);
			$data = $this->userTickets($username);
		} else {
			$data_count = $this->totalTicketCount();
			$data  = $this->displayTickets();
		} 
		
		include_once ESCROT_PLUGIN_PATH."templates/support/tickets-table.php";	
		wp_die();
	}
	
	//Edit Ticket Record (pull existing data into form) 
	public function actionGetTicketByID() {	
	  if(isset($_POST['TicketId'])) {
		$TicketId = $_POST['TicketId'];
		$row = $this->getTicketByID($TicketId);
		wp_send_json(['data' => $row]);
	  }
	}
	

	//Update Ticket Account
	public function actionUpdateTicket() {	
/* 		if(!check_ajax_referer( 'escrot_ticket_status_nonce', 'nonce' )) {
			wp_send_json('Error: Invalid nonce. Try reloading the page'); 
		} */
		$form_data = ['ticket_id', 'status'];
		$data = escrot_get_form_data($form_data);
		$this->updateTicket($data);
		wp_send_json(['status' => 'success', 'message' => __('Status Updated Successfully', 'escrowtics')]);
	}


	//Deletet Record  
	public function actionDeleteTicket() {			
	   if (isset($_POST['TicketID'])) {
		  $TicketID = $_POST['TicketID'];
		  $this->deleteTicket($TicketID);
		  wp_die();
	   }
	}   

	//Deletet Multiple Records  
	public function actionDeleteTickets() {		
	   if (isset($_POST['multTicketid'])) {
		  $multTicketid = $_POST['multTicketid'];
		  $this->deleteTickets($multTicketid);
		  wp_die();
	   }
	}   

	//Export to excel
	public function exportToExcel() {	
		
		$exportData = $this->displayTickets();

		$output = '
		<table border="1">
			<tr style="font-weight:bold">
				<th>ID.</th>
				<th>Ref ID</th>
				<th>User ID</th>
				<th>Department</th>
				<th>Subject</th>
				<th>Status</th>
				<th>Priority</th>
				<th>Last Updated</th>
		    </tr>';
		foreach ($exportData as $export) {
		  $output .= '
		    <tr>
				<td>'.$export['ticket_id'].'</td>
				 <td>'.$export['ref_id'].'</td>
				 <td>'.$export['user_id'].'</td>
				 <td>'.$export['department'].'</td>
				 <td>'.$export['subject'].'</td>
				 <td>'.$export['status'].'</td>
				 <td>'.$export['priority'].'</td>
				 <td>'.$export['last_updated'].'</td>
		    </tr>';
		}  
		$output .= '</table>';
		
		wp_send_json(['data'=>$output, 'lable' => 'tickets']);
	  
	} 



		//Reply Ticket
		public function actionReplyTicket() {
			
			if(!check_ajax_referer( 'escrot_ticket_chat_nonce', 'nonce' )) {
				wp_send_json(['status'=>'Error: Invalid nonce. Try reloading the page']); 
			}
			
			$form_data = ['message', 'ticket_id', 'attachment'];
			$data = escrot_get_form_data($form_data);
			
			$meta_val = ['message', 'attachment'];
			
			foreach($meta_val as $val){
				
				$meta_data = ['ticket_id' => $data['ticket_id']];
				
				if(is_escrot_front_user()){
					$meta_data["author"] = 'User'; 
					$file = escrot_uploader('attachment');
				} else {
					$meta_data["author"] = 'Admin';
					$file = $data['attachment'];
				} 
				
				if($val == 'message'){
					$meta_data["meta_type"] = "Text";
					$meta_data["meta_value"] = $data['message'];
				} else {
					$meta_data["meta_type"] = "File";
					$meta_data["meta_value"] = $file;
				}
				
					
				if(!empty($meta_data["meta_value"])){
					$this->insertData($this->ticketsMetaTable, $meta_data);
				}
			}
			
			
			//Response data (for reload)
			$output  = "";
			$ticket_meta = $this->getTicketMetaByID($data['ticket_id']);
		    $data = $this->getTicketByID($data['ticket_id']);
			include ESCROT_PLUGIN_PATH."templates/support/reload-chat.php";
			echo $output;
            wp_die();			
		}	


}