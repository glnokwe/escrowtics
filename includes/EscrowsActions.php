<?php
/**
 * The Escrow manager class of the plugin.
 * Defines all Escrow Actions.
 *
 * @since 1.0.0
 * @package Escrowtics
 */

namespace Escrowtics;

use Escrowtics\Database\EscrowDBManager;

defined('ABSPATH') || exit;

/**
 * Class EscrowsActions
 * Manages all actions related to escrows within the Escrowtics plugin.
 */
class EscrowsActions extends EscrowDBManager {

    /**
     * Register hooks for AJAX and other actions.
     */
    public function register() {
        // Map of AJAX actions to their corresponding methods.
        $ajax_actions = [
            'escrot_escrows' => 'actionDisplayEscrows',
            'escrot_deposits' => 'actionDisplayDeposits',
			'escrot_reload_deposits' => 'reloadDeposits',
            'escrot_withdrawals' => 'actionDisplayWithdrawals',
            'escrot_reload_withdrawals' => 'reloadWithdrawals',
            'escrot_transaction_log' => 'actionDisplayTransactionLog',
            'escrot_reload_escrow_tbl' => 'actionReloadEscrows',
            'escrot_reload_escrow_meta_tbl' => 'actionReloadEscrowMeta',
            'escrot_insert_escrow' => 'actionInsertEscrow',
            'escrot_create_milestone' => 'actionCreateMilestone',
            'escrot_release_payment' => 'actionReleasePayment',
            'escrot_reject_amount' => 'actionRejectAmount',
            'escrot_escrow_data' => 'actionGetEscrowById',
            'escrot_del_escrow' => 'actionDeleteEscrow',
            'escrot_del_escrows' => 'actionDeleteEscrows',
            'escrot_del_escrow_meta' => 'actionDeleteEscrowMeta',
            'escrot_del_escrow_metas' => 'actionDeleteEscrowMetas',
			'escrot_del_invoice' => 'actionDeleteInvoice',
            'escrot_del_invoices' => 'actionDeleteInvoices',
            'escrot_del_log' => 'actionDeleteLog',
            'escrot_del_logs' => 'actionDeleteLogs',
            'escrot_export_escrows_excel' => 'exportEscrowsToExcel',
            'escrot_export_escrow_meta_excel' => 'exportEscrowMetaToExcel',
            'escrot_export_log_excel' => 'exportLogToExcel',
            'escrot_export_withdrawals_excel' => 'exportWithdrawalsToExcel',
            'escrot_export_deposits_excel' => 'exportDepositsToExcel',
            'escrot_escrow_search' => 'actionEscrowSearch',
            'escrot_reload_escrow_search' => 'reloadSearchResults',
            'escrot_view_milestone_detail' => 'actionViewMilestoneDetail',
			'escrot_dash_escrows' => 'actionDisplayDashEscrows',
			'escrot_manual_deposit_invoice' => 'actionManualDeposit'
        ];

        // Register AJAX actions for logged-in users.
        foreach ($ajax_actions as $action => $method) {
            add_action("wp_ajax_$action", [$this, $method]);
        }

        // Register specific public-facing AJAX actions.
        add_action('wp_ajax_nopriv_escrot_insert_escrow', [$this, 'actionInsertEscrow']);
        add_action('wp_ajax_nopriv_escrot_manual_deposit_invoice', [$this, 'actionManualDeposit']);

        // Custom hooks for logging transactions.
        add_action('escrot_log_transaction', [$this, 'logTransaction']);
    }

    /**
     * Load template for displaying data.
     *
     * @param string $template_path Relative path to the template.
     * @param array  $data          Data to pass to the template.
     */
    private function loadTemplate($template_path, $data = [], $die = true) {
        extract($data); // Extract array to variables for template usage.
        include_once ESCROT_PLUGIN_PATH . "templates/escrows/$template_path.php";
        if($die) wp_die(); // Terminate script after template is loaded.
		
    }


