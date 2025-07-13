<?php
/**
 * User Login Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 

// Define form fields
$login_fields = [
    [
        'label' => __('Username', 'escrowtics'),
        'type' => 'text',
        'name' => 'user_login',
        'placeholder' => __('Username', 'escrowtics'),
        'class' => 'form-control text-dark',
		'icon' => '<i class="fa-solid fa-user"></i>'
    ],
    [
        'label' => __('Password', 'escrowtics'),
        'type' => 'password',
        'name' => 'user_pass',
        'placeholder' => __('Password', 'escrowtics'),
        'class' => 'form-control text-dark',
		'icon' => '<i class="fa-solid fa-unlock-keyhole"></i>'
    ],
];
?>

<div class="escrot-form-wrap d-md-flex rounded bg-transparent">
    <!-- Left Section -->
    <div class="escrot-text-wrap escrot-rounded-left text-center d-flex align-items-center shelter-md-last">
        <div class="text w-100">
            <h2><?= esc_html(__('Not Registered?', 'escrowtics')); ?></h2>
            <p class="text-light"><?= esc_html(__('Signup for an Escrow Account Rightaway!', 'escrowtics')); ?></p>
            <a href="<?= esc_url(add_query_arg(['endpoint' => 'user_signup'], escrot_current_url())); ?>" 
               class="btn btn-white btn-round btn-outline-white">
               <?= esc_html(__('User Sign Up', 'escrowtics')); ?>
            </a>
        </div>
    </div>
    
    <!-- Login Form Section -->
    <div class="escrot-login-wrap escrot-rounded-right p-3 pr-5 pl-5">
        <div class="d-flex">
            <div class="w-100">
                <h3 class="text-dark mb-4"><?= esc_html(escrot_option('login_form_label')); ?></h3>
            </div>
        </div>
        <form enctype="multi-part/form-data" id="escrot-user-login-form">
            <input type="hidden" name="action" value="escrot_user_login">
            <input type="hidden" name="redirect" value="<?= esc_url(escrot_current_url()); ?>">
            <?php wp_nonce_field('escrot_user_login_nonce', 'nonce'); ?>
            <div id="escrot_user_login_error"></div>
            
            <!-- Render Login Fields -->
            <?php foreach ($login_fields as $field): ?>
                <div class="form-group mb-3">
				    
                    <label class="label">
						<?= esc_html($field['label']); ?>
					</label> &nbsp;<?= $field['icon']; ?>
                    <input type="<?= esc_attr($field['type']); ?>" 
                           name="<?= esc_attr($field['name']); ?>" 
                           placeholder="<?= esc_attr($field['placeholder']); ?>" 
                           class="<?= esc_attr($field['class']); ?>" />
                </div>
            <?php endforeach; ?>
            
            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="w-100 escrot-rounded text-light btn escrot-btn-primary submit px-3">
                    <?= esc_html(__('Sign In', 'escrowtics')); ?>
                </button>
            </div>
            
            <!-- Additional Options -->
            <div class="form-group d-md-flex">
                <div class="w-50 text-left">
                    <label class="escrot-text-sm escrot-checkbox-wrap checkbox-primary mb-0">
                        <?= esc_html(__('Remember Me', 'escrowtics')); ?>
                        <input type="checkbox" name="remember" />
                        <span class="escrot-checkbox-checkmark"></span>
                    </label>
                </div>
                <div class="w-50 text-md-right">
                    <a class="escrot-text-sm text-primary" href="<?= add_query_arg(['endpoint' => 'send_password_reset_link'], home_url()); ?>">
                        <?= esc_html(__('Forgot Password', 'escrowtics')); ?>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
