<?php
/**
 * Change Password Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 

// Define form fields
$password_fields = [
    [
        'label' => __('Current Password', 'escrowtics'),
        'type' => 'password',
        'name' => 'old_pass',
        'placeholder' => '••••••',
        'class' => 'form-control',
        'col_class' => 'col',
        'required' => true,
    ],
    [
        'label' => __('New Password', 'escrowtics'),
        'type' => 'password',
        'name' => 'user_pass',
        'placeholder' => '••••••',
        'class' => 'form-control',
        'col_class' => 'col',
        'required' => true,
    ],
    [
        'label' => __('Confirm Password', 'escrowtics'),
        'type' => 'password',
        'name' => 'confirm_pass',
        'placeholder' => '••••••',
        'class' => 'form-control',
        'col_class' => 'col',
        'required' => true,
    ],
];
?>

<div class="p-5 escrot-rounded e-profile">
    <!-- Error Message -->
    <div style="color: red;" id="escrot_user_pass_error"></div>
    <br><br>
    <div class="tab-content pt-3">
        <div class="tab-pane active">
            <form id="EditEscrotUserPassForm" class="form">
                <input type="hidden" name="action" value="escrot_change_user_pass">
                <?php wp_nonce_field('escrot_user_pass_nonce', 'nonce'); ?>

                <!-- Form Title -->
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <div class="mb-2 h3"><b><?= esc_html(__('Change Password', 'escrowtics')); ?></b></div>
                        </div>
                    </div>
                </div>
                <br><br>

                <!-- Render Password Fields -->
                <div class="row">
                    <?php foreach ($password_fields as $field): ?>
                        <div class="<?= esc_attr($field['col_class']); ?>">
                            <div class="form-group">
                                <label><?= esc_html($field['label']); ?></label>
                                <input 
                                    type="<?= esc_attr($field['type']); ?>" 
                                    name="<?= esc_attr($field['name']); ?>" 
                                    placeholder="<?= esc_attr($field['placeholder']); ?>" 
                                    class="<?= esc_attr($field['class']); ?>" 
                                    <?= $field['required'] ? 'required' : ''; ?>>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <br><br>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn text-light escrot-btn-primary escrot-rounded" type="submit">
                            <?= esc_html(__('Save Changes', 'escrowtics')); ?>
                        </button>
                    </div>
                </div>
                <br><br>
            </form>
        </div>
    </div>
</div>
