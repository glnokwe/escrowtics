
<div class="escrot-payment-wrap p-4 p-lg-5">
	<div class="d-flex">
		<div class="w-100">
			<h3 class="mb-4">Manual Withdraw</h3>
			<small><b> Limits Withdraw (100 - 20000) USD </b></small>
		</div>
	</div>
	<div class="text-danger" id="escrot-manual-withdraw-error"></div>
	<form enctype="multi-part/form-data" id="escrot-manual-withdraw-form">
		<input type="hidden" name="action" value="escrot_generate_manual_withdraw_invoice">
		<?php wp_nonce_field('escrot_manual_withdraw_nonce', 'nonce'); ?>
		<div class="row">
			<div class="form-group col-md-6 mb-3">
				<label class="label" for="amount"><?php echo __("Amount", "escrowtics"); ?></label>
				<input type="number" class="form-control text-dark" name="amount" 
				placeholder="<?php echo __('Enter Amount', 'escrowtics'); ?>" required >
			</div>
			<div class="form-group col-md-6">
				<label for="status">Payment Methods</label>
				<select class="form-control" id="escrot-manual-withdraw-payment-select" name="payment_methods">
					<option value="">-- Select --</option>
					<option value="Cash">Apple Pay</option>	
					<option value="Cash">Cash</option>
					<option value="Cash App">Cash App</option>
					<option value="Check">Check</option>
					<option value="Cash">Credit Card</option>
					<option value="Google Pay">Google Pay</option>
					<option value="Mobile Money">Mobile Money</option>
					<option value="Western Union">Western Union</option>
					<option value="Wired Transfer">Wired Transfer</option>
					<option value="Zelle">Zelle</option>
					<option value="Other">Other</option>
				</select>
		    </div>
			<div id="escrot-manual-withdraw-other-payment" class="form-group collapse col-md-12 mb-3">
				<label class="label"><?php echo __("Specify Other Payment Methods", "escrowtics"); ?></label>
				<input type="number" class="form-control text-dark" name="other_payment" 
				placeholder="<?php echo __('Enter Other Payment Methods', 'escrowtics'); ?>" required >
			</div>
		</div><br>
		
		<button type="submit" class="btn escrot-btn-primary text-white" id="escrot-manual-pay-btn">
		<?php echo __("Confirm Withdrwal", "escrowtics"); ?></button>
		<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Cancel", "escrowtics"); ?></button> 
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-manual-withdraw-form-dialog">
				<?php echo __("Close Form", "escrowtics"); ?>
		</button> 
		<?php } ?>
	</form>
</div>
			