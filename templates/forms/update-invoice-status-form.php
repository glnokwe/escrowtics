<?php
/**
 * Invoice Status Update Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
?>

<form id="escrot-invoice-status-form" enctype="multipart/form-data">
    <div class="card-body">

        <!-- Error Message -->
        <div style="color: red;" id="escrot-invoice-status-error"></div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="code" id="escrot-status-update-code">
        <input type="hidden" name="action" value="escrot_update_invoice_status">
        <?php wp_nonce_field('escrot_invoice_status_nonce', 'nonce'); ?>

        <!-- Status Selection -->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="status"><?= esc_html(__('Invoice Status', 'escrowtics')); ?></label>
                <select 
                    class="form-control" 
                    id="escrot-invoice-status-select" 
                    name="status" 
                    required
                >
                    <option value=""><?= esc_html(__('-- Select --', 'escrowtics')); ?></option>
                    <option value="0"><?= esc_html(__('Pending', 'escrowtics')); ?></option>
                    <option value="2"><?= esc_html(__('Paid', 'escrowtics')); ?></option>
                </select>
            </div>
        </div>

        <br>

        <!-- Action Buttons -->
        <button type="submit" class="btn escrot-btn-primary" id="escrot-invoice-status-btn">
            <?= esc_html(__('Update', 'escrowtics')); ?>
        </button>
        <?php if (ESCROT_INTERACTION_MODE === 'modal'): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= esc_html(__('Cancel', 'escrowtics')); ?>
            </button>
        <?php else: ?>
            <button 
                type="button" 
                class="btn btn-default" 
                data-toggle="collapse" 
                data-target="#escrot-invoice-status-dialog"
            >
                <?= esc_html(__('Close Form', 'escrowtics')); ?>
            </button>
        <?php endif; ?>

    </div>
</form>