    /**
     * Display Escrows Table.
     */
    public function actionDisplayEscrows() {
        $data = ['data_count' => $this->getTotalEscrowCount()];
        $this->loadTemplate('escrows', $data);
    }

    /**
     * Display Deposits Table.
     */
    public function actionDisplayDeposits() {
		$data = ['data_count' => $this->getInvoiceCount('User Deposit') ];
        $this->loadTemplate('deposits', $data);
    }

    /**
     * Display Withdrawals Table.
     */
    public function actionDisplayWithdrawals() {
        $data = ['data_count' => $this->getInvoiceCount('User Withdrawal')];
        $this->loadTemplate('withdrawals', $data);
    }

    /**
     * Reload Withdrawals Table.
     */
    public function reloadWithdrawals() {
        $data = ['data_count' => $this->getInvoiceCount('User Withdrawal')];
        $this->loadTemplate('invoices-table', $data);
    }
	
	
	/**
     * Reload Deposits Table.
     */
    public function reloadDeposits() {
        $data = [ 'data_count' => $this->getInvoiceCount('User Deposit') ];
        $this->loadTemplate('invoices-table', $data);
    }

    /**
     * Display Transaction Log Table.
     */
    public function actionDisplayTransactionLog() {
        $data = ['log_count' => $this->getAdminTransactionLogCount()];
        $this->loadTemplate('transaction-log', $data);
    }

    /**
     * Reload Escrows Table.
     */
    public function actionReloadEscrows() {
        $data = [];

        if (escrot_is_front_user()) {
            // For front-end users, filter escrows by username.
            $user_id = get_current_user_id();
            $username = get_user_by("ID", $user_id)->user_login;
            $data['data_count'] = $this->getUserEscrowsCount($username);
        } else {
            // For back-end users, load all escrows.
            $data['data_count'] = $this->getTotalEscrowCount();
        }

        $this->loadTemplate('escrows-table', $data);
    }

    /**
     * Reload Escrow Meta Table.
     */
    public function actionReloadEscrowMeta() {
        if (isset($_POST['escrow_id'])) {
            $data = [
                'escrow_id' => $_POST['escrow_id'],
                'escrow_meta_count' => $this->getEscrowMetaCount($_POST['escrow_id'])
            ];
            $this->loadTemplate('view-escrow-table', $data);
        }
    }


