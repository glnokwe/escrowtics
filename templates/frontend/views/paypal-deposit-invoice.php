<?php
/**
 * Paypal deposit invoice Page for front users
 * Renders the Paypal deposit invoice and monitor it status.
 *
 * @since    1.0.0
 * @package  Escrowtics
 */

use Escrowtics\Api\Paypal\PaypalDepositInvoice;

defined('ABSPATH') || exit;

if(!isset($_GET['code'])){ exit(); }


$code = wp_unslash($_GET['code']);

$deposit_invoice = new PaypalDepositInvoice($code);

echo $deposit_invoice->render(); 



