<?php
/*
Payment page
*/

use Escrowtics\api\BitcoinPay\BitcoinPayConfig;

defined('ABSPATH') or die();

if(!isset($_GET['code'])){ exit(); }

$btc_obj = new BitcoinPayConfig();

$code = wp_unslash($_GET['code']);

//Get invoice information
$data = $btc_obj->getInvoiceDataByCode($code);

$address = $data['address'];
$status = $data['status'];
$amount = $data['amount'];

$charge = 1 + ($amount*0.005);
$payable = $amount + $charge;
$btc_to_Pay = number_format($btc_obj->USDtoBTC($payable), 8, '.', ' ');

//Status translation
$statusval = $status;
$note = [__("Your Balance will be updated automatically once transaction is completed.", "escrowtics")];
$pay_info = '<h4>'.__("Please pay:", "escrowtics").'</h4> <b class="text-success">'.$btc_to_Pay.' BTC </b>'.__("to address: ", "escrowtics");
$graphic = '<h4>Scan QR code to Pay</h4>'.escrot_generate_qrcode($address);
$status_icon = '<i title="Deposit Pending" class="text-warning fa fa-exclamation-circle"></i>';

if($status == 0){
    $status = "<span style='color: orangered' id='status'>PENDING</span>";
	$note = [__("You payment has been received. Invoice will be marked paid on two blockchain confirmations.", "escrowtics"), __("Your Balance will be updated automatically once transaction is completed", "escrowtics")];
	$pay_info = __("We received", "escrowtics").' <b class="text-success">'.$btc_to_Pay.' BTC </b>'.__("in address: ", "escrowtics");
	$graphic = escrot_image(ESCROT_PLUGIN_URL.'assets/img/payment-invoice-pending.webp', '350', 'escrot-rounded');
}else if($status == 1){
    $status = "<span style='color: orangered' id='status'>PENDING</span>";
	$note = [__("You payment has been received. Invoice will be marked paid on two blockchain confirmations.", "escrowtics"), __("Your Balance will be updated automatically once transaction is completed", "escrowtics")];
	$pay_info = __("We received", "escrowtics").' <b class="text-success">'.$btc_to_Pay.' BTC </b>'.__("in address: ", "escrowtics");
	$graphic = escrot_image(ESCROT_PLUGIN_URL.'assets/img/payment-invoice-pending.webp', '350', 'escrot-rounded');
}else if($status == 2){
    $status = "<span style='color: green' id='status'>PAID</span>";
	$graphic = 'payment-invoice-pending.webp';
	$graphic = escrot_image(ESCROT_PLUGIN_URL.'assets/img/payment-invoice.png', '350', 'escrot-rounded');
	$pay_info = __("We received", "escrowtics").' <b class="text-success">'.$btc_to_Pay.' BTC </b>'.__("in address: ", "escrowtics");
	$note = [__("Your Balance has been updated. Please, check and contact admin if any irregularities.", "escrowtics")];
	$status_icon = '<i title="Deposit Completed" class="text-success fa fa-check-circle"></i>';
}else if($status == -1){
    $status = "<span style='color: red' id='status'>".__('UNPAID', 'escrowtics')."</span>";
}else if($status == -2){
    $status = "<span style='color: red' id='status'>".__('Too little paid, please pay the rest.', 'escrowtics')."</span>";
}else {
    $status = "<span style='color: red' id='status'>".__('Error, expired', 'escrowtics')."</span>";
}  

$invoice_data = [
    __('Status', 'escrowtics')  => $status,
	__('Amount', 'escrowtics')  => $amount,
	__('Charge', 'escrowtics')  => $charge,
	__('Payable', 'escrowtics') => $payable
];



?>

<!-- Invoice -->
<main class="p-5 m-lg-5 card shadow-lg">
	<div class="row">
	    <div class="col-md-8">
			<h3 style="width:100%;"><?= __("Deposit Invoice", "escrowtics").' <small>(#'.$code.')</small> '.$status_icon; ?> </h3>
			<p style="display:block;width:100%;">
				<?php echo $pay_info; ?> 
				<span class="text-info font-wight-700" id="escrot-bitcoin-address"><?php echo $address; ?></span>
			</p>
			
			<div class="about-list">
				<?php foreach($invoice_data as $tle => $val) { ?>
					<div class="media">
						<label><?php echo $tle; ?></label>
						<p><?php echo $val.' '.($tle !== 'Status'? ESCROT_CURRENCY : ''); ?></p>
					</div>
			   <?php } ?>	 
			</div><br>
			<p class="text-dark">
				<?php 
					foreach($note as $note){ echo '<span><i class="fa-regular fa-circle-dot"></i> '.$note.'</span><br>'; }
				?>
			</p>
		</div>
		<div class="col-md-4">
			<?php echo $graphic; ?>
		</div>
	</div>
</main>

<script>
	var status = <?php echo $statusval; ?>
	
	// Create socket variables
	if(status < 2 && status != -2){
	//var addr =  document.getElementById("escrot-bitcoin-address").innerHTML;
	var wsuri2 = "wss://www.blockonomics.co/payment/<?php echo $address; ?>"
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