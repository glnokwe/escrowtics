<form id="escrot-ticket-status-form" enctype="multipart/form-data">
	<div class="card-body">
	    <div style="color: red;" id="escrot-ticket-status-error"></div>
		<div class="row">
		    <input type="hidden" name="ticket_id" id="escrot-ticket-id-input">
			<input type="hidden" name="action" value="escrot_update_ticket">
			<?php wp_nonce_field('escrot_ticket_status_nonce', 'nonce'); ?>
			<div class="form-group col-md-12">
				<label for="status">Ticket Status</label>
				<select class="form-control" id="escrot-ticket-status-select" name="status">
					<option value="">-- Select --</option> 
					<option value="0">Open</option>
					<option value="1">Closed</option>
				</select>
			</div>
			<br><br>
		</div>
	    <button type="submit" class="btn escrot-btn-primary" id="escrot-ticket-status-btn">
	    <?php echo __("update", "escrowtics"); ?></button>
	    <?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
		   <button type="button" class="btn btn-default" data-dismiss="modal">
		   <?php echo __("Cancel", "escrowtics"); ?></button>
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-ticket-status-dialog">
			   <?php echo __("Close Form", "escrowtics"); ?>
			</button> 
		<?php } ?>	
	</div> 
</form>