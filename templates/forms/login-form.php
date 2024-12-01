<div class="escrot-form-wrap d-md-flex escrot-rounded-right">
	<div class="escrot-text-wrap escrot-rounded-left p-4 p-lg-5 text-center d-flex align-items-center escrow-md-last">
		<div class="text w-100">
			<h2><?php echo __("Not Registered?", "escrowtics"); ?></h2>
			<p class="text-light"><?php echo __("Signup for an Escrow Account Rightaway!", "escrowtics"); ?></p>
			<a href="<?php echo esc_url( add_query_arg(['endpoint' => 'user_signup'], escrot_current_url() ) ); ?>" 
			class="btn btn-white btn-round btn-outline-white"><?php echo __("User Sign Up", "escrowtics"); ?></a>
		</div>
	</div>
	<div class="escrot-login-wrap escrot-rounded-right p-4 p-lg-5">
		<div class="d-flex">
			<div class="w-100">
				<h3 class="mb-4"><?php echo ESCROT_LOGIN_FORM_LABEL; ?></h3>
			</div>
		</div>
		<form enctype="multi-part/form-data" id="escrot-user-login-form">
			<input type="hidden" name="action" value="escrot_user_login">
			<input type="hidden" name="redirect" value="<?php echo esc_url( escrot_current_url() ); ?>">
			<?php wp_nonce_field('escrot_sa_login_nonce', 'nonce'); ?>
			<div id="escrot_user_login_error"></div>
			<div class="form-group mb-3">
				<label class="label" for="username"><?php echo __("Username", "escrowtics"); ?></label>
				<input type="text" class="form-control text-dark" name="username" 
				placeholder="<?php echo __('Username', 'escrowtics'); ?>"  />
			</div>
			<div class="form-group mb-3">
				<label class="label" for="password"><?php echo __("Password", "escrowtics"); ?></label>
				<input type="password" class="form-control text-dark" name="password" 
				placeholder="<?php echo __('Password', 'escrowtics'); ?>" />
			</div>
			<div class="form-group">
				<button type="submit" class="w-100 escrot-rounded text-light btn escrot-btn-primary submit px-3">
				<?php echo __("Sign In", "escrowtics"); ?></button>
			</div>
			<div class="form-group d-md-flex">
				<div class="w-50 text-left">
					<label class="escrot-checkbox-wrap checkbox-primary mb-0">
						<?php echo __("Remember Me", "escrowtics"); ?>
						<input type="checkbox" name="remember"/>
						<span class="escrot-checkbox-checkmark"></span>
					</label>
				</div>
				<div class="w-50 text-md-right">
					<a class="text-danger" href="<?= esc_url(home_url()).'/wp-login.php?action=lostpassword'; ?>"><?php echo __("Forgot Password", "escrowtics"); ?></a>
				</div>
			</div>
		</form>
	</div>
</div>					