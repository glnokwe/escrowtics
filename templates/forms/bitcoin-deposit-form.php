<?php
/**
 * Bitcoin Deposit Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 

// Get the base invoice URL
$invoice_url = explode("?", esc_url(escrot_current_url()))[0];
?>

<div class="p-4 p-lg-5">
    <div class="d-flex">
        <div class="w-100">
            <h3 class="mb-4"><?= esc_html(__('Deposit via Bitcoin', 'escrowtics')); ?></h3>
            <small>
                <b>
                    <?= esc_html(__('DEPOSIT AMOUNT (1 - 20000) USD', 'escrowtics')); ?><br>
                    <?= esc_html(__('Charged 1 USD + 0.5%', 'escrowtics')); ?>
                </b>
            </small>
        </div>
    </div>

    <!-- Error Message -->
    <div style="color: red;" id="escrot-bitcoin-deposit-error"></div>

    <form 
        enctype="multi-part/form-data" 
        id="escrot-bitcoin-deposit-form" 
        data-invoice-url="<?= esc_url($invoice_url); ?>"
    >
        <input type="hidden" name="action" value="escrot_generate_bitcoin_deposit_invoice">
        <?php wp_nonce_field('escrot_deposit_invoice_nonce', 'nonce'); ?>

        <!-- Deposit Amount -->
        <div class="form-group mb-3">
            <label class="label" for="amount"><?= esc_html(__('Amount', 'escrowtics')); ?></label>
            <input 
                type="number" 
                class="form-control text-dark" 
                name="amount" 
                placeholder="<?= esc_attr(__('Enter Amount', 'escrowtics')); ?>" 
                required
            >
        </div>

        <!-- Action Buttons -->
        <button type="submit" class="btn escrot-btn-primary text-white" id="escrot-bitcoin-pay-btn">
            <?= esc_html(__('Confirm Deposit', 'escrowtics')); ?>
        </button>
        <?php if (ESCROT_INTERACTION_MODE === 'modal'): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= esc_html(__('Cancel', 'escrowtics')); ?>
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-bitcoin-deposit-form-dialog">
                <?= esc_html(__('Close Form', 'escrowtics')); ?>
            </button>
        <?php endif; ?>
    </form>
</div>
