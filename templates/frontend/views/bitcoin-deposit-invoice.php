<?php
/**
 * Bitcoin deposit invoice Page for front users
 * Renders the Bitcoin deposit invoice and monitor it status.
 *
 * @since    1.0.0
 * @package  Escrowtics
 */

use Escrowtics\Api\BitcoinPay\BitcoinPayConfig;
use Escrowtics\Api\BitcoinPay\BitcoinDepositInvoice;

defined('ABSPATH') || exit;

if(!isset($_GET['code'])){ exit(); }

$btc_obj = new BitcoinPayConfig();

$code = wp_unslash($_GET['code']);

$invoice_data = escrot_get_invoice_data($code, 'Bitcoin');

$status  = $invoice_data['status'];
$address = $invoice_data['address'];

$deposit_invoice = new BitcoinDepositInvoice($btc_obj, $code);

echo $deposit_invoice->render(); 

?>

<script>
	var status = <?= $status; ?>
	
	// Create socket variables
	if(status < 2 && status != -2){
	//var addr =  document.getElementById("escrot-bitcoin-address").innerHTML;
	var wsuri2 = "wss://www.blockonomics.co/payment/<?= $address; ?>"
	// Create socket and monitor
	var socket = new WebSocket(wsuri2, "protocolOne")
		socket.onmessage = function(event){
			console.log(event.data);
			response = JSON.parse(event.data);
			//Refresh page if payment moved up one status
			if (response.status > status)
			  setTimeout(function(){ window.location=window.location }, 1000);
		}
	}
</script>