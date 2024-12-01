<div class="escrot-form-wrap p-5">
	<form enctype="multi-part/form-data" id="escrot-user-signup-form">
		<input type="hidden" name="form_type" value="signup form">
		<input type="hidden" name="user" value="user">
		<input type="hidden" name="action" value="escrot_user_signup">
		<input type="hidden" name="redirect" value="<?php echo esc_url( escrot_current_url() ); ?>">
		<?php wp_nonce_field('escrot_signup_nonce', 'nonce'); ?>
		
		
		<div class="w-100">
			<h2 class="pb-3 text-center"><?php echo ESCROT_SIGNUP_FORM_LABEL; ?></h2>
		</div>
		<div class="w-100" id="escrot_signup_error"></div>
		
		<div class="p-2 row">
			<div class="col-md-6 form-group mb-3">
				<label class="label" for="username"><?php echo __("First Name", "escrowtics"); ?></label>
				<input type="text" class="form-control text-dark" name="firstname" placeholder="<?php echo __('Enter First Name', 'escrowtics'); ?>" />
			</div>
			<div class="col-md-6 form-group mb-3">
				<label class="label" for="password"><?php echo __("Last Name", "escrowtics"); ?></label>
				<input type="text" class="form-control text-dark" name="lastname" placeholder="<?php echo __('Enter Last Name', 'escrowtics'); ?>" />
			</div>
			<div class="col-md-6 form-group mb-3">
				<label class="label" for="password"><?php echo __("Username", "escrowtics"); ?></label>
				<input type="text" class="form-control text-dark" name="username" placeholder="<?php echo __('Enter Username', 'escrowtics'); ?>" />
			</div>
			<div class="col-md-6 form-group mb-3">
				<label class="label" for="username"><?php echo __("Email Address", "escrowtics"); ?></label>
				<input type="text" class="form-control text-dark" name="email" placeholder="<?php echo __('Enter Email', 'escrowtics'); ?>" />
			</div>
		
			<div class="col-md-6 form-group mb-3">
				<label class="label" for="password"><?php echo __("Password", "escrowtics"); ?></label>
				<input type="password" class="form-control text-dark" name="password" placeholder="<?php echo __('Enter Password', 'escrowtics'); ?>" />
			</div>
			<div class="col-md-6 form-group mb-3">
				<label class="label" for="password"><?php echo __("Confirm Password", "escrowtics"); ?></label>
				<input type="password" class="form-control text-dark" name="confirm_password" placeholder="<?php echo __('Enter Password', 'escrowtics'); ?>" />
			</div>
			<div class="p-2 form-group">
				<button type="submit" class="escrot-rounded text-light btn escrot-btn-primary submit">
				<?php echo __("Sign Up", "escrowtics"); ?></button>
			</div>
		</div>
	</form>
</div>