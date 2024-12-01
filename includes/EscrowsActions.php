<?php
/**
* The Escrow manager class of the plugin.
* Defines all Escrow Actions
* @since      1.0.0
* @package    Escrowtics
*/

namespace Escrowtics;

use Escrowtics\database\EscrowConfig; 

defined('ABSPATH') or die();
	
class EscrowsActions extends EscrowConfig {
	
	
	public function register() {
	
		//Register hooks 
		add_action( 'wp_ajax_escrot_escrows', array($this, 'actionDisplayEscrows' ));
		add_action( 'wp_ajax_escrot_deposits', array($this, 'actionDisplayDeposits' ));
		add_action( 'wp_ajax_escrot_withdrawals', array($this, 'actionDisplayWithdrawals' ));
		add_action( 'wp_ajax_escrot_reload_withdrawals', array($this, 'reloadWithdrawals' ));
		add_action( 'wp_ajax_escrot_transaction_log', array($this, 'actionDisplayTransactionLog' ));
		add_action( 'wp_ajax_escrot_reload_escrow_tbl', array($this, 'actionReloadEscrows' ));
		add_action( 'wp_ajax_escrot_reload_escrow_meta_tbl', array($this, 'actionReloadEscrowMeta' ));
		add_action( 'wp_ajax_escrot_user_escrows', array($this, 'actionDisplayUserEscrows' ));
		add_action( 'wp_ajax_escrot_insert_escrow', array($this, 'actionInsertEscrow' ));
		add_action( 'wp_ajax_escrot_create_milestone', array($this, 'actionCreateMilestone' ));
		add_action( 'wp_ajax_nopriv_escrot_insert_escrow', array($this, 'actionInsertEscrow' ));
		add_action( 'wp_ajax_escrot_release_payment', array($this, 'releasePayment' ));
		add_action( 'wp_ajax_escrot_reject_amount', array($this, 'rejectAmount' ));
		add_action( 'wp_ajax_escrot_escrow_data', array($this, 'actionGetEscrowByID' ));
		add_action( 'escrot_get_escrow_data', array($this, 'actionGetEscrowByID' ));
		add_action( 'wp_ajax_escrot_del_escrow', array($this, 'actionDeleteEscrow' ));
		add_action( 'wp_ajax_escrot_del_escrows', array($this, 'actionDeleteEscrows' ));
		add_action( 'wp_ajax_escrot_del_escrow_meta', array($this, 'actionDeleteEscrowMeta' ));
		add_action( 'wp_ajax_escrot_del_escrow_metas', array($this, 'actionDeleteEscrowMetas' ));
		add_action( 'wp_ajax_escrot_export_escrows_excel', array($this, 'exportEscrowsToExcel' ));
		add_action( 'wp_ajax_escrot_export_escrow_meta_excel', array($this, 'exportEscrowMetaToExcel' ));
		add_action( 'wp_ajax_escrot_export_log_excel', array($this, 'exportLogToExcel' ));
		add_action( 'wp_ajax_escrot_export_withdrawals_excel', array($this, 'exportWithdrawalsToExcel' ));
		add_action( 'wp_ajax_escrot_export_deposits_excel', array($this, 'exportDepositsToExcel' ));
		add_action( 'wp_ajax_escrot_escrow_search', array($this, 'actionEscrowSearch' ));
		add_action( 'wp_ajax_escrot_reload_escrow_search', array($this, 'reloadSearchResults' ));
		add_action( 'wp_ajax_escrot_view_milestone_detail', array($this, 'actionViewMilestoneDetail' ));
		add_action( 'escrot_log_transaction', array($this, 'logTransaction' ));
		
		//Unique dashboard hooks
		add_action( 'wp_ajax_escrot_dash_escrows', array($this, 'actionDisplayDashEscrows' ));
		
	}
		
		
 	//Display Escrows Table
	public function actionDisplayEscrows() {
		$data_count = $this->totalEscrowCount();
		$data  = $this->displayEscrows();
		include ESCROT_PLUGIN_PATH."templates/escrows/escrows.php";  
		wp_die();
	}
	
