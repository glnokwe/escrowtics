<?php
/**
 * Paypal deposit invoice Page for front users
 * Renders the Paypal deposit invoice and monitor it status.
 *
 * @since    1.0.0
 * @package  Escrowtics
 */

defined('ABSPATH') || exit;

if(!isset($_GET['code'])){ exit(); }


$code = wp_unslash($_GET['code']);

$invoice = escrot_get_invoice_data($code, 'Paypal');

$note = __("Your balance was updated. Contact admin for any irregularities.", "escrowtics");
if( $invoice['status'] == 2){
	$status = "<span class='text-success' id='status'>" . esc_html__("PAID", "escrowtics") . "</span>";
	$graphic = escrot_image(ESCROT_PLUGIN_URL . 'assets/img/payment-invoice.png', '350', 'escrot-rounded');
	$status_icon = '<i title="' . esc_attr__("Withraw Completed", "escrowtics") . '" class="text-success fa fa-check-circle"></i>';
} else {
	$status = "<span class='text-danger' id='status'>" . esc_html__("PENDING", "escrowtics") . "</span>";
	$graphic = escrot_image(ESCROT_PLUGIN_URL . 'assets/img/payment-invoice-pending.webp', '350', 'escrot-rounded');
	$status_icon = '<i title="' . esc_attr__("Withraw Pending", "escrowtics") . '" class="text-danger fa fa-circle-xmark"></i>';
}

$currency = escrot_option('currency');

$invoice_data = [
	__('Status', 'escrowtics')  => $status,
	__('Amount', 'escrowtics')  => $currency. (float) $invoice['amount'],
	__('Method', 'escrowtics')  => $invoice['payment_method']. ' (' .$invoice['address']. ')',
	__('Date', 'escrowtics')    => date_i18n( 'jS M Y', strtotime($invoice['creation_date']) ),
	
];

$margin_class = escrot_is_front_user()? ' m-lg-5 ' : ' ';

?>


<main class="p-5 card<?= $margin_class ?>shadow-lg">
	<div class="row">
		<div class="col-md-8" id="escrot-invoice-print">
			<?php if( escrot_option('enable_invoice_logo') ) : ?>
				<div class="p-1"><?= escrot_image(escrot_option('company_logo'), 156); ?> </div>
			<?php endif; ?>
			<h3 style="width:100%;" class="mb-2">
				<?= esc_html__("Withrawal Invoice", "escrowtics") . ' <small>(#' . esc_html($code) . ')</small> ' . $status_icon; ?>&nbsp;&nbsp;
				<a href="#" onclick="EscrotPrintDiv('escrot-invoice-print');" title="<?= __("Print Invoice", "escrowtics"); ?>" class="escrot-print-invoice-btn">
					<i class="display text-info fas fa-print"></i>
				</a>
			</h3>
			 
			<div class="about-list">
				<?php foreach ($invoice_data as $title => $value) { ?>
					<div class="media">
						<label><?= esc_html($title); ?></label>
						<p><?= $value; ?></p>
					</div>
				<?php } ?>
			</div><br>
			<p class="text-dark">
				<span>
					<i class="fa-regular fa-circle-dot"></i> <?= esc_html($note); ?>
				</span>
			</p>
			
		</div>
		<div class="col-md-4">
			<?= $graphic; ?>
		</div>
	</div>
</main>




