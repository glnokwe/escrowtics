<?php
/**
 * Class for generating and displaying Bitcoin withdrawal invoices.
 * Handles the logic for retrieving invoice data, translating status, and rendering the invoice UI.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\BitcoinPay;

defined('ABSPATH') || exit;

class BitcoinWithdrawalInvoice {
    private $btc_obj;
    private $code;
    private $data;
    private $statusIcon;
    private $statusMessage;
    private $infoMessage;
    private $notes;
    private $graphic;
    private $invoiceData;

    /**
     * Constructor to initialize the class with the necessary dependencies and data.
     *
     * @param $btc_obj BitcoinPayConfig instance for handling Bitcoin data.
     * @param string $code The unique code for the invoice.
     */
    public function __construct($btc_obj, $code) {
        $this->btc_obj = $btc_obj;
        $this->code = $code;
        $this->fetchInvoiceData();
        $this->translateStatus();
        $this->prepareInvoiceData();
    }

    /**
     * Fetch invoice data by code and initialize the basic data properties.
     */
    private function fetchInvoiceData() {
        $this->data = $this->btc_obj->getInvoiceDataByCode($this->code);
    }

    /**
     * Translate the invoice status into meaningful UI elements and messages.
     */
    private function translateStatus() {
        $address = $this->data['address'];
        $status = $this->data['status'];
        $amount = $this->data['amount'];
		
        $charge = 1 + ($amount * 0.005);
        $payable = $amount + $charge;

        if ($status == 2) {
            $this->statusMessage = "<span style='color: green' id='status'>".esc_html__('PAID', 'escrowtics')."</span>";
            $this->infoMessage = __("We sent", "escrowtics") . 
                                 ' <b class="text-success">' . round($this->btc_obj->USDtoBTC($payable), 8) . 
                                 ' BTC </b>' . __("to your address:", "escrowtics");
            $this->graphic = 'payment-invoice.png';
            $this->statusIcon = '<i title="Withdrawal Completed" class="text-success fa fa-check-circle"></i>';
            $this->notes = [
                __("We sent your requested withdrawal amount.", "escrowtics"),
                __("Your balance has been updated.", "escrowtics"),
                __("Contact admin if it hasn't arrived or there are irregularities.", "escrowtics")
            ];
        } else {
			$this->statusMessage = "<span style='color: orangered' id='status'>".esc_html__('PENDING', 'escrowtics')."</span>";
            $this->infoMessage = __("You will receive", "escrowtics") . 
                                 ' <b class="text-success">' . round($this->btc_obj->USDtoBTC($payable), 8) . 
                                 ' BTC </b>' . __("in your address:", "escrowtics");
            $this->graphic = 'payment-invoice-pending.webp';
            $this->statusIcon = '<i title="Withdrawal Pending" class="text-warning fa fa-exclamation-circle"></i>';
            $this->notes = [
                __("You will receive the exact requested amount in 3 to 5 business days.", "escrowtics"),
                __("Please, contact admin if you don't receive it within this time frame.", "escrowtics")
            ];
		}
    }

    /**
     * Prepare invoice data for rendering.
     */
    private function prepareInvoiceData() {
		$this->invoiceData = [
            __('Status', 'escrowtics')  => $this->statusMessage,
            __('Amount', 'escrowtics')  => $this->data['amount'],
            __('Payable', 'escrowtics') => $this->data['amount']
        ];
    }

    /**
     * Render the withdrawal invoice UI.
     */
    public function render() {
		ob_start();
		$margin_class = escrot_is_front_user()? ' m-lg-5 ' : ' ';
        ?>
        <main class="p-5<?= $margin_class;  ?>card shadow-lg">
            <div class="row">
                <div class="col-md-7" id="escrot-invoice-print">
				    <?php if(escrot_option('enable_invoice_logo')) : ?>
						<div class="p-1"><?= escrot_image(escrot_option('company_logo'), 156); ?> </div>
					<?php endif; ?>
                    <h3 style="width:100%;" class="mb-2">
                        <?= __("Withdrawal Invoice", "escrowtics") . 
                            ' <small>(#' . $this->code . ')</small> ' . $this->statusIcon; ?>&nbsp;&nbsp;
						<a href="#" onclick="EscrotPrintDiv('escrot-invoice-print');" title="<?= __("Print Invoice", "escrowtics"); ?>" class="escrot-print-invoice-btn">
							<i class="display text-info fas fa-print"></i>
						</a>	
                    </h3><br>
                    <p style="display:block;width:100%;">
                        <?= $this->infoMessage; ?>
                        <span class="text-info font-weight-700" id="escrot-bitcoin-address">
                            <?= $this->data['address']; ?>
                        </span>
                    </p>

                    <div class="about-list">
                        <?php foreach ($this->invoiceData as $title => $value) { ?>
                            <div class="media">
                                <label><?= $title; ?></label>
                                <p><?= $value . ' ' . ($title !== 'Status' ? escrot_option('currency') : ''); ?></p>
                            </div>
                        <?php } ?>
                    </div><br>

                    <p class="text-dark">
                        <?php foreach ($this->notes as $note) {
                            echo '<span><i class="fa-regular fa-circle-dot"></i> ' . $note . '</span><br>';
                        } ?>
                    </p>
                </div>
                <div class="col-md-5">
                    <?= escrot_image(ESCROT_PLUGIN_URL . 'assets/img/' . $this->graphic, '450', 'escrot-rounded'); ?>
                </div>
            </div>
        </main>
        <?php return ob_get_clean();
    }
}

