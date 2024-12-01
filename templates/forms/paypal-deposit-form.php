
	<div class="escrot-payment-wrap p-4 p-lg-5">
		<div class="d-flex">
			<div class="w-100">
				<h3 class="mb-4">Deposit via Paypal</h3>
				<small><b>Deposit Amount (1 - 20000) USD </b></small>
			</div>
		</div>
		<div class="text-danger" id="escrot-paypal-deposit-error"></div>
		<form enctype="multi-part/form-data" id="escrot-paypal-deposit-form">
		    <input type="hidden" name="action" value="escrot_generate_paypal_deposit_invoice">
			<?php wp_nonce_field('escrot_deposit_invoice_nonce', 'nonce'); ?>
			<div class="row">
			    <div class="col-md-6">
					<div class="form-group mb-3">
						<label class="label" for="amount"><?php echo __("Amount", "escrowtics"); ?></label>
						<input type="number" class="form-control text-dark" name="amount" 
						placeholder="<?php echo __('Enter Amount', 'escrowtics'); ?>" required >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group mb-3">
						<label class="label" for="paypal_email"><?php echo __("Paypal Email", "escrowtics"); ?></label>
						<input type="number" class="form-control text-dark" name="paypal_email" 
						placeholder="<?php echo __('Enter Paypal Email', 'escrowtics'); ?>" required >
					</div>
				</div>
			</div><br>
			
			<button type="submit" class="btn escrot-btn-primary text-white" id="escrot-paypal-pay-btn">
			<?php echo __("Continue to Paypal", "escrowtics"); ?></button>
			<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Cancel", "escrowtics"); ?></button> 
			<?php } else { ?>
				<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-paypal-deposit-form-dialog">
					<?php echo __("Close Form", "escrowtics"); ?>
			</button> 
			<?php } ?>
		</form>
	</div>
				