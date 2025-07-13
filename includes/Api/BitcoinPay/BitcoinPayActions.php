<?php
/**
 * Blockonomics Bitcoin Payment Action class of the plugin.
 * Defines all Bitcoin Payment Actions.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\BitcoinPay;

use Escrowtics\Api\BitcoinPay\BitcoinPayConfig;
use Escrowtics\Api\BitcoinPay\BitcoinDepositInvoice;

defined('ABSPATH') || exit;

class BitcoinPayActions extends BitcoinPayConfig {

    private $secret_local = "escrowtics";

    /**
     * Register hooks and actions.
     */
    public function register() {
        add_action('wp_ajax_escrot_generate_bitcoin_deposit_invoice', [$this, 'generateDepositInvoice']);
        add_action('wp_ajax_escrot_generate_bitcoin_withdrawal_invoice', [$this, 'generateWithdrawInvoice']);
        add_action('wp_ajax_escrot_update_invoice_status', [$this, 'updateWithdrawInvoice']);
		add_action('wp_ajax_escrot_view_deposit_invoice', [$this, 'viewDepositInvoice']);
		add_action('wp_ajax_escrot_view_withdrawal_invoice', [$this, 'viewWithdrawalInvoice']);
        add_action('admin_post_nopriv_escrot_bicoin_pay_status', [$this, 'checkPaymentStatus'], 10);
    }

    /**
     * Generate a Bitcoin deposit invoice.
     */
    public function generateDepositInvoice() {
		escrot_validate_ajax_nonce('escrot_deposit_invoice_nonce', 'nonce');
        
        $amount = $this->getSanitizedPostValue('amount');
        if ($amount < 1) {
            wp_send_json_error(['message' => __("Minimum Deposit amount is $1", "escrowtics")]);
        }

        $code = escrot_unique_id();
        $address = $this->generateAddress();
		$status = -1;
        $product = 'User Deposit';

        $this->createInvoice($code, $amount, $address, $status, $product);
        wp_send_json_success(['message' => 'Deposit invoice gerated successfully', 'code' => $code]);
    }

    /**
     * Generate a Bitcoin withdrawal invoice.
     */
    public function generateWithdrawInvoice() {
		escrot_validate_ajax_nonce('escrot_withdraw_invoice_nonce', 'nonce');
		
        $amount = $this->getSanitizedPostValue('amount');
        if ($amount < 100) {
            wp_send_json_error(['message' => __("Minimum Withdrawal amount is $100", "escrowtics")]);
        }

        $user_id = get_current_user_id();
        $balance = get_user_meta($user_id, 'balance', true);

        if ($amount > $balance) {
            wp_send_json_error(['message' => __("Insufficient Balance to Proceed", "escrowtics")]);
        }

        $code = escrot_unique_id();
        $address = $this->getSanitizedPostValue('wallet');
		$status = 0;
        $product = 'User Withdrawal';

        $this->createInvoice($code, $amount, $address, $status, $product);
		
		update_user_meta($user_id, 'balance', $balance - $amount); //Update user balance

        wp_send_json_success(['message' => 'Withdrawal invoice gerated successfully', 'code' => $code]);
    }

    /**
     * Update the status of a withdrawal invoice.
     */
    public function updateWithdrawInvoice() {
		escrot_validate_ajax_nonce('escrot_invoice_status_nonce', 'nonce');
        
        $code = $this->getSanitizedPostValue('code');
        $status = $this->getSanitizedPostValue('status');

        $this->updateInvoiceStatus($code, $status);

        if ($status == 2) {
            $this->handleConfirmedWithdrawal($code);
        }

        wp_send_json_success(['message' => 'Invoice Updated Successfully']);
    }
	
	 /**
     * View Deposit Invoice.
     */
    public function viewDepositInvoice() {
		if($_POST['invoice_code']){
			$code = sanitize_text_field($_POST['invoice_code']);
			$deposit_invoice = new BitcoinDepositInvoice($this, $code);
			wp_send_json(['data' => $deposit_invoice->render()]); 
		}
	}
	
	/**
     * View Withdrawal Invoice.
     */
    public function viewWithdrawalInvoice() {
		if($_POST['invoice_code']){
			$code = sanitize_text_field($_POST['invoice_code']);
			$withdrawal_invoice = new BitcoinWithdrawalInvoice($this, $code);
			wp_send_json(['data' => $withdrawal_invoice->render()]); 
		}
	}
	

    /**
     * Check payment status via callback.
     */
    public function checkPaymentStatus() {
        if (!$this->validatePaymentStatusRequest()) {
            exit();
        }

        $params = $this->getPaymentStatusParams();
        if ($params['secret'] !== $this->secret_local) {
            exit();
        }

        $invoice = $this->getInvoiceDataByAddr($params['addr']);
        if ($params['status'] < 0) {
            exit();
        }

        $this->processPaymentStatus($invoice, $params);
    }
	

	 /* Utilities */

    private function getSanitizedPostValue($key) {
        return isset($_POST[$key]) ? sanitize_text_field($_POST[$key]) : '';
    }


    private function handleConfirmedWithdrawal($code) {
        $invoice = escrot_get_invoice_data($code, 'Bitcoin');
        $user_id = $invoice['user_id'];
        $amount = $invoice['amount'];
        $balance = get_user_meta($user_id, 'balance', true);
		
		$user = get_user_by('ID', $user_id);
        $username = $user->user_login;
		$user_email = $user->user_email;

        escrot_log_notify_user_withdrawal(escrot_unique_id(), $username, $amount, $balance, $user_id, $code);
        escrot_user_withdrawal_email($code, $username, $amount, $user_email);
    }

    private function validatePaymentStatusRequest() {
        return isset($_GET['txid'], $_GET['value'], $_GET['status'], $_GET['addr'], $_GET['secret']);
    }

    private function getPaymentStatusParams() {
        return [
            'txid' => wp_unslash($_GET['txid']),
            'value' => wp_unslash($_GET['value']),
            'status' => wp_unslash($_GET['status']),
            'addr' => wp_unslash($_GET['addr']),
            'secret' => wp_unslash($_GET['secret']),
        ];
    }

    private function processPaymentStatus($invoice, $params) {
        $code = $invoice['code'];
        $amount = $invoice['amount'];

        $amount_btc = $this->USDtoBTC($amount);
        $amount_satoshi = $amount_btc * 100000000;

        if ($params['value'] >= round($amount_satoshi)) {
            $this->updateInvoiceStatus($code, $params['status']);
            if ($params['status'] == 2) {
                $this->handleSuccessfulDeposit($invoice, $amount, $code);
            }
        } else {
            $this->updateInvoiceStatus($code, -2); // User hasn't paid enough
        }
    }

    private function handleSuccessfulDeposit($invoice, $amount, $code) {
        $user_id = $invoice['user_id'];
        $balance = get_user_meta($user_id, 'balance', true);
        $new_balance = $balance + $amount;
		
		update_user_meta($user_id, 'balance', $new_balance); //Update user balance
		
		$user = get_user_by('ID', $user_id);
        $username = $user->user_login;
		$user_email = $user->user_email;
		$payment_method = 'Bitcoin';
		$ref_id = escrot_unique_id();
		
        escrot_log_notify_user_deposit($ref_id, $username, $payment_method, $amount, $new_balance, $user_id, $code);
        escrot_user_deposit_email($code, $username, $amount, $user_email);
    }
}
