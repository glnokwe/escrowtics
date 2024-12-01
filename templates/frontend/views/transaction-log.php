<?php
   
	$log_count = $user->userLogCount();
	$log = $user->userTransactionLog();
	
	$before_tbl = '
		<div class="escrot-content">
			<div><center><h3 class="text-dark">Transaction Log</center></h3></div>
				<div class="card shadow-lg p-3">
				<div class="table-responsive"> ';
					echo $before_tbl;	
					include ESCROT_PLUGIN_PATH."templates/escrows/transaction-log-table.php"; ;
	echo '</div></div></div>'; 