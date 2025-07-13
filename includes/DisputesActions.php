<?php
/**
 * The Disputes manager class of the plugin.
 * Defines all Disputes Actions.
 * 
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics;

use Escrowtics\Database\DisputesDBManager;

defined('ABSPATH') || exit;

class DisputesActions extends DisputesDBManager {

    /**
     * Register hooks.
     */
    public function register() {
        // Register AJAX hooks
        $actions = [
            'escrot_disputes'                => 'actionDisplayDisputes',
            'escrot_disputes_tbl'            => 'actionReloadDisputes',
            'escrot_insert_dispute'          => 'actionInsertDispute',
            'escrot_update_dispute'          => 'actionUpdateDispute',
            'escrot_dispute_data'            => 'actionGetDisputeDataById',
            'escrot_del_dispute'             => 'actionDeleteDispute',
            'escrot_del_disputes'            => 'actionDeleteDisputes',
            'escrot_export_disputes_excel'   => 'actionExportToExcel',
            'escrot_reply_dispute'           => 'actionReplyDispute',
        ];

        foreach ($actions as $hook => $callback) {
            add_action("wp_ajax_$hook", [$this, $callback]);
        }
    }

    /**
     * Insert a new dispute.
     */
    public function actionInsertDispute() {
	
        check_ajax_referer('escrot_dispute_nonce', 'nonce');

        $form_data = [
            'reason', 
            'complainant', 
            'resolution_requested', 
            'priority',
			'escrow_ref'
        ];
        $data = escrot_sanitize_form_data($form_data);
		
		if(!escrot_escrow_exist('ref_id', $data['escrow_ref'])){
			wp_send_json_error(['message' => __("Escrow with the provided Reference ID not found.", "escrowtics")]);
		}
		
        $data['status'] = 0;
        $data['ref_id'] = $data['escrow_ref'];
		$data['escrow_id'] = escrot_get_escrow_by_ref($data['escrow_ref'])['escrow_id'];
		
		if ( $this->escrowDisputeExist($data['escrow_id']) ){ //Prevent duplicate disputes
			wp_send_json_error(['message' => __('A dispute already exists for the referenced escrow.', 'escrowtics')]);
		}
		
		$payer = escrot_get_escrow_by_ref($data['escrow_ref'])['payer'];
		$earner = escrot_get_escrow_by_ref($data['escrow_ref'])['earner'];
		
		unset($data['escrow_ref']);

        if (escrot_is_front_user()) { 
			
			$complainant_id = get_current_user_id();
			
            $username = get_user_by('ID', $complainant_id)->user_login;//Get complainant username
		
			if( $payer !== $username  && $earner !== $username  ) {//make sure complainant is part of the escrow referenced 
				wp_send_json_error(['message' => __("You are not part of the escrow for the given Reference ID.", "escrowtics")]);
			} 
			
			$data['complainant'] = $username;
			$data['accused'] = $username === $payer? $earner : $payer;//Get accused user
			$author = 'Complainant';
			$data['accused_role'] = $data['accused'] === $payer? 'Payer' : 'Earner';//Get accused user's role for the escrow
			$initiator = $data['complainant'] === $payer? 'payer' : 'earner';
			$user = get_user_by('login', $data['accused']);
            $accused_id = $user->ID ?? null;
			
			$this->validateDisputeSettings($data['escrow_id'], $initiator); //check & implement dispute settings
			
        } else {
			escrot_verify_permissions('manage_options');//Ensure admin user has permission
			if(empty($data['complainant'])){
				wp_send_json_error(['message' => __("Please select the comlainant", "escrowtics")]);
			}
			$data['complainant'] = $data['complainant'] === 'payer'? $payer : $earner;
			$data['accused'] = $data['complainant'] === $payer? $earner : $payer;
			$data['accused_role'] = $data['accused'] === $payer? 'Payer' : 'Earner';
			$user = get_user_by('login', $data['complainant']);
            $complainant_id = $user->ID ?? null;
			$user = get_user_by('login', $data['accused']);
            $accused_id = $user->ID ?? null;
			$author = 'Admin';
		}
		
		$this->handleDisputeFees($complainant_id, $data['escrow_id']);
		
        $this->insertData($this->tables->disputes, $data);
		
        $dispute_id = $this->getLastInsertedDisputeID();

        $this->handleMetaValues($dispute_id, $author);
		
		escrot_notify_new_dispute(
			$dispute_id, 
			$data['ref_id'], 
			$data['complainant'], 
			$data['accused'],  
			$accused_id, 
			$complainant_id
		); 

        wp_send_json_success(['message' => 'Dispute Added successfully']);
    }
	

    /**
     * Display disputes.
     */
    public function actionDisplayDisputes() {
		
        $disputes_count = $this->getTotalDisputeCount();
        //$disputes = $this->getAllDisputes();
		
        ob_start();
        include_once ESCROT_PLUGIN_PATH . 'templates/disputes/disputes.php';
		wp_send_json_success(['data' => ob_get_clean()]);
    }

    /**
     * Reload disputes table.
     */
    public function actionReloadDisputes() {
        if (escrot_is_front_user()) {
			$user_id = get_current_user_id();
            $username = get_user_by('ID', $user_id)->user_login;
            $disputes_count = $this->getUserComplainantDisputeCount($username);
            $disputes = $this->getUserComplainantDisputes($username);
        } else {
            $disputes_count = $this->getTotalDisputeCount();
            $disputes = $this->getAllDisputes();
        }
		
		ob_start();
        include_once ESCROT_PLUGIN_PATH . 'templates/disputes/disputes-table.php';
		wp_send_json_success(['data' => ob_get_clean()]);
    }
	

    /**
     * Get dispute by ID.
     */
    public function actionGetDisputeDataById() {
		
        if (!isset($_POST['DisputeId'])) {
			wp_send_json_success(['data' => []]);
		}

        $dispute_id = intval($_POST['DisputeId'] ?? 0);
        $row = $this->getDisputeById($dispute_id);

        wp_send_json_success(['data' => $row]);
    }


    /**
     * Update dispute status.
     */
    public function actionUpdateDispute() {
		
		escrot_verify_permissions('manage_options');
        check_ajax_referer('escrot_dispute_status_nonce', 'nonce');

        $form_data = ['dispute_id', 'status', 'priority'];
        $data = escrot_sanitize_form_data($form_data);
		if(empty($data['priority'])) { unset($data['priority']); }
		
        // Validate and sanitize int output
		$data['dispute_id'] = intval($data['dispute_id']);

        $this->updateDispute($data);
		wp_send_json_success(['message' => __('Status updated successfully.', 'escrowtics')]);
		
    }

    /**
     * Delete a single dispute.
     */
    public function actionDeleteDispute() {
		escrot_verify_permissions('manage_options');
        $dispute_id = intval($_POST['DisputeID'] ?? 0);
        $this->deleteDispute($dispute_id);

        wp_die();
    }

    /**
     * Delete multiple disputes.
     */
    public function actionDeleteDisputes() {
		escrot_verify_permissions('manage_options');
        $dispute_ids = $_POST['multDisputeid'] ?? [];
        $this->deleteDisputes($dispute_ids);
        wp_die();
    }

    /**
     * Export disputes to Excel.
     */
    public function actionExportToExcel() {
		escrot_verify_permissions('manage_options');
        $export_data = $this->getAllDisputes();

        // Escape and sanitize output for Excel file
        $output = "<table border='1'>\n<tr><th>ID</th><th>Ref ID</th><th>User ID</th><th>Department</th><th>Subject</th><th>Status</th><th>Priority</th><th>Last Updated</th></tr>\n";

        foreach ($export_data as $export) {
            $output .= "<tr><td>" . esc_html($export['dispute_id']) . "</td>";
            $output .= "<td>" . esc_html($export['ref_id']) . "</td>";
            $output .= "<td>" . esc_html($export['user_id']) . "</td>";
            $output .= "<td>" . esc_html($export['department']) . "</td>";
            $output .= "<td>" . esc_html($export['subject']) . "</td>";
            $output .= "<td>" . esc_html($export['status']) . "</td>";
            $output .= "<td>" . esc_html($export['priority']) . "</td>";
            $output .= "<td>" . esc_html($export['last_updated']) . "</td></tr>\n";
        }

        $output .= "</table>";

        wp_send_json(['data' => $output, 'label' => 'disputes']);
    }
	

    /**
     * Handle dispute meta values.
     *
     * @param int $dispute_id Dispute ID, string $author Reply author(Admin, Complainant or Accused).
     */
    private function handleMetaValues($dispute_id, $author) {
        $meta_fields = ['message', 'attachment'];
        $meta_data = escrot_sanitize_form_data($meta_fields);
		
		if (escrot_is_front_user()) {
			$file_size = escrot_option('dispute_evidence_file_size');
			$file_types = escrot_option('dispute_evidence_file_types');
			$attachment = escrot_uploader('attachment', $file_size, $file_types);
			if (is_wp_error($attachment)) {
				wp_send_json_error(['message' => $attachment->get_error_message()]);
			}
			$meta_data['attachment'] = escrot_is_valid_url($attachment)? $attachment : '';
		}	

        foreach ($meta_fields as $field) {
            $meta_entry = [
                'dispute_id' => $dispute_id,
                'meta_type' => $field === 'message' ? 'Text' : 'File',
                'meta_value' => $meta_data[$field] ?? '',
                'author' => $author
            ];

            if (!empty($meta_entry['meta_value'])) {
                $this->insertData($this->tables->disputes_meta, $meta_entry);
            }
        }
    }
	
	
	/**
     * Handle dispute settings during dispute creation.
     *
     * @param int $escrow_id Escrow ID.
     */
    private function validateDisputeSettings($escrow_id, $initiator) {
		
		// Check if user is allowed to start a dispute
		if(escrot_option('dispute_initiator') !== $initiator && escrot_option('dispute_initiator') !== 'both'){
			wp_send_json_error([
				'message' => sprintf(
					__('Only the %s can start a dispute for this Escrow Transaction', 'escrowtics'),
					ucwords(escrot_option('dispute_initiator')) )
			]);
		}
		
		// Check if the dispute time has passed
		$escrow_date = escrot_get_escrow_data($escrow_id)['creation_date'];
		
		$escrow_date = new \DateTime($escrow_date, new \DateTimeZone( escrot_option('timezone') ) );
		$today = new \DateTime('now', new \DateTimeZone( escrot_option('timezone') ) );

		$interval = $escrow_date->diff($today);
		$hours = ($interval->days * 24) + $interval->h + ($interval->i / 60);
		
		if ( escrot_option('dispute_time') < $hours ) {
			wp_send_json_error([
				'message' => sprintf(
					__('You are restricted to open a dispute only after %d hours.', 'escrowtics'),
					escrot_option('dispute_time')
				)
			]);
		}
	}
	
	
	/**
	 * Handle dispute fees during dispute creation.
	 *
	 * @param int $user_id User (Complainant) ID.
	 * @param float $escrow_amt Escrow amount involved in the dispute.
	 */
	private function handleDisputeFees($user_id, $escrow_id) {
		// Exit early if no fees are required
		if (escrot_option('dispute_fees') === 'no_fee') {
			return;
		}

		// Calculate the fee based on the fee type
		$fee = 0;
		if (escrot_option('dispute_fees') === 'fixed_fee') {
			$fee = (float) escrot_option('dispute_fee_amount');
		} elseif (escrot_option('dispute_fees') === 'percentage_fee') {
			$percentage = (float) escrot_option('dispute_fee_percentage');
			$current_milestone_amt = $this->getEsrowMilestoneByescrowId($escrow_id)['amount'];
			$fee = ($percentage / 100) * $current_milestone_amt;
		}

		// Check user's balance
		$bal = (float) get_user_meta($user_id, 'balance', true);
		if ($bal < $fee) {
			wp_send_json_error(["status" => __("Insufficient balance to proceed.", "escrowtics")]);
		}

		// Deduct the fee and update the balance
		$new_bal = $bal - $fee;
		update_user_meta($user_id, 'balance', $new_bal);
	}



	/**
	 * Reply to a dispute.
	 */
	public function actionReplyDispute() {
		
		check_ajax_referer('escrot_dispute_chat_nonce', 'nonce');

		$form_data = ['dispute_id'];
		$data = escrot_sanitize_form_data($form_data);

		$data['dispute_id'] = intval($data['dispute_id']);
		
		// Get dispute data
		$dispute_data = $this->getDisputeById($data['dispute_id']);
		
		// Get the author
		if (escrot_is_front_user()) {
            $user_id = get_current_user_id();
            $username = get_user_by('ID', $user_id)->user_login;

            if ($username === $dispute_data['complainant']) {
                $author = 'Complainant';
            } else {
                $author = 'Accused';
            }
        } else {
			escrot_verify_permissions('manage_options');
            $author = 'Admin';
        }

		// Handle the meta values (message and attachment)
		if ( $this->disputeExist($data['dispute_id']) ) {
			$this->handleMetaValues($data['dispute_id'], $author);
		} else {
			wp_send_json_error(['message' => __('The dispute you are replying to, no longer exist', 'escrowtics')]);
		}

		// Prepare response data for chat reload
		$dispute_meta = $this->getDisputeMetaById($data['dispute_id']);
		ob_start();
		include ESCROT_PLUGIN_PATH . 'templates/disputes/reload-chat.php';
		$output = ob_get_clean();
		wp_send_json_success(['data' => $output]);
	}
	
	
}
