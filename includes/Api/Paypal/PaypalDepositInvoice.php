<?php
/**
 * Paypal Deposit Invoice Class
 * Handles the display and logic for Paypal deposit invoices.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */


namespace Escrowtics\Api\Paypal;

// Exit if accessed directly
defined('ABSPATH') || exit;


class PaypalDepositInvoice {
	
    private $code;
    private $data;
    private $invoice_data;
    private $notes = [];
    private $graphic = '';
    private $status_icon = '';

    public function __construct($code) {
        $this->code = $code;
        $this->data = $this->getInvoiceData();
        $this->preparePaymentDetails();
    }

    /**
     * Get invoice data.
     */
    private function getInvoiceData() {
        return escrot_get_invoice_data($this->code, 'Paypal');
    }


    /**
     * Set payment details.
     *
     */
    private function preparePaymentDetails() {
		
		$currency = escrot_option('currency');
		
		$this->data['status'] = "<span style='color: green' id='status'>" . esc_html__("PAID", "escrowtics") . "</span>";
        $this->graphic = escrot_image(ESCROT_PLUGIN_URL . 'assets/img/payment-invoice.png', '350', 'escrot-rounded');
        $this->notes[] = __("Your balance was updated. Contact admin for any irregularities.", "escrowtics");
        $this->status_icon = '<i title="' . esc_attr__("Deposit Completed", "escrowtics") . '" class="text-success fa fa-check-circle"></i>';

        $this->invoice_data = [
            __('Status', 'escrowtics')  => $this->data['status'],
            __('Amount', 'escrowtics')  => $currency. (float) $this->data['amount'],
			__('Method', 'escrowtics')  => 'Paypal',
			__('Date', 'escrowtics')    => date_i18n( 'jS M Y', strtotime($this->data['creation_date']) ),
			
        ];
    }



    /**
     * Render the payment page.
     */
    public function render() {
		
		ob_start();
		$margin_class = escrot_is_front_user()? ' m-lg-5 ' : ' ';
        ?>
        <main class="p-5 card<?= $margin_class ?>shadow-lg">
            <div class="row">
                <div class="col-md-8" id="escrot-invoice-print">
				    <?php if( escrot_option('enable_invoice_logo') ) : ?>
						<div class="p-1"><?= escrot_image(escrot_option('company_logo'), 156); ?> </div>
					<?php endif; ?>
					<h3 style="width:100%;" class="mb-2">
                        <?= esc_html__("Deposit Invoice", "escrowtics") . ' <small>(#' . esc_html($this->code) . ')</small> ' . $this->status_icon; ?>&nbsp;&nbsp;
						<a href="#" onclick="EscrotPrintDiv('escrot-invoice-print');" title="<?= __("Print Invoice", "escrowtics"); ?>" class="escrot-print-invoice-btn">
							<i class="display text-info fas fa-print"></i>
						</a>
                    </h3>
					 
					<div class="about-list">
						<?php foreach ($this->invoice_data as $title => $value) { ?>
							<div class="media">
								<label><?= esc_html($title); ?></label>
								<p><?= $value; ?></p>
							</div>
						<?php } ?>
					</div><br>
					<p class="text-dark">
						<?php foreach ($this->notes as $note) {
							echo '<span><i class="fa-regular fa-circle-dot"></i> ' . esc_html($note) . '</span><br>';
						} ?>
					</p>
					
                </div>
                <div class="col-md-4">
                    <?= $this->graphic; ?>
                </div>
            </div>
        </main>
        <?php return ob_get_clean();
	}

}
