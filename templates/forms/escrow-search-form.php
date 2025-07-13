<form method="post" id="escrot-escrow-search-form">
	<div class="input-group border border-info rounded-pill pl-2 pr-2">
		<input type="hidden" name="action" value="escrot_escrow_search">
		<?php wp_nonce_field('escrot_escrow_search_nonce', 'nonce'); ?>
		<input type="hidden" name="search_phrase" id="escrot-escrow-search-phrase">
		<a class="mt-1 infopop" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="<?= __('Search escrows with phrases from either the payer or earner usernames', 'escrowtics'); ?>" title="" data-original-title="Help here"><?= __("Info", "escrowtics"); ?></a>
		<input id="escrot-escrow-search-input" name="escrow_search" type="search" placeholder="Search escrows here..." aria-describedby="button-addon3" class="form-control bg-none border-0 escrot-search-input" required>
		<div class="input-group-append border-0">
		  <button id="button-addon3" type="submit" class="btn btn-link escrot-text-info">
		  <i class="fa fa-search"></i> &nbsp;<b>|</b> </button>
		  <button type="reset" class="btn btn-link escrot-text-info">
		  <i class="fa fa-shuffle"></i></button>
		</div>
	</div>
</form>