	/*
	public function get_columns() {
		return [
			'id'    => 'ID',
			'name'  => 'Name',
			'email' => 'Email'
		];
	}

	public function prepare_items() {
		$this->items = [
			['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
			['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com']
		];
		$this->_column_headers = [$this->get_columns(), [], []];
		
	}
	
	
	public function column_default($item, $column_name) {
        return isset($item[$column_name]) ? esc_html($item[$column_name]) : '—';
    }

		
		
	//Display Escrows Table
	public function actionDisplayEscrows() {
		ob_start();
		$this->prepare_items();
		$this->display();
		$output = ob_get_clean();

		wp_send_json_success(['html' => $output]);
	} */
	
	
	//Display Deposits Table
	public function actionDisplayDeposits() {
		$invoices_count = $this->filteredInvoicesCount('User Deposit');
		$invoices = $this->filteredInvoicesData('User Deposit');
		include ESCROT_PLUGIN_PATH."templates/escrows/deposits.php";  
		wp_die();
	}
	
	
	//Display Withdrawals Table
	public function actionDisplayWithdrawals() {
		$invoices_count = $this->filteredInvoicesCount('User Withdrawal');
		$invoices = $this->filteredInvoicesData('User Withdrawal');
		include ESCROT_PLUGIN_PATH."templates/escrows/withdrawals.php";  
		wp_die();
	}
	
	
	//Reload Withdrawals Table
	public function reloadWithdrawals() {
		$isBackWithdrawPage = true;
		$invoices_count = $this->filteredInvoicesCount('User Withdrawal');
		$invoices = $this->filteredInvoicesData('User Withdrawal');
		include ESCROT_PLUGIN_PATH."templates/escrows/invoices-table.php";  
		wp_die();
	}
	
	
	
	//Display Transaction Log Table
	public function actionDisplayTransactionLog() {
		$log_count = $this->transactionLogCount();
		$log = $this->displayTransactionLog();
		include ESCROT_PLUGIN_PATH."templates/escrows/transaction-log.php";  
		wp_die();
	}
	
	
	//Reload Escrows Table
	public function actionReloadEscrows() {
		if(is_escrot_front_user()){
			$user_id = get_current_user_id();	
			$username = get_user_by("ID", $user_id)->user_login;
			$data_count = $this->userEscrowsCount($username);
			$data = $this->userEscrows($username);
		} else {
			$data_count = $this->totalEscrowCount();
			$data  = $this->displayEscrows();
		}
		include ESCROT_PLUGIN_PATH."templates/escrows/escrows-table.php";   
		wp_die();
	}
	
	
	//Reload Escrow Meta Table
	public function actionReloadEscrowMeta() {
		if(isset($_POST['escrow_id'])) { 
			$escrow_id = $_POST["escrow_id"];
			$escrow_meta_count = $this->escrowMetaCount($escrow_id);
			$meta_data  = $this->getEscrowMetaByID($escrow_id);
			include ESCROT_PLUGIN_PATH."templates/escrows/view-escrow-table.php";   
		    wp_die();
		}
		
	}

	//Display Dashboard Escrows Table
	public function actionDisplayDashEscrows() {
		include ESCROT_PLUGIN_PATH."templates/admin/dashboard/dashboard-escrows-table.php";  
		wp_die();
	}
	
