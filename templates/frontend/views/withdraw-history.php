<?php
    $isBackWithdrawPage = false;
	$invoices_count = $user->userFilteredInvoicesCount('User Withdrawal');
	$invoices = $user->userFilteredInvoices('User Withdrawal');
	$before_tbl = '
		<div class="escrot-content">
			<div>
				<center><h3 class="text-dark">'.ESCROT_WITHDRAW_HISTORY_TBL_LABEL.'</h3></center>
			</div>
			<div class="card shadow-lg p-3">
				<div class="table-responsive"> ';
					echo $before_tbl;	
					include ESCROT_PLUGIN_PATH."templates/escrows/invoices-table.php";
		echo '</div></div></div>'; 