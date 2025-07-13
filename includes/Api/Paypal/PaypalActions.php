<?php


namespace Escrowtics\Api\Paypal;

defined('ABSPATH') || exit;


class PaypalActions {
    
    private $clientId;
    private $secret;
	private $invoicesTable;

    public function __construct() {
		global $wpdb;
        $this->invoicesTable = $wpdb->prefix . "escrowtics_invoices";
        $this->clientId = 'AQbNXhnFYhosKiWCMVrxIhaWiqm-JBq5EdsnM6l-90TWpg-h-qs04oziCS1fSaIXKeaVIbInsIrCuXBu';
        $this->secret = 'EFT5GMMcZ4W7rwJ9bb5CCAh1c28DWakjNF-x2wuqaskCyxAonIiKtYHBc_fo13tFisAEKqSl9CmKF-gu';
    }
	
	
	  public function register() {
        add_action('wp_ajax_escrot_create_paypal_order', [$this, 'createPaypalOrder']);
        add_action('wp_ajax_nopriv_escrot_create_paypal_order', [$this, 'createPaypalOrder']);
        
        add_action('wp_ajax_escrot_capture_paypal_order', [$this, 'capturePaypalOrder']);
        add_action('wp_ajax_nopriv_escrot_capture_paypal_order', [$this, 'capturePaypalOrder']);
		
		add_action('wp_ajax_escrot_generate_paypal_withdraw_invoice', [$this, 'paypalWithdraw']);
        add_action('wp_ajax_nopriv_escrot_generate_paypal_withdraw_invoice', [$this, 'paypalWithdraw']);
    }
	
	

