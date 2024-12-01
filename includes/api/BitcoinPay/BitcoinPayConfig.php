<?php
/**
* Blockonomics Bitcoin Payment Configuration class of the plugin.
* Defines all DB interraction & methods for Bitcoin Payment Actions.
* @since      1.0.0
* @package    Escrowtics
*/


namespace Escrowtics\api\BitcoinPay;

defined('ABSPATH') or die();


class BitcoinPayConfig{
	
		private $paymentOrdersTable;
		private $usersTable;
		private $invoicesTable;
	
	public function __construct(){
		global $wpdb; 
		$this->paymentOrdersTable = $wpdb->prefix."escrowtics_payment_orders";
		$this->invoicesTable      = $wpdb->prefix."escrowtics_payment_invoices";
		$this->usersTable         = $wpdb->prefix."escrowtics_users";
    }
	  
	
	public function generateAddress(){
		$apikey = ESCROT_BLOCKONOMICS_API_KEY;
	    $url = 'https://www.blockonomics.co/api/';
		$options = array( 
			'http' => array(
				'header'  => 'Authorization: Bearer '.$apikey,
				'method'  => 'POST',
				'content' => '',
				'ignore_errors' => true
			)   
		);  
		
		$context = stream_context_create($options);
		$contents = file_get_contents($url."new_address", false, $context);
		$object = json_decode($contents);
		
		// Check if address was generated successfully
		if (isset($object->address)) {
		  $address = $object->address;
		} else {
		  // Show any possible errors
		  $address = $http_response_header[0]."\n".$contents;
		}
		return $address;
	}
	

	public function createInvoice($code, $amount, $address, $product){
		global $wpdb;
		$status = -1;
		$ip = $this->getIp();
		$data = ['code' => $code, 'user_id' => get_current_user_id(), 'address' => $address, 'amount' => $amount, 'status' => $status, 'product' => $product, 'ip' => $ip];
		$wpdb->insert($this->invoicesTable, $data);
	}


	public function getInvoiceDataByCode($code){
		global $wpdb;
		$sql = "SELECT * FROM $this->invoicesTable WHERE code = %s";
		$result = $wpdb->get_results($wpdb->prepare($sql, $code), ARRAY_A);
		return $result[0];
	}
	
	
	public function getInvoiceDataByAddr($address){
		global $wpdb;
		$sql = "SELECT * FROM $this->invoicesTable WHERE address = %s";
		$result = $wpdb->get_results($wpdb->prepare($sql, $address), ARRAY_A);
		return $result[0];
	}


	public function updateInvoiceStatus($code, $status){
		global $wpdb;
		$wpdb->update($this->invoicesTable, ['status' => $status], ['code' => $code]);
	}

	public function getBTCPrice($currency){
		$content = file_get_contents("http://www.blockonomics.co/api/price?currency=".$currency);
		$content = json_decode($content);
		$price = $content->price;
		return $price;
	}

	public function BTCtoUSD($amount){
		$price = $this->getBTCPrice("USD");
		return $amount * $price;
	}

	public function USDtoBTC($amount){
		$price = $this->getBTCPrice("USD");
		return $amount/$price;
	}


	public function getIp(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function createOrder($invoice, $ip){
		global $wpdb;
		$data = ["invoice" => $invoice, "ip" => $ip];
		$wpdb->insert($this->paymentOrdersTable, $data);
	}
	
	//Update user data
	public function updateUser($data) {
		global $wpdb;
		$wpdb->update($this->usersTable, $data, array('user_id' => $data['user_id']) );
	}
	


}