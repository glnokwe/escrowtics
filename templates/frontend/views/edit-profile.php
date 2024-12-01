<div id="escrot-user-account-form-wrapper">
	<div class="col-xs-12 <?= wp_is_mobile()? 'p-2' : 'p-5';  ?>" id="escrot-tabs">
		<nav>
			<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
				<a class="nav-item nav-link active" data-toggle="tab" href="#escrot-edit-account" 
				role="tab" aria-selected="true">Edit Account</a>
				<a class="nav-item nav-link" data-toggle="tab" href="#escrot-edit-pass" role="tab"  
				aria-selected="false">Password & Security</a>
			</div>
		</nav>
		<div class="tab-content py-3 px-3 px-sm-0">
			<div class="tab-pane fade show active" id="escrot-edit-account" role="tabpanel">
				<?php include ESCROT_PLUGIN_PATH."templates/forms/user-account-form.php"; ?>
			</div>
			<div class="tab-pane fade" id="escrot-edit-pass" role="tabpanel">
				<?php include ESCROT_PLUGIN_PATH."templates/forms/user-password-form.php"; ?>
			</div>
		</div>
	</div>
</div>