	/**
     * Display Dashboard Escrows Table.
     */
	public function actionDisplayDashEscrows() {
		include ESCROT_PLUGIN_PATH."templates/admin/dashboard/dashboard-escrows-table.php";  
		wp_die();
	}
	
	
	/**
	 * Add a new escrow entry.
	 */
	public function actionInsertEscrow() {
		// Verify the nonce for security.
		escrot_validate_ajax_nonce('escrot_escrow_nonce', 'nonce');

		// Sanitize and prepare form data.
		$form_fields = ['escrow_id', 'earner', 'payer'];
		$data = escrot_sanitize_form_data($form_fields);
		$data['ref_id'] = escrot_unique_id();

		// Set payer based on user context and validate the earner.
		if (escrot_is_front_user()) {
			$user_id = get_current_user_id();
			$user = get_user_by('ID', $user_id);
			$data['payer'] = $user->user_login;

			if (!username_exists($data['earner'])) {
				wp_send_json_error(['message' => __("User doesn't exist", "escrowtics")]);
			}
		} else {
			escrot_verify_permissions('manage_options');//Ensure admin user has permission
			$user = get_user_by('login', $data['payer']);
			$user_id = $user->ID;
		}

		// Validate that payer and earner are different users.
		if ($data['payer'] === $data['earner']) {
			wp_send_json_error(['message' => __("Payer and Earner cannot be the same user", "escrowtics")]);
		}

		// Ensure the earner doesn't already exist in the payer's escrow list.
		if ($this->earnerExistInPayerList($data['payer'], $data['earner'])) {
			$error_message = escrot_is_front_user() 
				? __("User already exists in your Escrow List. Check Escrow, and Add a Milestone Instead", "escrowtics")
				: __("Earner already exists in Payer's List. Check Escrow, and Add a Milestone Instead", "escrowtics");
			wp_send_json_error(['message' => $error_message]);
		}

		// Sanitize and validate escrow meta data.
		$meta_fields = ['title', 'amount', 'status', 'details'];
		$meta_data = escrot_sanitize_form_data($meta_fields);
		$amount = $meta_data['amount'];

		if ($amount < 1) {
			wp_send_json_error(['message' => __("Amount should be at least 1 ", "escrowtics") . escrot_option('currency')]);
		}
		
		//validate amount & apply fees 
		$fees = $this->handleEscrowAmtAndFees($user_id, $amount); 
		
		// Check user's balance
		$bal = (float) get_user_meta($user_id, 'balance', true);
		$final_escrow_amt = $fees['total_cost'];
		if ($bal < $final_escrow_amt) {
			wp_send_json_error(["message" => __("Insufficient balance to proceed.", "escrowtics")]);
		}

		// Insert escrow and related meta data.
		$this->insertData($this->tables->escrows, $data);
		$escrow_id = $this->getLastID('escrow_id', $this->tables->escrows); // Get the last inserted escrow ID.
		$meta_data['payable_amount'] = $fees['payable_amount']; //update payable amount
		$meta_data['escrow_id'] = $escrow_id;
		$this->insertData($this->tables->escrow_meta, $meta_data);

		// Deduct escrow amount + fees and update the user's balance
		$new_balance = $bal - $final_escrow_amt;
		update_user_meta($user_id, 'balance', $new_balance);

		// Log and notify.
		escrot_log_notify_new_escrow(
			escrot_unique_id(),
			$data['payer'],
			$data['earner'],
			$meta_data['amount'],
			$new_balance,
			$user_id,
			$escrow_id,
			$data['ref_id']
		);

		escrot_new_escrow_email(
			$data['ref_id'],
			$meta_data['status'],
			$data['earner'],
			$amount,
			$user->user_email,
			$meta_data['title'],
			$meta_data['details']
		);

		// Send success response.
		wp_send_json_success([
			'message' => __('Escrow added successfully', 'escrowtics'),
			'redirect_text' => __('View Escrow', 'escrowtics'),
			'escrow_id' => $escrow_id,
			'fees' => escrot_option('escrow_fee_description') . ': <b>' . escrot_option('currency').$fees['escrow_fee'] . '</b><br>' .
					  __('Commission fees', 'escrowtics') . ': <b>' . escrot_option('currency').$fees['commission_fee'] . '</b><br>' .
					  escrot_option('commission_tax_description') . ': <b>' . escrot_option('currency').$fees['commission_tax_fee']. '</b><br>' .
					  (escrot_is_front_user()? __('You Paid', 'escrowtics') : __('Amount Paid', 'escrowtics') )	  . ': <b>' . escrot_option('currency').$fees['total_cost']. '</b>'  
			
		]);
	}
	

	
	
	
	/**
	 * Handle commission/fees during escrow creation.
	 *
	 * @param int $user_id User (Payer) ID.
	 * @param float $escrow_amt Escrow amount.
	 * @return array Fees breakdown.
	 */
	private function handleEscrowAmtAndFees($user_id, $escrow_amt) {
		$options = [
			'commission_fees'        => escrot_option('commission_fees'),
			'commission_amount'      => escrot_option('commission_amount'),
			'commission_percentage'  => escrot_option('commission_percentage'),
			'enable_max_commission'  => escrot_option('enable_max_commission'),
			'max_commission_amount'  => escrot_option('max_commission_amount'),
			'enable_min_commission'  => escrot_option('enable_min_commission'),
			'min_commission_amount'  => escrot_option('min_commission_amount'),
			'escrow_fees'             => escrot_option('escrow_fees'),
			'escrow_fee_amount'       => escrot_option('escrow_fee_amount'),
			'escrow_fee_percentage'   => escrot_option('escrow_fee_percentage'),
			'commission_tax_fees'     => escrot_option('commission_tax_fees'),
			'commission_tax_amount'   => escrot_option('commission_tax_amount'),
			'commission_tax_percentage'=> escrot_option('commission_tax_percentage'),
			'commission_payer'        => escrot_option('commission_payer'),
		];

		$calculate_fee = function ($type, $amount, $percentage) use ($escrow_amt) {
			switch ($type) {
				case 'fixed_fee':
					return (float) $amount;
				case 'percentage':
					return ($percentage / 100) * $escrow_amt;
				case 'percentage_amount':
					return (float) $amount + (($percentage / 100) * $escrow_amt);
				default:
					return 0;
			}
		};

		$commission_fee = $calculate_fee($options['commission_fees'], $options['commission_amount'], $options['commission_percentage']);
		$escrow_fee = $calculate_fee($options['escrow_fees'], $options['escrow_fee_amount'], $options['escrow_fee_percentage']);
		$commission_tax_fee = $calculate_fee($options['commission_tax_fees'], $options['commission_tax_amount'], $options['commission_tax_percentage']);
		
		$fee = $commission_fee + $escrow_fee + $commission_tax_fee;

		// Apply min/max commission if enabled
		if ($options['enable_max_commission']) {
			$fee = min($fee, $options['max_commission_amount']);
		}
		if ($options['enable_min_commission']) {
			$fee = max($fee, $options['min_commission_amount']);
		}

		$total_cost = $fee + $escrow_amt; //total amount payer will spent for this transaction
		$payable_amt = $escrow_amt; //amount earner will receive after deducting commissions

		switch ($options['commission_payer']) {
			case 'earner':
				$total_cost = $escrow_amt;
				$payable_amt = $escrow_amt - $fee;
				break;
			case 'both':
				$half_fee = $fee / 2;
				$total_cost = $escrow_amt + $half_fee;
				$payable_amt = $escrow_amt - $half_fee;
				break;
		}

		return [
			'total_cost'        => $total_cost,
			'payable_amount'    => $payable_amt,
			'escrow_fee'        => $escrow_fee,
			'commission_fee'    => $commission_fee,
			'commission_tax_fee'=> $commission_tax_fee,
		];
	}

	
	
	
	/**
	 * Create a new milestone.
	 */
	public function actionCreateMilestone() {
		// Verify nonce for security.
		escrot_validate_ajax_nonce('escrot_milestone_nonce', 'nonce');

		// Sanitize and extract meta fields.
		$meta_fields = ['escrow_id', 'title', 'amount', 'status', 'details'];
		$meta_data = escrot_sanitize_form_data($meta_fields);
		$escrow_id = $meta_data['escrow_id'];
		$amount = $meta_data['amount'];

		// Validate amount.
		if ($amount < 1) {
			wp_send_json_error(['message' => __("Amount should be at least 1 ", "escrowtics") . escrot_option('currency')]);
		}

		// Retrieve escrow data.
		$escrow = $this->getEscrowById($escrow_id);
		if (!$escrow) {
			wp_send_json_error(['message' => __("Invalid Escrow ID", "escrowtics")]);
		}

		$payer = $escrow['payer'];
		$earner = $escrow['earner'];
		$ref_id = $escrow['ref_id'];

		$user_id = get_user_by('login', $payer)->ID;
		$earner_id = get_user_by('login', $earner)->ID;
		$earner_email = escrot_get_user_data($earner_id)['user_email'];

		
		//validate amount & apply fees 
		$fees = $this->handleEscrowAmtAndFees($user_id, $amount); 
		
		// Ensure payer has sufficient balance.
		$bal = (float) get_user_meta($user_id, 'balance', true);
		$final_escrow_amt = $fees['total_cost'];
		if ($bal < $final_escrow_amt) {
			wp_send_json_error(["message" => __("Insufficient balance to proceed.", "escrowtics")]);
		}

		// Insert milestone into the database.
		$meta_data['payable_amount'] = $fees['payable_amount']; //update payable amount
		$this->insertData($this->tables->escrow_meta, $meta_data);

		// Deduct escrow amount + fees and update payer's balance
		$new_balance = $bal - $final_escrow_amt;
		update_user_meta($user_id, 'balance', $new_balance);

		// Log and notify.
		$unique_id = escrot_unique_id();
		escrot_log_notify_new_milestone($unique_id, $payer, $earner, $amount, $new_balance, $user_id, $escrow_id, $ref_id);

		escrot_new_milestone_email($ref_id, $meta_data['status'], $earner, $amount, $earner_email, $meta_data['title'], $meta_data['details']);

		// Send success response.
		wp_send_json_success([
			'message' => __('Milestone created successfully', 'escrowtics'),
			'escrow_id' => $escrow_id,
			'fees' => escrot_option('escrow_fee_description') . ': <b>' . escrot_option('currency').$fees['escrow_fee'] . '</b><br>' .
					  __('Commission fees', 'escrowtics') . ': <b>' . escrot_option('currency').$fees['commission_fee'] . '</b><br>' .
					  escrot_option('commission_tax_description')  . ': <b>' . escrot_option('currency').$fees['commission_tax_fee']. '</b><br>' .
					  (escrot_is_front_user()? __('You Paid', 'escrowtics') : __('Amount Paid', 'escrowtics') )	  . ': <b>' . escrot_option('currency').$fees['total_cost']. '</b>'  
			
		]);
		
	}

	
	
