<?php
/**
 * Manual Withdraw Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

// Define form fields
$manual_withdraw_fields = [
    [
        'label' => __('Amount', 'escrowtics'),
        'type' => 'number',
        'name' => 'amount',
        'placeholder' => __('Enter Amount', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'form-group col-md-6 mb-3',
        'required' => true,
    ],
    [
        'label' => __('Specify Other Payment Methods', 'escrowtics'),
        'type' => 'text',
        'name' => 'other_payment',
        'placeholder' => __('Enter Other Payment Methods', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'form-group collapse col-md-12 mb-3',
        'id' => 'escrot-manual-withdraw-other-payment',
        'required' => false,
    ],
];

// Define payment methods
$payment_methods = [
      ''                              => __('-- Select --', 'escrowtics'),
    __('Apple Pay', 'escrowtics')     => __('Apple Pay', 'escrowtics'),
    __('Cash', 'escrowtics')          => __('Cash', 'escrowtics'),
    __('Cash App', 'escrowtics')      => __('Cash App', 'escrowtics'),
    __('Check', 'escrowtics')         => __('Check', 'escrowtics'),
    __('Credit Card', 'escrowtics')   => __('Credit Card', 'escrowtics'),
    __('Google Pay', 'escrowtics')    => __('Google Pay', 'escrowtics'),
    __('Mobile Money', 'escrowtics')  => __('Mobile Money', 'escrowtics'),
    __('Western Union', 'escrowtics') => __('Western Union', 'escrowtics'),
    __('Wired Transfer', 'escrowtics')=> __('Wired Transfer', 'escrowtics'),
    __('Zelle', 'escrowtics')         => __('Zelle', 'escrowtics'),
    __('Other', 'escrowtics')         => __('Other', 'escrowtics'),
];
?>

<div class="escrot-payment-wrap p-4 p-lg-5">
    <div class="d-flex">
        <div class="w-100">
            <h3 class="mb-4"><?= esc_html(__('Manual Withdraw', 'escrowtics')); ?></h3>
            <small><b><?= esc_html(__('Limits Withdraw (100 - 20000) USD', 'escrowtics')); ?></b></small>
        </div>
    </div>

    <!-- Error Message -->
    <div class="text-danger" id="escrot-manual-withdraw-error"></div>

    <form enctype="multi-part/form-data" id="escrot-manual-withdraw-form">
        <input type="hidden" name="action" value="escrot_generate_manual_withdraw_invoice">
        <?php wp_nonce_field('escrot_manual_withdraw_nonce', 'nonce'); ?>

        <!-- Render Form Fields -->
        <div class="row">
            <?php foreach ($manual_withdraw_fields as $field): ?>
                <div class="<?= esc_attr($field['col_class']); ?>" <?= isset($field['id']) ? 'id="' . esc_attr($field['id']) . '"' : ''; ?>>
                    <label class="label" for="<?= esc_attr($field['name']); ?>">
                        <?= esc_html($field['label']); ?>
                    </label>
                    <input 
                        type="<?= esc_attr($field['type']); ?>" 
                        name="<?= esc_attr($field['name']); ?>" 
                        class="<?= esc_attr($field['class']); ?>" 
                        placeholder="<?= esc_attr($field['placeholder']); ?>" 
                        <?= !empty($field['required']) ? 'required' : ''; ?>>
                </div>
            <?php endforeach; ?>

            <!-- Payment Methods Dropdown -->
            <div class="form-group col-md-6">
                <label for="escrot-manual-withdraw-payment-select">
                    <?= esc_html(__('Payment Methods', 'escrowtics')); ?>
                </label>
                <select class="form-control" id="escrot-manual-withdraw-payment-select" name="payment_methods">
                    <?php foreach ($payment_methods as $value => $label): ?>
                        <option value="<?= esc_attr($value); ?>"><?= esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <br>

        <!-- Submit and Action Buttons -->
        <button type="submit" class="btn escrot-btn-primary text-white" id="escrot-manual-pay-btn">
            <?= esc_html(__('Confirm Withdrawal', 'escrowtics')); ?>
        </button>
        <?php if (ESCROT_INTERACTION_MODE === 'modal'): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= esc_html(__('Cancel', 'escrowtics')); ?>
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-manual-withdraw-form-dialog">
                <?= esc_html(__('Close Form', 'escrowtics')); ?>
            </button>
        <?php endif; ?>
    </form>
</div>