	//Insert Escrow
	public function actionInsertEscrow() { 
	
		if(!check_ajax_referer( 'escrot_escrow_nonce', 'nonce' )) {
		    wp_send_json(['status' => __('Invalid nonce. Try reloading the page', 'escrowtics')]);
		}
		
		$form_data = ['escrow_id','earner','payer'];
		$data = escrot_get_form_data($form_data);
		$data["ref_id"] = escrot_unique_id();
		
		if(is_escrot_front_user()){//if front user, set payer to current user
			$user_id = get_current_user_id();
			$user = get_user_by( 'ID', $user_id);
			$data['payer'] = $user->user_login;
			
			if( !escrot_user_exist($data["earner"]) ) {//make sure earner is a valid user
				wp_send_json(['status' => __("User doesn't exist", "escrowtics")]);
			}
			
		} else {
			$user = get_user_by( 'login', $data["payer"]);
			$user_id = $user->ID;
		}
		
		if($data["payer"] == $data["earner"]) {
			wp_send_json(['status' => __("Payer and Earner Can not be thesame user", "escrowtics")]);
		}
		
		if($this->earnerExistInPayerList($data["payer"], $data["earner"])) { 
			wp_send_json(['status' => is_escrot_front_user() ? __("User already exist in your Escrow List. Check Escrow, and Add a Milestone Instead", "escrowtics") : __("Earner Already Exist in Payer's List. Check Escrow, and Add a Milestone Instead", "escrowtics")]);
		}
		
		$meta_fields = ['title','amount','status','details'];
		$meta_data   = escrot_get_form_data($meta_fields);
		$amount      = $meta_data["amount"];
		$title       = $meta_data["title"];
		$status      = $meta_data["status"];
		$details     = $meta_data["details"];
		
		if($amount < 1) {
			wp_send_json(['status' => __("Amount should be atleast 1 ", "escrowtics").ESCROT_CURRENCY]); 
		}
		
		//Make sure payer has enough funds
		$bal =  escrot_get_user_data($user_id)['balance'];
		if( $bal < $amount ) {
			wp_send_json(['status' => __("Insufficient Balance to Proceed", "escrowtics")]); 
		}
		
		//Insert escrow
		$this->insertData($this->escrowsTable, $data);
		
		//Insert Escrow Meta Data
		$escrow_id = $this->lastID('escrow_id', $this->escrowsTable);//Last Escrow ID
		$meta_data['escrow_id'] = $escrow_id;
		$this->insertData($this->escrowMetaTable, $meta_data);
		
		//Update User balance
		$new_bal = $bal - $amount;
	    $this->updateData($this->usersTable, ["balance" => $new_bal], ["user_id" => $user_id]);
		
		
		//Log & Notify
		escrot_log_notify_new_escrow(escrot_unique_id(), $data["payer"], $data["earner"], $meta_data['amount'], $new_bal, $user_id, $escrow_id, $data["ref_id"]);
		
		escrot_new_escrow_email($data["ref_id"], $status, $data["earner"], $amount, $user->user_email, $title, $details); //Email
 
		wp_send_json(['status' => 'success']);

	}
	
	
	//Create Milestone
	public function actionCreateMilestone() { 
	
		if(!check_ajax_referer( 'escrot_milestone_nonce', 'nonce' )) {
		   wp_send_json(['status' => __('Invalid nonce. Try reloading the page', 'escrowtics')]);
		}
		
		$meta_fields = ['escrow_id','title','amount','status','details'];
		$meta_data   = escrot_get_form_data($meta_fields);
		$escrow_id   = $meta_data["escrow_id"];
		$amount      = $meta_data["amount"];
		$title       = $meta_data["title"];
		$status      = $meta_data["status"];
		$details     = $meta_data["details"];
		
		//Get Escrow data
		$payer  = $this->getEscrowByID($escrow_id)["payer"];
		$earner = $this->getEscrowByID($escrow_id)["earner"];
		$ref_id = $this->getEscrowByID($escrow_id)["ref_id"];
		
		$user_id   = get_user_by('login', $payer)->ID;
		$earner_id = get_user_by('login', $earner)->ID;
		$earner_email =  escrot_get_user_data($earner_id)['email'];
		
		if($amount < 1) {
			wp_send_json(['status' => __("Amount should be atleast 1 ", "escrowtics").ESCROT_CURRENCY]); 
		}
		
		//Make sure payer has enough funds
		$bal = $this->getUserByID($user_id)['balance'];
		if($bal < $amount) {
			wp_send_json(['status' => __("Insufficient Balance to Proceed", "escrowtics")]); 
		}
		
		//Insert milestone
		$this->insertData($this->escrowMetaTable, $meta_data);
		
		//Update User balance
		$new_bal = $bal - $amount;
	    $this->updateData($this->usersTable, ["balance" => $new_bal], ["user_id" => $user_id]);
		
		//Log & Notify
		escrot_log_notify_new_milestone(escrot_unique_id(), $payer, $earner, $amount, $new_bal, $user_id, $escrow_id, $ref_id);
		escrot_new_milestone_email($ref_id, $status, $earner, $amount, $earner_email, $title, $details); 
 
		wp_send_json(['status' => 'success']);

	}
	
	
	//Create Milestone
	public function releasePayment() { 
	
		if($_POST["meta_id"]){
			
			$meta_id   = $_POST["meta_id"]; 
			$this->updateData($this->escrowMetaTable, ["status" => "Paid"], ["meta_id" => $meta_id]);
			
			$meta      = $this->getMetaByID($meta_id);
			$title     = $meta["title"];
			$amount    = $meta["amount"];
			$escrow_id = $meta["escrow_id"];
			$payer     = $this->getEscrowByID($escrow_id)["payer"];
			$earner    = $this->getEscrowByID($escrow_id)["earner"];
			$ref_id    = $this->getEscrowByID($escrow_id)["ref_id"];
			$user_id   = get_user_by('login', $payer)->ID;
			$earner_id = get_user_by('login', $earner)->ID;
			$bal       = $this->getUserByID($user_id)['balance'];
			$earner_bal= $this->getUserByID($earner_id)['balance'] + $amount;
			
			$earner_id = get_user_by('login', $earner)->ID;
			$earner_email =  escrot_get_user_data($earner_id)['email'];
			
			$this->updateData($this->usersTable, ["balance" => $bal], ["user_id" => $user_id]);
			$this->updateData($this->usersTable, ["balance" => $earner_bal], ["user_id" => $earner_id]);
			
			escrot_log_notify_pay_released(escrot_unique_id(), $payer, $title, $earner, $amount, $bal, $user_id, $ref_id);
			
			escrot_pay_released_email($ref_id, $payer, $title, $earner, $amount, $earner_email); //Send Email Notification
	 
			wp_send_json(['status' => 'success', 'message' => __('Payment Released Successfully', 'escrowtics')]);
		
		}

	}
	
	
	
