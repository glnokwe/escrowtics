<?php
    
	$data_count = $user->getUserFilteredInvoicesCount('User Withdrawal');
	$invoice_url =  $routes['bitcoin_withdraw_invoice'];
	$invoice_type = 'withdrawal';
	
	$before_tbl = '
		<div class="escrot-content">
			<div>
				<center><h3 class="text-dark">'.escrot_option('withdraw_history_table_label').'</h3></center>
			</div>
			<div class="card shadow-lg p-3">
				<div class="table-responsive"> ';
					echo $before_tbl;	
					include ESCROT_PLUGIN_PATH."templates/escrows/invoices-table.php";
		echo '</div></div></div>'; 