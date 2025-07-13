<?php
/**
 * Bitcoin Deposit Invoice Class
 * Handles the display and logic for Bitcoin deposit invoices.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */


namespace Escrowtics\Api\BitcoinPay;

// Exit if accessed directly
defined('ABSPATH') || exit;

class BitcoinDepositInvoice {
    private $btc_obj;
    private $code;
    private $data;
    private $invoice_data;
    private $notes = [];
    private $pay_info = '';
    private $graphic = '';
    private $status_icon = '';

    public function __construct($btc_obj, $code) {
        $this->btc_obj = $btc_obj;
        $this->code = $code;
        $this->data = $this->getInvoiceData();
        $this->preparePaymentDetails();
    }

    /**
     * Get invoice data.
     */
    private function getInvoiceData() {
        return escrot_get_invoice_data($this->code, 'Bitcoin');
    }

    /**
     * Prepare payment details.
     */
    private function preparePaymentDetails() {
        $amount = (float) $this->data['amount'];
        $charge = 1 + ($amount * 0.005);
        $payable = $amount + $charge;

        $btc_to_Pay = number_format($this->btc_obj->USDtoBTC($payable), 8, '.', ' ');

        $this->notes[] = __("Your balance will be updated automatically once the transaction is completed.", "escrowtics");
        $this->pay_info = '<h4>' . __("Please pay:", "escrowtics") . '</h4> <b class="text-success">' . esc_html($btc_to_Pay) . ' BTC </b>' . __("to address: ", "escrowtics");
        $this->graphic = '<h4>' . __("Scan QR code to Pay", "escrowtics") . '</h4>' . escrot_generate_qrcode(esc_attr($this->data['address']));
        $this->status_icon = '<i title="' . esc_attr__("Deposit Pending", "escrowtics") . '" class="text-warning fa fa-exclamation-circle"></i>';

        $this->setStatusSpecificDetails((int) $this->data['status'], $amount, $charge, $payable, $btc_to_Pay);
    }

    /**
     * Set status-specific details.
     *
     * @param int $status
     * @param float $amount
     * @param float $charge
     * @param float $payable
     */
    private function setStatusSpecificDetails($status, $amount, $charge, $payable, $btc_to_Pay) {
        switch ($status) {
            case 0:
            case 1:
                $this->setPendingStatusDetails($btc_to_Pay);
                break;
            case 2:
                $this->setPaidStatusDetails($btc_to_Pay);
                break;
            case -1:
                $this->setUnpaidStatusDetails();
                break;
            case -2:
                $this->setPartialPaymentStatusDetails();
                break;
            default:
                $this->setErrorStatusDetails();
                break;
        }
		
		$currency = escrot_option('currency');

        $this->invoice_data = [
            __('Status', 'escrowtics')  => $this->data['status'],
            __('Amount', 'escrowtics')  => $currency.number_format($amount, 2),
            __('Charge', 'escrowtics')  => $currency.number_format($charge, 2),
            __('Payable', 'escrowtics') => $currency.number_format($payable, 2),
			__('Method', 'escrowtics')  => 'Bitcoin'
        ];
    }

    private function setPendingStatusDetails($btc_to_Pay) {
        $this->data['status'] = "<span style='color: orangered' id='status'>" . esc_html__("PENDING", "escrowtics") . "</span>";
        $this->notes[] = __("Your payment has been received. The invoice will be marked paid after two blockchain confirmations.", "escrowtics");
        $this->graphic = escrot_image(ESCROT_PLUGIN_URL . 'assets/img/payment-invoice-pending.webp', '350', 'escrot-rounded');
		$this->pay_info = __("We received", "escrowtics").' <b class="text-success">'.$btc_to_Pay.' BTC </b>'.__("at address: ", "escrowtics");
    }

    private function setPaidStatusDetails($btc_to_Pay) {
        $this->data['status'] = "<span style='color: green' id='status'>" . esc_html__("PAID", "escrowtics") . "</span>";
        $this->graphic = escrot_image(ESCROT_PLUGIN_URL . 'assets/img/payment-invoice.png', '350', 'escrot-rounded');
        $this->notes[] = __("Your balance has been updated. Please check and contact the admin if there are any irregularities.", "escrowtics");
        $this->status_icon = '<i title="' . esc_attr__("Deposit Completed", "escrowtics") . '" class="text-success fa fa-check-circle"></i>';
		$this->pay_info = __("We received", "escrowtics").' <b class="text-success">'.$btc_to_Pay.' BTC </b>'.__("at address: ", "escrowtics");
    }

    private function setUnpaidStatusDetails() {
        $this->data['status'] = "<span style='color: red' id='status'>" . esc_html__('UNPAID', 'escrowtics') . "</span>";
    }

    private function setPartialPaymentStatusDetails() {
        $this->data['status'] = "<span style='color: red' id='status'>" . esc_html__('Too little paid, please pay the rest.', 'escrowtics') . "</span>";
    }

    private function setErrorStatusDetails() {
        $this->data['status'] = "<span style='color: red' id='status'>" . esc_html__('Error, expired', 'escrowtics') . "</span>";
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
					 
					<p style="display:block;width:100%;">
						<?= $this->pay_info; ?>
						<span class="text-info font-wight-700" id="escrot-bitcoin-address"><?= esc_html($this->data['address']); ?></span>
					</p>
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
