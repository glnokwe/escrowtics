<form id="UserAddForm" enctype="multipart/form-data">
	<div class="card-body">
		<div style="color: red;" id="escrot-add-user-error"></div>
		<div class="row">
			<?php 
				$form_type = "add"; 
				include ESCROT_PLUGIN_PATH."templates/forms/form-fields/user-form-fields.php"; 
			?>
		</div>
			<br><br>
			<button type="submit" class="btn escrot-btn-primary" name="add_user" id="adduser">
			<?php echo __("Submit", "escrowtics"); ?></button>
			<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Cancel", "escrowtics"); ?></button> 
			<?php } else { ?>
				<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-add-user-form-dialog">
				   <?php echo __("Close Form", "escrowtics"); ?>
				</button> 
			<?php } ?>
	</div>
</form>