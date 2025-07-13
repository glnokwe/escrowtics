<?php
/**
 * User Signup Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 

// Define form fields
$signup_fields = [
    [
        'label' => __('First Name', 'escrowtics'),
        'type' => 'text',
        'name' => 'first_name',
        'placeholder' => __('Enter First Name', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
    ],
    [
        'label' => __('Last Name', 'escrowtics'),
        'type' => 'text',
        'name' => 'last_name',
        'placeholder' => __('Enter Last Name', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
    ],
    [
        'label' => __('Username', 'escrowtics'),
        'type' => 'text',
        'name' => 'user_login',
        'placeholder' => __('Enter Username', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
    ],
    [
        'label' => __('Email Address', 'escrowtics'),
        'type' => 'text',
        'name' => 'user_email',
        'placeholder' => __('Enter Email', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
    ],
    [
        'label' => __('Password', 'escrowtics'),
        'type' => 'password',
        'name' => 'user_pass',
        'placeholder' => __('Enter Password', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
    ],
    [
        'label' => __('Confirm Password', 'escrowtics'),
        'type' => 'password',
        'name' => 'confirm_pass',
        'placeholder' => __('Enter Password', 'escrowtics'),
        'class' => 'form-control text-dark',
        'col_class' => 'col-md-6',
    ],
];
?>

<div class="escrot-form-wrap p-5">
    <form enctype="multi-part/form-data" id="escrot-user-signup-form">
        <input type="hidden" name="form_type" value="signup form">
        <input type="hidden" name="user" value="user">
        <input type="hidden" name="action" value="escrot_user_signup">
        <input type="hidden" name="redirect" value="<?= esc_url(escrot_current_url()); ?>">
        <?php wp_nonce_field('escrot_signup_nonce', 'nonce'); ?>

        <!-- Form Title -->
        <div class="w-100">
            <h2 class="pb-3 text-center"><?= escrot_option('signup_form_label'); ?></h2>
        </div>
        <div class="w-100" id="escrot_signup_error"></div>

        <!-- Render Form Fields -->
        <div class="p-2 row">
            <?php foreach ($signup_fields as $field): ?>
                <div class="<?= esc_attr($field['col_class']); ?> form-group mb-3">
                    <label class="label"><?= esc_html($field['label']); ?></label>
                    <input type="<?= esc_attr($field['type']); ?>" 
                           name="<?= esc_attr($field['name']); ?>" 
                           placeholder="<?= esc_attr($field['placeholder']); ?>" 
                           class="<?= esc_attr($field['class']); ?>" />
                </div>
            <?php endforeach; ?>

            <!-- Submit Button -->
            <div class="p-2 form-group">
                <button type="submit" class="escrot-rounded text-light btn escrot-btn-primary submit">
                    <?= esc_html(__('Sign Up', 'escrowtics')); ?>
                </button>
				<span class="ml-3 sm">
					<?= __('Already got an account?..', 'escrowtics'); ?>
					<a class="text-primary" href="<?= esc_url(home_url()); ?>">
					<?= __('Login', 'escrowtics'); ?>
					</a>
				</span>
            </div>
        </div>
    </form>
</div>
