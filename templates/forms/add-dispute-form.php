<form id="escrot-add-dispute-form" enctype="multipart/form-data">
	<div class="card-body">
		<div class="row">
			<?php 
				$form_type = "add"; 
				include ESCROT_PLUGIN_PATH."templates/forms/form-fields/dispute-form-fields.php"; 
			?>
		</div>
			<br><br>
			<button type="submit" class="btn escrot-btn-primary" id="escrot-add-dispute-btn">
			<?= __("Submit", "escrowtics"); ?></button>
			<?php if(ESCROT_INTERACTION_MODE == "modal"){ ?>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Cancel", "escrowtics"); ?></button> 
			<?php } else { ?>
				<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-add-dispute-form-dialog">
				   <?= __("Close Form", "escrowtics"); ?>
				</button> 
			<?php } ?>
	</div>
</form>