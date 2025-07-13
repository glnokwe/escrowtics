<?php
/**
 * Manual Deposit Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

// Define payment methods
$payment_methods = [
     ''             => __('-- Select --', 'escrowtics'),
    'Apple Pay'     => __('Apple Pay', 'escrowtics'),
    'Cash'          => __('Cash', 'escrowtics'),
    'Cash App'      => __('Cash App', 'escrowtics'),
    'Check'         => __('Check', 'escrowtics'),
    'Credit Card'   => __('Credit Card', 'escrowtics'),
    'Google Pay'    => __('Google Pay', 'escrowtics'),
    'Mobile Money'  => __('Mobile Money', 'escrowtics'),
    'Western Union' => __('Western Union', 'escrowtics'),
    'Wired Transfer'=> __('Wired Transfer', 'escrowtics'),
    'Zelle'         => __('Zelle', 'escrowtics'),
    'Other'         => __('Other', 'escrowtics'),
];

// Get the base invoice URL
$invoice_url = explode("?", esc_url(escrot_current_url()))[0];

?>

<div class="escrot-payment-wrap p-4 p-lg-5">
    <div class="d-flex">
        <div class="w-100">
            <h3 class="mb-4"><?= esc_html(__('Decide How You Want Deposit Money', 'escrowtics')); ?></h3>
            <small><b><?= esc_html(__('Deposit Limits (1 - 20000) USD', 'escrowtics')); ?></b></small>
        </div>
    </div>

    <form enctype="multi-part/form-data" id="escrot-manual-deposit-form" data-invoice-url="<?= esc_url($invoice_url); ?>">
        <input type="hidden" name="action" value="escrot_manual_deposit_invoice">
        <?php wp_nonce_field('escrot_deposit_invoice_nonce', 'nonce'); ?>

        <!-- Render Form Fields -->
        <div class="row">
			<div class="form-group col-md-6 mb-3">
				<label class="label" for="amount">
					<?= __('Amount', 'escrowtics'); ?>
				</label>
				<input type="number"  name="amount" class="form-control text-dark"  placeholder="<?= __('Enter Amount', 'escrowtics'); ?>" required >
			</div>

            <!-- Payment Methods Dropdown -->
            <div class="form-group col-md-6">
                <label for="payment_methods">
                    <?= __('Payment Methods', 'escrowtics'); ?>
                </label>
                <select class="form-control" id="escrot-manual-deposit-payment-select" name="payment_method">
                    <?php foreach ($payment_methods as $value => $label): ?>
                        <option value="<?= esc_attr($value); ?>"><?= esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
			
			<div class="form-group collapse col-md-12" id="escrot-manual-deposit-other-payment">
				<label class="label" for="other_payment">
					<?= __('Specify Other Payment Methods', 'escrowtics'); ?>
				</label>
				<input type="text" name="other_payment" class="form-control text-dark" placeholder="<?= __('Enter Other Payment Methods', 'escrowtics'); ?>" >
			</div>
        </div>
        <br>

        <!-- Submit and Action Buttons -->
        <button type="submit" class="btn escrot-btn-primary text-white" id="escrot-manual-deposit-btn">
            <?= __('Confirm Deposit', 'escrowtics'); ?>
        </button>
        <?php if (ESCROT_INTERACTION_MODE === 'modal'): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= __('Cancel', 'escrowtics'); ?>
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-manual-deposit-form-dialog">
                <?= __('Close Form', 'escrowtics'); ?>
            </button>
        <?php endif; ?>
    </form>
</div>
