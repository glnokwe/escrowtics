<?php

/**
* Front User Profile
* Profile Page for Logged in Users
* @since      1.0.0
* @package    Escrowtics
*/ 

use Escrowtics\database\UsersConfig; 
		
defined('ABSPATH') or die();

$escrot_endpoint = isset($_GET['endpoint'])? true : false; //check if url has escrot endpoint

$user = new UsersConfig();

$user_id = get_current_user_id();	

$username = get_user_by("ID", $user_id)->user_login;	

$user_data = $user->getUserByID($user_id);

$escrow_count = $user->userEscrowsCount($username);
		
$earning_count = $user->userEarningsCount($username);

?>


<div class="escrot-container p-3 position-relative">	
	 
	<?php
		include ESCROT_PLUGIN_PATH."templates/frontend/user-routes.php";
		include ESCROT_PLUGIN_PATH."templates/frontend/user-nav-bar.php";
	    include ESCROT_PLUGIN_PATH."templates/frontend/user-dialogs.php"; 
        escrot_callapsable_dialogs($dialogs); 
    ?>		
		  
	<div class="tab-content tab-space escrot-user-content-wrap escrot-rounded-bottom">
	    <div class="tab-pane active">
	        <?php
				if($escrot_endpoint) {
					$action = $_GET['endpoint'];
					switch($action){
						case('escrow_list'): include ESCROT_PLUGIN_PATH."templates/frontend/views/escrow-list.php"; 
						break;
						case('earning_list'): include ESCROT_PLUGIN_PATH."templates/frontend/views/earning-list.php"; 
						break;
						case('transaction_log'): include ESCROT_PLUGIN_PATH."templates/frontend/views/transaction-log.php"; 
						break;
						case('deposit_history'): include ESCROT_PLUGIN_PATH."templates/frontend/views/deposit-history.php"; 
						break;
						case('withdraw_history'): include ESCROT_PLUGIN_PATH."templates/frontend/views/withdraw-history.php"; 
						break;
						case('view_transaction'): include ESCROT_PLUGIN_PATH."templates/frontend/views/view-transaction.php"; 
						break;
						case('user_profile'): include ESCROT_PLUGIN_PATH."templates/frontend/views/edit-profile.php"; 
						break;
						case('deposit_payment_options'): include ESCROT_PLUGIN_PATH."templates/frontend/views/payment-options.php";  
						break;
						case('withdraw_payment_options'): include ESCROT_PLUGIN_PATH."templates/frontend/views/payment-options.php";  
						break;
						case('bitcoin_deposit_invoice'): include ESCROT_PLUGIN_PATH."templates/frontend/views/bitcoin-deposit-invoice.php"; 
						break;
						case('bitcoin_withdraw_invoice'): include ESCROT_PLUGIN_PATH."templates/frontend/views/bitcoin-withdrawal-invoice.php"; 
						break;
						case('support_tickets'): include ESCROT_PLUGIN_PATH."templates/frontend/views/support-tickets.php"; 
						break;
						case('view_ticket'): include ESCROT_PLUGIN_PATH."templates/frontend/views/view-ticket.php"; 
						break;
						default: 
						include ESCROT_PLUGIN_PATH."templates/frontend/views/user-dashboard.php";
					}	
				} else {
					include ESCROT_PLUGIN_PATH."templates/frontend/views/user-dashboard.php";
				}
					
            ?>	
        </div>			
	</div>
</div>

			  
			  