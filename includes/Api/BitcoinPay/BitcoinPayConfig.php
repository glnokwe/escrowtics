<?php
/**
 * Blockonomics Bitcoin Payment Configuration class of the plugin.
 * Defines all DB interaction and methods for Bitcoin Payment Actions.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\BitcoinPay;

defined('ABSPATH') || exit;

class BitcoinPayConfig {
    private $paymentOrdersTable;
    private $usersTable;
    private $invoicesTable;

    /**
     * Constructor initializes table names.
     */
    public function __construct() {
        global $wpdb;
        $this->paymentOrdersTable = $wpdb->prefix . "escrowtics_payment_orders";
        $this->invoicesTable = $wpdb->prefix . "escrowtics_invoices";
    }

    /**
     * Generates a new Bitcoin address using Blockonomics API.
     *
     * @return string Generated address or error message.
     */
    public function generateAddress() {
        $apikey = escrot_option('blockonomics_api_key');
        $url = 'https://www.blockonomics.co/api/new_address';

        $options = [
            'http' => [
                'header' => 'Authorization: Bearer ' . $apikey,
                'method' => 'POST',
                'ignore_errors' => true,
            ]
        ];

        $context = stream_context_create($options);
        $contents = file_get_contents($url, false, $context);
        $response = json_decode($contents);

        if (isset($response->address)) {
            return $response->address;
        }

        return $http_response_header[0] . "\n" . $contents;
    }

    /**
     * Creates a new invoice entry in the database.
     *
     * @param string $code Invoice code.
     * @param float $amount Payment amount.
     * @param string $address Bitcoin address.
     * @param string $product Product description.
     */
    public function createInvoice($code, $amount, $address, $status, $product) {
        global $wpdb;

        $data = [
            'code' => $code,
            'user_id' => get_current_user_id(),
            'address' => $address,
            'amount' => $amount,
            'payment_method' => 'Bitcoin',
            'status' => $status,
            'product' => $product,
            'ip' => escrot_get_ip(),
        ];

        $wpdb->insert($this->invoicesTable, $data);
    }


    /**
     * Retrieves invoice data by Bitcoin address.
     *
     * @param string $address Bitcoin address.
     * @return array Invoice data.
     */
    public function getInvoiceDataByAddr($address) {
        global $wpdb;
        $sql = "SELECT * FROM {$this->invoicesTable} WHERE address = %s";
        return $wpdb->get_row($wpdb->prepare($sql, $address), ARRAY_A);
    }

    /**
     * Updates the status of an invoice.
     *
     * @param string $code Invoice code.
     * @param int $status New status value.
     */
    public function updateInvoiceStatus($code, $status) {
        global $wpdb;
        $wpdb->update($this->invoicesTable, ['status' => $status], ['code' => $code]);
    }

    /**
     * Retrieves the current Bitcoin price in a specific currency.
     *
     * @param string $currency Currency code (e.g., USD).
     * @return float Bitcoin price in the specified currency.
     */
    public function getBTCPrice($currency) {
        $response = file_get_contents("http://www.blockonomics.co/api/price?currency=" . $currency);
        $data = json_decode($response);
        return $data->price ?? 0.0;
    }

    /**
     * Converts Bitcoin to USD.
     *
     * @param float $amount Amount in BTC.
     * @return float Equivalent amount in USD.
     */
    public function BTCtoUSD($amount) {
        $price = $this->getBTCPrice("USD");
        return $amount * $price;
    }

    /**
     * Converts USD to Bitcoin.
     *
     * @param float $amount Amount in USD.
     * @return float Equivalent amount in BTC.
     */
    public function USDtoBTC($amount) {
        $price = $this->getBTCPrice("USD");
        return $price ? $amount / $price : 0;
    }


    /**
     * Creates a new payment order in the database.
     *
     * @param string $invoice Invoice ID.
     * @param string $ip User's IP address.
     */
    public function createOrder($invoice, $ip) {
        global $wpdb;
        $data = ['invoice' => $invoice, 'ip' => $ip];
        $wpdb->insert($this->paymentOrdersTable, $data);
    }

   
}
