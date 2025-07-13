<?php
/**
 * PayPal Deposit Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 
 

// Define form fields
$paypal_deposit_fields = [
    [
        'label' => __('Amount', 'escrowtics'),
        'type' => 'number',
        'name' => 'amount',
        'placeholder' => __('Enter Amount', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-12',
        'required' => true,
    ],
];

$user_id = get_current_user_id();
$balance = get_user_meta($user_id, 'balance', true);

?>

<div class="justify-content-center p-4 p-lg-5">
    <div class="d-flex">
        <div class="w-100 mb-3">
            <h3 class="mb-1"><?= sprintf( __('Deposit Upto %s%s via Paypal for your Escrow Orders', 'escrowtics'), escrot_option('currency'), 2000 ); ?></h3>
			 <small><b><?= esc_html(__('Note: Paypal Charges will apply', 'escrowtics')); ?></b></small>
        </div>
    </div>

    <!-- Error Message -->
    <div class="text-danger" id="escrot-paypal-deposit-error"></div>

    <form enctype="multi-part/form-data" id="escrot-paypal-deposit-form">
        <input type="hidden" name="action" value="escrot_generate_paypal_deposit_invoice">
		<input id="escrot_user_bal_input" type="hidden" name="user_balance" value="<?= $balance; ?>">
        <?php wp_nonce_field('escrot_deposit_invoice_nonce', 'nonce'); ?>

        <!-- Render Form Fields -->
        <div class="row">
            <?php foreach ($paypal_deposit_fields as $field): ?>
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
            <?= esc_html(__('Continue to Paypal', 'escrowtics')); ?>
        </button>
        <?php if (ESCROT_INTERACTION_MODE == 'modal'): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= esc_html(__('Cancel', 'escrowtics')); ?>
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-paypal-deposit-form-dialog">
                <?= esc_html(__('Close Form', 'escrowtics')); ?>
            </button>
        <?php endif; ?>
    </form>


	<div id="paypal-button-container" class="" style="display: none;"></div>

	<div id="escrot-change-amount-btn" style="display: none;">
		<button type="button" class="mb-5 btn btn-secondary mt-3">
			<i class="fa fa-pencil"></i> <?php echo esc_html(__('Change Amount', 'escrowtics')); ?>
		</button>
		<span id="escrot-paypal-deposit-amt" class="h3 m-4"></span>
	</div>

</div>