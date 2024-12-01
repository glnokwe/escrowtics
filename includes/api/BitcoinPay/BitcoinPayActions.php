<?php
/**
* Blockonomics Bitcoin Payment Action class of the plugin.
* Defines all Bitcoin Payment Actions.
* @since      1.0.0
* @package    Escrowtics
*/

namespace Escrowtics\api\BitcoinPay;

use Escrowtics\api\BitcoinPay\BitcoinPayConfig; 

defined('ABSPATH') or die();

class BitcoinPayActions extends BitcoinPayConfig {
	
	public function register() {
	
		//Register hooks 
		add_action( 'wp_ajax_escrot_generate_bitcoin_deposit_invoice', array($this, 'generateDepositInvoice' ));
		add_action( 'wp_ajax_escrot_generate_bitcoin_withdrawal_invoice', array($this, 'generateWithdrawInvoice' ));
		add_action( 'wp_ajax_escrot_update_invoice_status', array($this, 'actionUpdateWithdrawInvoice' ));
		add_action('admin_post_nopriv_escrot_bicoin_pay_status',  array($this, 'checkPaymentStatus' ), 10);
    }		
	
	public function generateDepositInvoice(){
		
		if(!check_ajax_referer( 'escrot_deposit_invoice_nonce', 'nonce' )) {
			wp_send_json('Error: Invalid nonce. Try reloading the page'); 
		}
		
		$amount = isset($_POST['amount']) ? sanitize_text_field($_POST["amount"]) : '';
		
		if($amount < 1){//Check amount
			wp_send_json(['status' => __("Minimum Deposit amount is $1", "escrowtics")]); 
		}
		
		$code = escrot_unique_id();
		$address = $this->generateAddress();
		$product = 'User Deposit';
		$this->createInvoice($code, $amount, $address, $product);
		wp_send_json(['status' => 'success', 'code' => $code]); 
    }
	
	public function generateWithdrawInvoice(){
		
		if(!check_ajax_referer( 'escrot_withdraw_invoice_nonce', 'nonce' )) {
			wp_send_json('Error: Invalid nonce. Try reloading the page'); 
		}
		
		$amount = isset($_POST['amount']) ? sanitize_text_field($_POST["amount"]) : '';
		
		if($amount < 100){//Check amount
			wp_send_json(['status' => __("Minimum Withdrawal amount is $100", "escrowtics")]); 
		}
		
		$user_id = get_current_user_id();
		$bal = escrot_get_user_data($user_id)['balance'];
		
		if($amount > $bal){//Check balance
			wp_send_json(['status' => __("Insufficient Balance to Proceed", "escrowtics")]); 
		}
		
		$code = escrot_unique_id();
		$address = isset($_POST['wallet']) ? sanitize_text_field($_POST["wallet"]) : '';
		$product = 'User Withdrawal';
		$this->createInvoice($code, $amount, $address, $product);//Create invoice
		
		//Update User Balance
		$new_bal = $bal - $amount;
		$data = ['balance' => $new_bal, 'user_id' => $user_id];
		$this->updateUser($data);
		
		wp_send_json(['status' => 'success', 'code' => $code]); 
    }
	
	
	public function actionUpdateWithdrawInvoice(){
		
		if(!check_ajax_referer( 'escrot_invoice_status_nonce', 'nonce' )) {
			wp_send_json('Error: Invalid nonce. Try reloading the page'); 
		}
		
		$code   = isset($_POST['code']) ? sanitize_text_field($_POST["code"]) : '';
		$status = isset($_POST['status']) ? sanitize_text_field($_POST["status"]) : '';
		$this->updateInvoiceStatus($code, $status);
		
		if($status == 2){//log & notify
			$invoice = $this->getInvoiceDataByCode($code);
			$user_id = $invoice['user_id'];
			$amount  = $invoice['amount'];
			$bal = escrot_get_user_data($user_id)['balance'];
			$username = escrot_get_user_data($user_id)['username'];
			escrot_log_notify_user_withdrawal(escrot_unique_id(), $username, $amount, $bal, $user_id, $code);
			escrot_user_withdrawal_email($code, $username, $amount);
		}
		
		wp_send_json(['status' => 'success', 'message' => 'Invoice Updated Successfully']); 
    }
	
	
	public function checkPaymentStatus(){
	
		$secretlocal = "escrowtics"; //Code in the callback, make sure this matches to what you've set

		//Check if all url parameters are set
	    if ( !isset($_GET['txid']) || !isset($_GET['value']) || !isset($_GET['status']) || !isset($_GET['addr']) || !isset($_GET['secret']) ){
			exit();
		} 

		//Get all parameters values
		$status = 0;
		$txid   = wp_unslash($_GET['txid']);
		$value  = wp_unslash($_GET['value']);
		$status = wp_unslash($_GET['status']);
		$addr   = wp_unslash($_GET['addr']);
		$secret = wp_unslash($_GET['secret']);


		if($secret !== $secretlocal){
			exit();
		}

		//Get invoice information
		$code = $this->getInvoiceDataByAddr($addr)['code'];
		$invoice = $this->getInvoiceDataByCode($code);

		//Get invoice price
		$amount = $invoice['amount'];

		//Convert amount to satoshi for check
		$amount_btc = $this->USDtoBTC($amount);
		$amount_satoshi = $amount_btc *100000000;

		//Expired
		if($status < 0){  exit(); }


		if($value >= round($amount_satoshi)){
			
			$this->updateInvoiceStatus($code, $status); //Update invoice status
			if($status == 2){ // Correct amount paid and fully confirmed
			
				//Update User Balance
				$user_id = $invoice['user_id'];
				$bal = escrot_get_user_data($user_id)['balance'];
				$new_bal = $bal + $amount;
				$data = ['balance' => $new_bal, 'user_id' => $user_id];
				$this->updateUser($data);
				$username = escrot_get_user_data($user_id)['username'];
				
				
				//Log & Notify
				escrot_log_notify_user_deposit(escrot_unique_id(), $username, $amount, $new_bal, $user_id, $code);
				escrot_user_deposit_email($code, $username, $amount);
				
			}
		}else {
			//User hasnt deposited enough
			$this->updateInvoiceStatus($code, -2);
		}
		
		
		
    }


}