	/**
	 * Release Payment
	 */
	public function actionReleasePayment() { 
		if (isset($_POST["meta_id"])) {
			$meta_id = sanitize_text_field($_POST["meta_id"]); 

			// Update escrow meta status
			$this->updateData($this->tables->escrow_meta, ["status" => "Paid"], ["meta_id" => $meta_id]);

			// Retrieve relevant data
			$meta = $this->getMetaById($meta_id);
			$escrow = $this->getEscrowById($meta["escrow_id"]);

			$title = $meta["title"];
			$amount = floatval($meta["amount"]);
			$escrow_id = intval($meta["escrow_id"]);
			$payer_username = $escrow["payer"];
			$earner_username = $escrow["earner"];
			$ref_id = $escrow["ref_id"];

			// Get user IDs and balances
			$payer_user = get_user_by('login', $payer_username);
			$earner_user = get_user_by('login', $earner_username);

			if (!$payer_user || !$earner_user) {
				wp_send_json_error(['message' => __('Invalid payer or earner user.', 'escrowtics')]);
			}

			$payer_id = $payer_user->ID;
			$earner_id = $earner_user->ID;

			$payer_balance = floatval( get_user_meta($payer_id, 'balance', true) );
			$earner_balance = floatval( get_user_meta($earner_id, 'balance', true) ) + $amount;

			// Update earner's balances
			update_user_meta($earner_id, 'balance', $earner_balance);

			// Notification and email
			escrot_log_notify_pay_released(
				escrot_unique_id(),
				$payer_username,
				$title,
				$earner_username,
				$amount,
				$payer_balance,
				$payer_id,
				$ref_id
			);

			$earner_email = escrot_get_user_data($earner_id)['user_email'];
			escrot_pay_released_email($ref_id, $payer_username, $title, $earner_username, $amount, $earner_email);

			// Return success response
			wp_send_json_success(['message' => __('Payment Released Successfully', 'escrowtics')]);
		} else {
			wp_send_json_error(['message' => __('Escrow Meta ID is required.', 'escrowtics')]);
		}
	}

	
	
	
	/**
	 * Reject Escrow Amount
	 */
	public function actionRejectAmount() { 
		if (isset($_POST["meta_id"])) {
			$meta_id = sanitize_text_field($_POST["meta_id"]);

			// Update escrow meta status
			$this->updateData($this->tables->escrow_meta, ["status" => "Rejected"], ["meta_id" => $meta_id]);

			// Retrieve necessary data
			$meta = $this->getMetaById($meta_id);
			$escrow = $this->getEscrowById($meta["escrow_id"]);

			$title = $meta["title"];
			$amount = floatval($meta["amount"]);
			$escrow_id = intval($meta["escrow_id"]);
			$payer_username = $escrow["payer"];
			$earner_username = $escrow["earner"];
			$ref_id = $escrow["ref_id"];

			// Get payer details
			$payer_user = get_user_by('login', $payer_username);
			if (!$payer_user) {
				wp_send_json_error(__('Invalid payer user.', 'escrowtics'));
			}

			$payer_id = $payer_user->ID;
			$payer_balance = floatval(get_user_meta($payer_id, 'balance', true)) + $amount;
			$payer_email = escrot_get_user_data($payer_id)['user_email'];

			// Update payer balance
			update_user_meta($earner_id, 'balance', $earner_balance);

			// Log and notify
			escrot_log_notify_pay_rejected(
				escrot_unique_id(),
				$earner_username,
				$title,
				$payer_username,
				$amount,
				$payer_balance,
				$payer_id,
				$escrow_id,
				$ref_id
			);

			escrot_pay_rejected_email(
				$ref_id,
				$earner_username,
				$title,
				$payer_username,
				$amount,
				$payer_email
			);

			// Return success response
			wp_send_json_success(['message' => __('Amount Rejected Successfully', 'escrowtics')]);
		} else {
			wp_send_json_error(['message' => __('Escrow Meta ID is required.', 'escrowtics')]);
		}
	}
	
	
	/************** Payments ******************/
	
