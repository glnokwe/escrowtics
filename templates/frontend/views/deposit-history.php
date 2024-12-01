<?php
    $isBackWithdrawPage = false; 
	$invoices_count = $user->userFilteredInvoicesCount('User Deposit');
	$invoices = $user->userFilteredInvoices('User Deposit');
	$before_tbl = '
		<div class="escrot-content">
			<div><center><h3 class="text-dark">'.ESCROT_DEPOSIT_HISTORY_TABLE_LABEL.'</center></h3></div>
				<div class="card shadow-lg p-3">
					<div class="table-responsive"> ';
						echo $before_tbl;	
						include ESCROT_PLUGIN_PATH."templates/escrows/invoices-table.php";
		echo '</div></div></div>'; 