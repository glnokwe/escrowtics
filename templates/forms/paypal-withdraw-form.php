<?php
/**
 * PayPal Withdraw Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 

// Define form fields
$paypal_withdraw_fields = [
    [
        'label' => __('Amount', 'escrowtics'),
        'type' => 'number',
        'name' => 'amount',
        'placeholder' => __('Enter Amount', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
        'required' => true,
    ],
	[
        'label' => __('Paypal Email', 'escrowtics'),
        'type' => 'email',
        'name' => 'paypal_email',
        'placeholder' => __('Enter Paypal Email', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
        'required' => true,
    ],
];

$invoice_url = explode("?", esc_url(escrot_current_url()))[0];

?>

<div class="escrot-payment-wrap p-4 p-lg-5">
    <div class="d-flex">
        <div class="w-100">
            <h3 class="mb-4"><?= esc_html(__('Withdraw via Paypal', 'escrowtics')); ?></h3>
            <small><b><?= esc_html(__('Withdrawal Amount (1 - 20000) USD', 'escrowtics')); ?></b></small>
        </div>
    </div>

    <form enctype="multi-part/form-data" id="escrot-paypal-withdraw-form" data-invoice-url="<?= esc_url($invoice_url); ?>">
        <input type="hidden" name="action" value="escrot_generate_paypal_withdraw_invoice">
        <input type="hidden" class="form-control text-dark" name="paypal_email">
        <?php wp_nonce_field('escrot_withdraw_invoice_nonce', 'nonce'); ?>

        <!-- Render Form Fields -->
        <div class="row">
            <?php foreach ($paypal_withdraw_fields as $field): ?>
                <div class="<?= esc_attr($field['col_class']); ?>">
                    <div class="form-group mb-3">
                        <label class="label" for="<?= esc_attr($field['name']); ?>">
                            <?= esc_html($field['label']); ?>
                        </label>
                        <input 
                            type="<?= esc_attr($field['type']); ?>" 
                            name="<?= esc_attr($field['name']); ?>" 
                            class="<?= esc_attr($field['class']); ?>" 
                            placeholder="<?= esc_attr($field['placeholder']); ?>" 
                            <?= $field['required'] ? 'required' : ''; ?>>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <br>

        <!-- Submit and Action Buttons -->
        <button type="submit" class="btn escrot-btn-primary text-white" id="escrot-paypal-pay-btn">
            <?= esc_html(__('Withdraw Amount', 'escrowtics')); ?>
        </button>
        <?php if (ESCROT_INTERACTION_MODE == 'modal'): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= esc_html(__('Cancel', 'escrowtics')); ?>
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-paypal-withdraw-form-dialog">
                <?= esc_html(__('Close Form', 'escrowtics')); ?>
            </button>
        <?php endif; ?>
    </form>
</div>
