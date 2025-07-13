<?php

/**
 * Front User Profile
 * This template renders the profile page for logged-in users, 
 * managing various user-related views based on the URL endpoint.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

use Escrowtics\Database\UsersDBManager;

defined('ABSPATH') || exit; // Exit if accessed directly

// Check if the URL contains the "endpoint" parameter.
$escrot_endpoint = isset($_GET['endpoint']);

// Initialize the UsersDBManager class for database operations.
$user = new UsersDBManager();

// Get the current logged-in user's ID and username.
$user_id = get_current_user_id();
$username = get_user_by('ID', $user_id)->user_login;

// Retrieve user data and counts from the database.
$user_data = $user->getUserById($user_id);
$escrow_count = $user->getUserEscrowsCount($username);
$earning_count = $user->getUserEarningsCount($username);

?>

<div class="escrot-container p-3 position-relative">

    <?php
	
    include ESCROT_PLUGIN_PATH . 'templates/frontend/user-routes.php';
    include ESCROT_PLUGIN_PATH . 'templates/frontend/user-nav-bar.php';
    include ESCROT_PLUGIN_PATH . 'templates/frontend/user-dialogs.php';// Render collapsible dialogs

    ?>

    <div class="escrot-user-content-wrap escrot-rounded-bottom">
		<?php
		/**
		 * Load the appropriate view based on the "endpoint" URL parameter.
		 * If no endpoint is specified, load the default user dashboard.
		 */
		if ($escrot_endpoint) {
			$action = sanitize_text_field($_GET['endpoint']); // Sanitize endpoint parameter.

			// Determine the action and include the corresponding template.
			switch ($action) {
				case 'escrow_list':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/escrow-list.php';
					break;

				case 'earning_list':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/earning-list.php';
					break;

				case 'transaction_log':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/transaction-log.php';
					break;

				case 'deposit_history':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/deposit-history.php';
					break;

				case 'withdraw_history':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/withdraw-history.php';
					break;

				case 'view_escrow':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/view-escrow.php';
					break;

				case 'user_profile':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/edit-profile.php';
					break;

				case 'deposit_payment_options':
				case 'withdraw_payment_options':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/payment-options.php';
					break;

				case 'bitcoin_deposit_invoice':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/bitcoin-deposit-invoice.php';
					break;
				
				case 'paypal_deposit_invoice':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/paypal-deposit-invoice.php';
					break;

				case 'paypal_withdraw_invoice':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/paypal-withdraw-invoice.php';
					break;		
				
				case 'manual_deposit_invoice':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/manual-deposit-invoice.php';
					break;	

				case 'bitcoin_withdraw_invoice':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/bitcoin-withdrawal-invoice.php';
					break;

				case 'my_disputes':
					$disputes_count = $user->getUserComplainantDisputeCount($username);
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/disputes.php';
					break;

				case 'disputes_against_me':
					$disputes_count = $user->getUserAccusedDisputeCount($username);
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/disputes.php';
					break;

				case 'view_dispute':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/view-dispute.php';
					break;
				case 'user_dashboard':
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/user-dashboard.php';
					break;
				default:
					// Load the default dashboard view if the endpoint is invalid.
					include ESCROT_PLUGIN_PATH . 'templates/frontend/views/dashboard.php';
			}
		} else {
			// Load the default dashboard view if no endpoint is specified.
			include ESCROT_PLUGIN_PATH . 'templates/frontend/views/dashboard.php';
		}
		?>
    </div>
</div>
