<form id="escrot-edit-ticket-form" enctype="multipart/form-data">
	<div class="card-body">
		<div style="color: red;" id="escrot-edit-ticket-error"></div>
		<div class="row">
			<?php 
				$form_type = "edit"; 
				include ESCROT_PLUGIN_PATH."templates/forms/form-fields/ticket-form-fields.php"; 
			?>
		</div>
		<button type="submit" class="btn escrot-btn-primary" id="escrot-edit-ticket-btn">
		<?php echo __("Submit", "escrowtics"); ?></button>
		<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Cancel", "escrowtics"); ?></button> 
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-edit-ticket-form-dialog">
				<?php echo __("Close Form", "escrowtics"); ?>
			</button> 
		<?php } ?> 
	</div>
</form>