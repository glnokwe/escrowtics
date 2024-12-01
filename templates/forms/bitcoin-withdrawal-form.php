<?php $invoice_url = explode("?", esc_url(escrot_current_url()))[0]; ?>
	<div class="escrot-payment-wrap p-4 p-lg-5">
		<div class="d-flex">
			<div class="w-100">
				<h3 class="mb-4">Withdraw via BitCoin</h3>
				<small><b>WITHDRAW AMOUNT (minimun: $100)</small>
			</div>
		</div>
		<div style="color: red;" id="escrot-bitcoin-withdraw-error"></div>
		<form enctype="multi-part/form-data" id="escrot-bitcoin-withdraw-form" data-invoice-url="<?php echo $invoice_url; ?>" >
		    <input type="hidden" name="action" value="escrot_generate_bitcoin_withdrawal_invoice">
			<?php wp_nonce_field('escrot_withdraw_invoice_nonce', 'nonce'); ?>
			
			<div class="row">
				<div class="form-group col-md-6 mb-3">
					<label class="label" for="amount"><?php echo __("Amount", "escrowtics"); ?></label>
					<input type="number" class="form-control text-dark" name="amount" 
					placeholder="<?php echo __('Enter Amount', 'escrowtics'); ?>" required >
				</div>
				<div class="form-group col-md-6 mb-3">
					<label class="label" for="wallet"><?php echo __("Bitcoin Wallet Address", "escrowtics"); ?></label>
					<input type="text" class="form-control text-dark" name="wallet" 
					placeholder="<?php echo __('Enter Bitcoin Wallet Address', 'escrowtics'); ?>" required >
				</div><br>
			</div>	
			
			<button type="submit" class="btn escrot-btn-primary text-white" id="escrot-bitcoin-pay-btn">
			<?php echo __("Confirm Withdrawal", "escrowtics"); ?></button>
			<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Cancel", "escrowtics"); ?></button> 
			<?php } else { ?>
				<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-bitcoin-withdraw-form-dialog">
					<?php echo __("Close Form", "escrowtics"); ?>
			</button> 
			<?php } ?>
		</form>
	</div>
				