	//Create Milestone
	public function rejectAmount() { 
	
		if($_POST["meta_id"]){
			
			$meta_id   = $_POST["meta_id"]; 
			$this->updateData($this->escrowMetaTable, ["status" => "Rejected"], ["meta_id" => $meta_id]);
			
			$meta      = $this->getMetaByID($meta_id);
			$title     = $meta["title"];
			$amount    = $meta["amount"];
			$escrow_id = $meta["escrow_id"];
			$payer     = $this->getEscrowByID($escrow_id)["payer"];
			$earner    = $this->getEscrowByID($escrow_id)["earner"];
			$ref_id    = $this->getEscrowByID($escrow_id)["ref_id"];
			$user_id   = get_user_by('login', $payer)->ID;
			$bal       = $this->getUserByID($user_id)['balance'] + $amount;
			
			
			$payer_email =  escrot_get_user_data($user_id)['email'];
			
			$this->updateData($this->usersTable, ["balance" => $bal], ["user_id" => $user_id]);
			
			escrot_log_notify_pay_rejected(escrot_unique_id(), $earner, $title, $payer, $amount, $bal, $user_id, $escrow_id, $ref_id);
			
			escrot_pay_rejected_email($ref_id, $earner, $escrow_title, $payer, $amount, $payer_email); //Send Email Notification
	 
			wp_send_json(['status' => 'success', 'message' => __('Amount Rejected Successfully', 'escrowtics')]);
		
		}

	}


	//Delete Escrow 
	public function actionDeleteEscrow() {		
	  if(isset($_POST['delID'])) {
		 $escrow_id = $_POST['delID'];
		 $this->deleteEscrow($escrow_id);
		 wp_send_json(['label' => 'Escrow']);
	  }
	}  

	//Deletet Multiple Escrows
	public function actionDeleteEscrows() {		
	  if(isset($_POST['multID'])) {
		 $multID = $_POST['multID'];
		 $this->deleteEscrows($multID);
		 wp_send_json(['label' => 'Escrow']);
	  }
	} 
	
	
	//Delete Escrow Meta
	public function actionDeleteEscrowMeta() {		
	  if(isset($_POST['delID'])) {
		 $meta_id = $_POST['delID'];
		 $this->deleteEscrowMeta($meta_id);
		 wp_send_json(['label' => 'Milestone']);
	  }
	}  

	//Deletet Multiple Escrow Meta
	public function actionDeleteEscrowMetas() {		
	   if(isset($_POST['multID'])) {
		 $meta_ids = $_POST['multID'];
		 $this->deleteEscrowMetas($meta_ids);
		 wp_send_json(['label' => 'Milestone']);
	  }
	} 


    //View Escrow Details
	public function actionViewMilestoneDetail() {		
	   if(isset($_POST['meta_id'])) {
		 $escrow_id = $_POST['meta_id'];
		 $detail = $this->getMetaByID($escrow_id)['details'];
		 wp_send_json(['data' => $detail, 'mode' => ESCROT_PLUGIN_INTERACTION_MODE]);
	  }
	}
   

	//Export Escrows to Excel
	public function exportEscrowsToExcel() {

		$exportData = $this->displayEscrows();
	 
		$output = 
		'<table border="1">
			<tr style="font-weight:bold">
				<th>ID.</th>
				<th>Payer</th> 
				<th>Earner</th>
	        </tr>';
		    foreach ($exportData as $export) {
		        $output .= '<tr>             
					<td>'.$export['escrow_id'].'</td>
					<td>'.$export['payer'].'</td>
					<td>'.$export['earner'].'</td>
			    </tr>';
		    }      
		$output .= '</table>';
		
		wp_send_json(['data' => $output, 'lable' => 'escrows']);
		
	}
	