	/**
	 * Creates a PayPal order for the deposit amount.
	 *
	 * This method receives the amount from the frontend, creates a new PayPal order via the PayPal API,
	 * and returns the order details (including order ID) to the frontend.
	 *
	 * The user's ID is attached via the "custom_id" field for tracking purposes.
	 *
	 * @return void
	 */
	public function createPaypalOrder() {
		if (!is_user_logged_in()) {
			wp_send_json_error([
				'message' => __('You must be logged in to make a payment.', 'escrowtics')
			], 401);
		}

		$user_id = get_current_user_id();

		$body = json_decode(file_get_contents('php://input'), true);
		$amount = isset($body['amount']) ? floatval($body['amount']) : 0;

		if ($amount <= 0) {
			wp_send_json_error([
				'message' => __('Invalid amount provided.', 'escrowtics')
			], 400);
		}

		$accessToken = $this->getPaypalAccessToken();

		// Build the request to PayPal
		$response = wp_remote_post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
			'headers' => [
				'Content-Type'  => 'application/json',
				'Authorization' => "Bearer $accessToken",
			],
			'body' => json_encode([
				'intent' => 'CAPTURE',
				'purchase_units' => [[
					'amount' => [
						'currency_code' => escrot_option('currency'),
						'value'         => number_format($amount, 2, '.', ''),
					],
					'customer_id'   => intval($user_id),
					'description' => __('Escrowtics Wallet Deposit', 'escrowtics'),
				]]
			])
		]);

		// Handle response
		if (is_wp_error($response)) {
			wp_send_json_error([
				'message' => __('Failed to connect to PayPal.', 'escrowtics'),
				'details' => $response->get_error_message()
			], 500);
		}

		$responseBody = json_decode(wp_remote_retrieve_body($response), true);

		if (empty($responseBody['id'])) {
			wp_send_json_error([
				'message' => __('Failed to create PayPal order.', 'escrowtics'),
				'response' => $responseBody,
			], 500);
		}

		// Include user ID for double-checking on capture
		wp_send_json_success([
			'orderID' => $responseBody['id'],
			'user_id' => $user_id,
			'paypal_response' => $responseBody,
		]);
	}

	

	
	public function capturePaypalOrder() {
		$body = json_decode(file_get_contents('php://input'), true);
		$orderID = $body['orderID'];

		if (empty($orderID)) {
			wp_send_json_error([
				'message' => __('Missing order ID.', 'escrowtics')
			]);
			return;
		}

		$accessToken = $this->getPaypalAccessToken();

		$response = wp_remote_post("https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderID/capture", [
			'headers' => [
				'Content-Type' => 'application/json',
				'Authorization' => "Bearer $accessToken",
			],
			'body' => json_encode(new \stdClass()),
		]);

		if (is_wp_error($response)) {
			wp_send_json_error([
				'message' => __('Request error.', 'escrowtics'),
				'details' => $response->get_error_message()
			]);
			return;
		}

		$responseBody = json_decode(wp_remote_retrieve_body($response), true);

		if (isset($responseBody['error'])) {
			wp_send_json_error([
				'message' => __('PayPal API error.', 'escrowtics'),
				'details' => $responseBody
			]);
			return;
		}

		if ($responseBody['status'] === 'COMPLETED') {
			
			// Verify if user is logged in & if PayPal customer_id matches user
			$user_id = intval($body['user_id'] ?? 0);
			if (!$user_id || !is_user_logged_in() || get_current_user_id() !== $user_id) {
				wp_send_json_error([
					'message' => __('User verification failed.', 'escrowtics')
				]);
				return;
			}

			// Extract captured amount
			$amount = floatval($responseBody['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? 0);

			// Update user balance
			$current_balance = floatval(get_user_meta($user_id, 'balance', true) ?: 0);
			$new_balance = $current_balance + $amount;
			update_user_meta($user_id, 'balance', $new_balance);

			// Create Invoice
			$code = escrot_unique_id();
			$product = 'User Deposit';
			$this->createInvoice($code, $user_id, $amount, $product);

			// Log & notify
			$user = get_userdata($user_id);
			$username = $user->user_login;
			$user_email = $user->user_email;
			$ref_id = escrot_unique_id();
			$payment_method = 'Paypal';

			escrot_log_notify_user_deposit($ref_id, $username, $payment_method, $amount, $new_balance, $user_id, $code);
			escrot_user_deposit_email($code, $username, $amount, $user_email);

			wp_send_json_success([
				'title'   => __('Deposit Successful!', 'escrowtics'),
				'message' => __('Deposit Completed and balance updated.', 'escrowtics'),
				'amount'  => $amount,
				'new_balance' => $new_balance,
				'prev_balance' => $current_balance,
				'new_bal_tag'=> __('New Balance: ', 'escrowtics'),
				'prev_bal_tag'=> __('Previous Balance: ', 'escrowtics'),
				'paypal_response' => $responseBody
			]);
		} else {
			wp_send_json_error([
				'title'   => __('Deposit Failed', 'escrowtics'),
				'message' => __('Payment not completed.', 'escrowtics'),
				'paypal_status' => $responseBody['status'],
				'paypal_response' => $responseBody
			]);
		}
	}


	

	private function getPaypalAccessToken() {
		$credentials = base64_encode($this->clientId . ':' . $this->secret);

		$response = wp_remote_post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
			'headers' => [
				'Authorization' => 'Basic ' . $credentials,
				'Content-Type' => 'application/x-www-form-urlencoded',
			],
			'body' => 'grant_type=client_credentials',
		]);

		if (is_wp_error($response)) {
			wp_send_json_error([
				'message' => __('Failed to connect to PayPal:', 'escrowtics') . ' ' . $response->get_error_message(),
			], 500);
		}

		$body = json_decode(wp_remote_retrieve_body($response), true);

		if (empty($body['access_token'])) {
			wp_send_json_error([
				'message' => __('Failed to retrieve PayPal access token.', 'escrowtics'),
			], 500);
		}

		return $body['access_token'];
	}

	
	  /**
     * Creates a new invoice entry in the database.
     *
     * @param string $code Invoice code.
     * @param float $amount Payment amount.
     * @param string $address Bitcoin address.
     * @param string $product Product description.
     */
    public function createInvoice($code, $user_id, $amount, $product, $status=2, $email="") {
        global $wpdb;

        $data = [
            'code' => $code,
            'user_id' => $user_id,
            'address' => empty($email)? escrot_option('paypal_email') : $email,
            'amount' => $amount,
            'payment_method' => 'Paypal',
            'status' => $status,
            'product' => $product,
            'ip' => escrot_get_ip(),
        ];

        $wpdb->insert($this->invoicesTable, $data);
    }
	
	
	/*
	 *Paypal withdrawal
	 */
	public function paypalwithdraw(){
		 
		$form_fields = ['amount', 'paypal_email'];
		$data = escrot_sanitize_form_data($form_fields);
		$code = escrot_unique_id();
		$product = 'User Withdrawal';
		$user_id = get_current_user_id();
		$status = 1;

		$this->createInvoice($code, $user_id, $data['amount'], $product, $status, $data['paypal_email']);

		// Update user balance
		$current_balance = floatval(get_user_meta($user_id, 'balance', true) ?: 0);
		$new_balance = $current_balance + $amount;
		update_user_meta($user_id, 'balance', $new_balance);

		wp_send_json_success(['message'   => __('Paypay Withdrawal Requested Successfully!', 'escrowtics'), 'code' => $code ]);
	 }

}


