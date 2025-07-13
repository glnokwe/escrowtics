<?php 
/**
 * Dispute Status Update Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

// Define form fields
$fields = [
    'status' => [
        'label' => __('Dispute Status', 'escrowtics'),
        'id' => 'escrot-dispute-status-select',
        'name' => 'status',
        'options' => [
            '' => __('-- Select --', 'escrowtics'), // Default empty option
            '0' => __('Open', 'escrowtics'),       // Status options
            '1' => __('Resolved', 'escrowtics')
        ]
    ],
    'priority' => [
        'label' => __('Dispute Priority', 'escrowtics'),
        'id' => 'escrot-dispute-priority-select',
        'name' => 'priority',
        'options' => [
            '' => __('-- Select --', 'escrowtics'), // Default empty option
            'Low' => __('Low', 'escrowtics'),       // Priority levels
            'Medium' => __('Medium', 'escrowtics'),
            'High' => __('High', 'escrowtics')
        ]
    ]
];
?>

<form id="escrot-dispute-status-form" enctype="multipart/form-data">
    <div class="card-body">
        <!-- Error message placeholder -->
        <div style="color: red;" id="escrot-dispute-status-error"></div>
        <div class="row">
            <!-- Hidden inputs for form processing -->
            <input type="hidden" name="dispute_id" id="escrot-dispute-id-input">
            <input type="hidden" name="action" value="escrot_update_dispute">
            <?php wp_nonce_field('escrot_dispute_status_nonce', 'nonce'); ?>

            <?php 
            foreach ($fields as $field) { ?>
                <div class="form-group col-md-6">
                    <label for="<?= $field['name']; ?>">
                        <?= $field['label']; ?>
                    </label>
                    <select class="form-control" id="<?= $field['id']; ?>" name="<?= $field['name']; ?>" required>
                        <?php 
                        // Generate options for each field
                        foreach ($field['options'] as $value => $label) { ?>
                            <option value="<?= $value; ?>"><?= $label; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn escrot-btn-primary" id="escrot-dispute-status-btn">
            <?= esc_html__('Update', 'escrowtics'); ?>
        </button>

        <?php if (ESCROT_INTERACTION_MODE == "modal") { ?>
            <!-- Cancel button for modal interaction mode -->
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <?= esc_html__('Cancel', 'escrowtics'); ?>
            </button>
        <?php } else { ?>
            <!-- Close button for non-modal interaction -->
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-dispute-status-dialog">
                <?= esc_html__('Close Form', 'escrowtics'); ?>
            </button>
        <?php } ?>
    </div>
</form>
