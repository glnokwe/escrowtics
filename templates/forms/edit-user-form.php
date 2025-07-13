<form id="escrot-edit-user-form" enctype="multipart/form-data">
	<div class="card-body">
		<div style="color: red;" id="escrot-edit-user-error"></div>
		<div class="row">
			<?php 
				$form_type = "edit"; 
				include ESCROT_PLUGIN_PATH."templates/forms/form-fields/user-form-fields.php"; 
			?>
		</div>
		<button type="submit" class="btn escrot-btn-primary" name="edit_user" id="escrot-edit-user-btn">
		<?= __("Submit", "escrowtics"); ?></button>
		<?php if(ESCROT_INTERACTION_MODE == "modal"){ ?>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Cancel", "escrowtics"); ?></button> 
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-edit-user-form-dialog">
				<?= __("Close Form", "escrowtics"); ?>
			</button> 
		<?php } ?> 
	</div>
</form>