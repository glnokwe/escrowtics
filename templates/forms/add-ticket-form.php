<form id="escrot-add-ticket-form" enctype="multipart/form-data">
	<div class="card-body">
		<div style="color: red;" id="escrot-add-ticket-error"></div>
		<div class="row">
			<?php 
				$form_type = "add"; 
				include ESCROT_PLUGIN_PATH."templates/forms/form-fields/ticket-form-fields.php"; 
			?>
		</div>
			<br><br>
			<button type="submit" class="btn escrot-btn-primary" id="escrot-add-ticket-btn">
			<?php echo __("Submit", "escrowtics"); ?></button>
			<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Cancel", "escrowtics"); ?></button> 
			<?php } else { ?>
				<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-add-ticket-form-dialog">
				   <?php echo __("Close Form", "escrowtics"); ?>
				</button> 
			<?php } ?>
	</div>
</form>