	public function actionManualDeposit() {
			
		// Verify the nonce for security.
		escrot_validate_ajax_nonce('escrot_deposit_invoice_nonce', 'nonce');

		$form_fields = ['amount', 'payment_method', 'other_payment'];
		$data = escrot_sanitize_form_data($form_fields);
		$amount = $data['amount'];
		
		// Create Invoice
		$payment_method = 'Manual';
		$manual_method = $data['payment_method'] === 'Other'? $data['other_payment'] : $data['payment_method'];
		$code = escrot_unique_id();
		$product = 'User Deposit';
		$user_id = get_current_user_id();
		
		$invoice_data = [
            'code' => $code,
            'user_id' => $user_id,
            'address' => $manual_method,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'status' => 1,
            'product' => $product,
            'ip' => escrot_get_ip(),
        ];
		
		$this->insertData($this->tables->invoices, $invoice_data);

		// Log & notify
		$current_balance = floatval(get_user_meta($user_id, 'balance', true) ?: 0);
		$user = get_userdata($user_id);
		$username = $user->user_login;
		$ref_id = escrot_unique_id();

		escrot_log_notify_user_deposit($ref_id, $username, $payment_method, $amount, $current_balance, $user_id, $code);
		escrot_user_deposit_email($code, $username, $amount, $manual_method);

		wp_send_json_success([
			'title'   => __('Invoice Created!', 'escrowtics'),
			'message' => __('Deposit Invoice Created Pending Payment', 'escrowtics'),
			'code' => $code
		]);
		
	}

