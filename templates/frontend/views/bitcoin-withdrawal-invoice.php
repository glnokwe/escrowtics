<?php
/*
Payment page
*/

use Escrowtics\api\BitcoinPay\BitcoinPayConfig;

defined('ABSPATH') or die();

if(!isset($_GET['code'])){ exit(); }

$btc_obj = new BitcoinPayConfig();
 

$code = wp_unslash($_GET['code']);
// Get invoice information
$data = $btc_obj->getInvoiceDataByCode($code);

$address = $data['address'];
$status = $data['status'];
$amount = $data['amount'];


//Status translation
$statusval = $status;
$info = '';
$note = [__("You will receive the exact requested amount in 3 to 5 business days.", "escrowtics") , __("Please, contact admin if you dont receive it within this time frame.", "escrowtics") ];
$graphic = 'payment-invoice-pending.webp';
$status_icon = '<i title="Withdrawal Pending" class="text-warning fa fa-exclamation-circle"></i>';

$charge = 1 + ($amount*0.005);
$payable = $amount + $charge;

if($status == -1){
    $status = "<span style='color: red' id='status'>UNPAID</span>";
	$info = __("You will receive", "escrowtics").' <b class="text-success">'.round($btc_obj->USDtoBTC($payable), 8).' BTC </b>'.__("in your  address:", "escrowtics");
}else if($status == 2){
    $status = "<span style='color: green' id='status'>PAID</span>";
	$info = __("We sent", "escrowtics").' <b class="text-success">'.round($btc_obj->USDtoBTC($payable), 8).' BTC </b>'.__("to your  address:", "escrowtics");
	$graphic = 'payment-invoice.png';
	$note = [__("We sent your resquested withdrawal amount.", "escrowtics"), __("Your Balance has been updated.", "escrowtics"), __("Contact admin if it hasn't arrived or there are irregularities.", "escrowtics")];
	$status_icon = '<i title="Withdrawal Completed" class="text-success fa fa-check-circle"></i>';
}

$invoice_data = [
    __('Status', 'escrowtics')  => $status,
	__('Amount', 'escrowtics')  => $amount,
	__('Payable', 'escrowtics') => $amount
];



?>

<!-- Invoice -->
<main class="p-5 m-lg-5 card shadow-lg">
	<div class="row">
	    <div class="col-md-7">
			<h3 style="width:100%;"> 
				<?= __("Withdrawal Invoice", "escrowtics").' <small>(#'.$code.')</small> '.$status_icon; ?>
			</h3><br>
			<p style="display:block;width:100%;">
				<?php echo $info; ?>
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
		<div class="col-md-5">
		   <?php echo escrot_image(ESCROT_PLUGIN_URL.'assets/img/'.$graphic, '450', 'escrot-rounded'); ?>
		</div>
	</div>
</main>
