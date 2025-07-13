<form id="escrot-milestone-form" enctype = "multi-part/form-data">
    <input type="hidden" name="action" value="escrot_create_milestone">
	<input type="hidden" name="escrow_id" 
	value="<?= ( isset($_GET["earn_id"])? $_GET["earn_id"] : (isset($_GET["escrow_id"])? $_GET["escrow_id"] : '') ); ?>">
    <?php wp_nonce_field('escrot_milestone_nonce', 'nonce'); ?>
	<div id="escrot-milestone-error" class="text-danger"></div>	
	<div class="card-body p-5">
		<div class="row">
			<div class="col-md-12"><label><h3 class="text-dark"><?= __("Transaction Details", "escrowtics"); ?></h3></label></div>
			<?php 
				$form_type = "add";
				include ESCROT_PLUGIN_PATH."templates/forms/form-fields/escrow-form-fields/escrow-meta-form-fields.php"; 
			?>
		</div><br>
		<button type="submit" class="btn escrot-btn-primary" id="escrot-milestone-btn"><?= __("Add Escrow Milestone", "escrowtics"); ?></button>
		<?php if(ESCROT_INTERACTION_MODE == "modal"){ ?>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Cancel", "escrowtics"); ?></button> 
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-milestone-form-dialog">
				<?= __("Close Form", "escrowtics"); ?>
			</button> 
			<?php } ?>
	</div>
</form>
	