	/************** Payments End ******************/

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
	
	//Delete Escrow Meta
	public function actionDeleteLog() {		
	  if(isset($_POST['delID'])) {
		 $log_id = $_POST['delID'];
		 $this->deleteLog($log_id);
		 wp_send_json(['label' => 'Log']);
	  }
	}  

	//Deletet Multiple Escrow Meta
	public function actionDeleteLogs() {		
	   if(isset($_POST['multID'])) {
		 $log_ids = $_POST['multID'];
		 $this->deleteLogs($log_ids);
		 wp_send_json(['label' => 'Log']);
	  }
	} 
	
	
	//Delete Invoice
	public function actionDeleteInvoice() {		
	  if(isset($_POST['delID'])) {
		 $id = $_POST['delID'];
		 $this->deleteInvoice($id);
		 wp_send_json(['label' => 'Invoice']);
	  }
	}  

	//Deletet Multiple Invoices
	public function actionDeleteInvoices() {		
	   if(isset($_POST['multID'])) {
		 $ids = $_POST['multID'];
		 $this->deleteInvoices($ids);
		 wp_send_json(['label' => 'Invoice']);
	  }
	}


    //View Escrow Details
	public function actionViewMilestoneDetail() {		
	   if(isset($_POST['meta_id'])) {
		 $escrow_id = $_POST['meta_id'];
		 $detail = $this->getMetaById($escrow_id)['details'];
		 wp_send_json(['data' => $detail]);
	  }
	}
   

