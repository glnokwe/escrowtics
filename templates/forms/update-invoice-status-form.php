<form id="escrot-invoice-status-form" enctype="multipart/form-data">
	<div class="card-body">
	    <div style="color: red;" id="escrot-invoice-status-error"></div>
		<div class="row">
		    <input type="hidden" name="code" id="escrot-status-update-code">
			<input type="hidden" name="action" value="escrot_update_invoice_status">
			<?php wp_nonce_field('escrot_invoice_status_nonce', 'nonce'); ?>
			<div class="form-group col-md-12">
				<label for="status">Invoice Status</label>
				<select class="form-control" id="escrot-invoice-status-select" name="status">
					<option value="">-- Select --</option> 
					<option value="0">Pending</option>
					<option value="-1">Unpaid</option>
					<option value="2">Paid</option>
				</select>
			</div>
			<br><br>
		</div>
	    <button type="submit" class="btn escrot-btn-primary" id="escrot-invoice-status-btn">
	    <?php echo __("update", "escrowtics"); ?></button>
	    <?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
		   <button type="button" class="btn btn-default" data-dismiss="modal">
		   <?php echo __("Cancel", "escrowtics"); ?></button>
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-withdrawal-status-dialog">
			   <?php echo __("Close Form", "escrowtics"); ?>
			</button> 
		<?php } ?>	
	</div> 
</form>