	//Export Escrow Meta to Excel
	public function exportEscrowMetaToExcel() {

        if(isset($_POST['escrow_id'])){

			$exportData = $this->getEscrowMetaByID($_POST['escrow_id']);
		 
			$output = 
			'<table border="1">
				<tr style="font-weight:bold">
					<th>ID.</th>
					<th>Amount</th> 
					<th>Title</th>
					<th>Details</th>
					<th>Status</th>
					<th>Date Created</th>
				</tr>';
				foreach ($exportData as $export) {
					$output .= '<tr>             
						<td>'.$export['meta_id'].'</td>
						<td>'.$export['amount'].'</td>
						<td>'.$export['title'].'</td>
						<td>'.$export['details'].'</td>
						<td>'.$export['status'].'</td>
						<td>'.$export['creation_date'].'</td>
					</tr>';
				}      
			$output .= '</table>';
			
			wp_send_json(['data' => $output, 'lable' => 'escrow-meta']);
		}	
		
	}
	
	
	//Export Transaction Log to Excel
	public function exportLogToExcel() {

		$exportData = $this->displayTransactionLog();
 
		$output = 
		
		'<table border="1">
			<tr style="font-weight:bold">
				<th>ID.</th>
				<th>Transaction ID</th>
				<th>Details</th>
				<th>Amount</th> 
				<th>Date Created</th>
			</tr>';
			foreach ($exportData as $export) {
				$output .= '<tr>             
					<td>'.$export['id'].'</td>
					<td>'.$export['ref_id'].'</td>
					<td>'.$export['details'].'</td>
					<td>'.$export['amount'].'</td>
					<td>'.$export['creation_date'].'</td>
				</tr>';
			}      
		$output .= '</table>';
		
		wp_send_json(['data' => $output, 'lable' => 'transaction-log']);
		
	}
	
	
	//Export Withdrawal Invoices to Excel
	public function exportWithdrawalsToExcel() {

		$exportData = $this->filteredInvoicesData('User Withdrawal');
 
		$output = 
		
		'<table border="1">
			<tr style="font-weight:bold">
				<th>ID.</th>
				<th>Invoice ID</th>
				<th>User ID</th>
				<th>Address</th> 
				<th>Amount</th> 
				<th>Status</th> 
				<th>User IP</th> 
				<th>Date</th>
			</tr>';
			foreach ($exportData as $export) {
				$output .= '<tr>             
					<td>'.$export['id'].'</td>
					<td>'.$export['code'].'</td>
					<td>'.$export['user_id'].'</td>
					<td>'.$export['address'].'</td>
					<td>'.$export['amount'].'</td>
					<td>'.$export['status'].'</td>
					<td>'.$export['ip'].'</td>
					<td>'.$export['creation_date'].'</td>
				</tr>';
			}      
		$output .= '</table>';
		
		wp_send_json(['data' => $output, 'lable' => 'withdrawal-invoices']);
		
	}
	
	
	//Export Deposit Invoices to Excel
	public function exportDepositsToExcel() {

		$exportData = $this->filteredInvoicesData('User Deposit');
 
		$output = 
		
		'<table border="1">
			<tr style="font-weight:bold">
				<th>ID.</th>
				<th>Invoice ID</th>
				<th>User ID</th>
				<th>Address</th> 
				<th>Amount</th> 
				<th>Status</th> 
				<th>User IP</th> 
				<th>Date</th>
			</tr>';
			foreach ($exportData as $export) {
				$output .= '<tr>             
					<td>'.$export['id'].'</td>
					<td>'.$export['code'].'</td>
					<td>'.$export['user_id'].'</td>
					<td>'.$export['address'].'</td>
					<td>'.$export['amount'].'</td>
					<td>'.$export['status'].'</td>
					<td>'.$export['ip'].'</td>
					<td>'.$export['creation_date'].'</td>
				</tr>';
			}      
		$output .= '</table>';
		
		wp_send_json(['data' => $output, 'lable' => 'deposit-invoices']);
		
	}

	

	/****************************************** ESCROW SEARCH *************************************************/
	
	public function actionEscrowSearch() { 
	
		if(!check_ajax_referer( 'escrot_escrow_search_nonce', 'nonce' )) {
			wp_send_json(['status' => __('Invalid nonce. Try reloading the page', 'escrowtics')]); 
		}
		$text = isset($_POST["search"])? sanitize_text_field($_POST["search"]) : "";
		include ESCROT_PLUGIN_PATH."templates/escrows/escrow-search-results.php";
	}
	
	
	public function reloadSearchResults() { 
		$text = isset($_POST["search_text"])? sanitize_text_field($_POST["search_text"]) : "";
		include ESCROT_PLUGIN_PATH."templates/escrows/escrow-search-results.php";
	}
	
	
		


} 
