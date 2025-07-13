<?php
/**
 * Bitcoin Withdrawal Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 

// Get the base invoice URL
$invoice_url = explode("?", esc_url(escrot_current_url()))[0];
?>

<div class="escrot-payment-wrap p-4 p-lg-5">
    <div class="d-flex">
        <div class="w-100">
            <h3 class="mb-4"><?= esc_html(__('Withdraw via Bitcoin', 'escrowtics')); ?></h3>
            <small><b><?= esc_html(__('WITHDRAW AMOUNT (minimum: $100)', 'escrowtics')); ?></b></small>
        </div>
    </div>

    <!-- Error Message -->
    <div style="color: red;" id="escrot-bitcoin-withdraw-error"></div>

    <form 
        enctype="multi-part/form-data" 
        id="escrot-bitcoin-withdraw-form" 
        data-invoice-url="<?= esc_url($invoice_url); ?>"
    >
        <input type="hidden" name="action" value="escrot_generate_bitcoin_withdrawal_invoice">
        <?php wp_nonce_field('escrot_withdraw_invoice_nonce', 'nonce'); ?>

        <div class="row">
            <!-- Amount Field -->
            <div class="form-group col-md-6 mb-3">
                <label class="label" for="amount"><?= esc_html(__('Amount', 'escrowtics')); ?></label>
                <input 
                    type="number" 
                    class="form-control text-dark" 
                    name="amount" 
                    placeholder="<?= esc_attr(__('Enter Amount', 'escrowtics')); ?>" 
                    required
                >
            </div>

            <!-- Bitcoin Wallet Address Field -->
            <div class="form-group col-md-6 mb-3">
                <label class="label" for="wallet"><?= esc_html(__('Bitcoin Wallet Address', 'escrowtics')); ?></label>
                <input 
                    type="text" 
                    class="form-control text-dark" 
                    name="wallet" 
                    placeholder="<?= esc_attr(__('Enter Bitcoin Wallet Address', 'escrowtics')); ?>" 
                    required
                >
            </div>
        </div>

        <!-- Action Buttons -->
        <button type="submit" class="btn escrot-btn-primary text-white" id="escrot-bitcoin-pay-btn">
            <?= esc_html(__('Confirm Withdrawal', 'escrowtics')); ?>
        </button>
        <?php if (ESCROT_INTERACTION_MODE === 'modal'): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= esc_html(__('Cancel', 'escrowtics')); ?>
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-bitcoin-withdraw-form-dialog">
                <?= esc_html(__('Close Form', 'escrowtics')); ?>
            </button>
        <?php endif; ?>
    </form>
</div>
