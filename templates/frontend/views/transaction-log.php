<?php defined('ABSPATH') || exit; ?>
<div class="escrot-content">
	<h3 class="text-center text-dark">
		<?= _e('Transaction Log', 'escrowtics'); ?>
	</h3>	
	<div class="card shadow-lg p-3">
		<div class="table-responsive"> 
			<?php
				$log_count = $user->getUserTransactionLogCount();
				include ESCROT_PLUGIN_PATH."templates/escrows/transaction-log-table.php"; 
			?>	
		</div>
	</div>
</div>