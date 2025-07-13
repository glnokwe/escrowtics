<?php
    $isBackWithdrawPage = false; 
	$data_count = $user->getUserFilteredInvoicesCount('User Deposit');
	$invoice_urls =  ['bitcoin' => $routes['bitcoin_deposit_invoice'], 'paypal' => $routes['paypal_deposit_invoice'], 'manual' => $routes['manual_deposit_invoice'], ];
	$invoice_url = htmlspecialchars(json_encode($invoice_urls), ENT_QUOTES, 'UTF-8');
	$invoice_type = 'deposit';
	
	$before_tbl = '
		<div class="escrot-content">
			<div><center><h3 class="text-dark">'.escrot_option('deposit_history_table_label').'</center></h3></div>
				<div class="card shadow-lg p-3">
					<div class="table-responsive"> ';
						echo $before_tbl;	
						include ESCROT_PLUGIN_PATH."templates/escrows/invoices-table.php";
		echo '</div></div></div>'; 