<?php
/**
 * Bitcoin withdrawal invoice Page for front users
 * Renders the Bitcoin withdrawal invoice and monitor its status.
 *
 * @since    1.0.0
 * @package  Escrowtics
 */
 
 
use Escrowtics\Api\BitcoinPay\BitcoinPayConfig;
use Escrowtics\Api\BitcoinPay\BitcoinWithdrawalInvoice;

defined('ABSPATH') || exit;

if(!isset($_GET['code'])){ exit(); }

$btc_obj = new BitcoinPayConfig();
 
$code = wp_unslash($_GET['code']);

$withdrawal_invoice = new BitcoinWithdrawalInvoice($btc_obj, $code);

echo $withdrawal_invoice->render(); 