	/**
	 * Export Escrows to Excel
	 */
	public function exportEscrowsToExcel() {
		$data = $this->fetchAllEscrows();
		$columns = [
			'ID.' => 'escrow_id',
			'Payer' => 'payer',
			'Earner' => 'earner'
		];
		escrot_excel_table($data, $columns, 'escrows');
	}

	/**
	 * Export Escrow Meta to Excel
	 */
	public function exportEscrowMetaToExcel() {
		if (isset($_POST['escrow_id'])) {
			$escrow_id = sanitize_text_field($_POST['escrow_id']);
			$data = $this->fetchEscrowMetaById($escrow_id);
			$columns = [
				'ID.' => 'meta_id',
				'Amount' => 'amount',
				'Title' => 'title',
				'Details' => 'details',
				'Status' => 'status',
				'Date Created' => 'creation_date'
			];
			escrot_excel_table($data, $columns, 'escrow-meta');
		}
	}

	/**
	 * Export Transaction Log to Excel
	 */
	public function exportLogToExcel() {
		$data = $this->fetchAdminTransactionLogs();
		$columns = [
			'ID.' => 'id',
			'Transaction ID' => 'ref_id',
			'Details' => 'details',
			'Amount' => 'amount',
			'Date Created' => 'creation_date'
		];
		escrot_excel_table($data, $columns, 'transaction-log');
	}

	/**
	 * Export Withdrawal Invoices to Excel
	 */
	public function exportWithdrawalsToExcel() {
		$data = $this->filteredInvoicesData('User Withdrawal');
		$columns = [
			'ID.' => 'id',
			'Invoice ID' => 'code',
			'User ID' => 'user_id',
			'Address' => 'address',
			'Amount' => 'amount',
			'Status' => 'status',
			'User IP' => 'ip',
			'Date' => 'creation_date'
		];
		escrot_excel_table($data, $columns, 'withdrawal-invoices');
	}

	/**
	 * Export Deposit Invoices to Excel
	 */
	public function exportDepositsToExcel() {
		$data = $this->filteredInvoicesData('User Deposit');
		$columns = [
			'ID.' => 'id',
			'Invoice ID' => 'code',
			'User ID' => 'user_id',
			'Address' => 'address',
			'Amount' => 'amount',
			'Status' => 'status',
			'User IP' => 'ip',
			'Date' => 'creation_date'
		];
		escrot_excel_table($data, $columns, 'deposit-invoices');
	}

	

	/**
	 * Escrow search 
	 */
	public function reloadSearchResults() { 
	
	    $text = isset($_POST["search"])? sanitize_text_field($_POST["search"]) : "";
		$data = [
			'text' => $text,
			'data_count' => $this->escrowSearchCount($text)
		];
        $this->loadTemplate('escrow-search-results', $data);
	} 
	
	public function actionEscrowSearch() { 
	
		escrot_validate_ajax_nonce('escrot_escrow_search_nonce', 'nonce');
        $this->reloadSearchResults();
	}
	


} 
