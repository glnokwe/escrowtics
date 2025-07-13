<?php
   
$data_count = $earning_count;
$earn_url = $routes['view_escrow'];

$before_tbl = '
	<div class="escrot-content">
		<div><center><h3 class="text-dark">Earning List</center></h3></div>
			<div class="card shadow-lg p-5">
				<div class="table-responsive escrot-user-earnings-tbl" id="escrot-earnings-table-wrapper"> ';
					echo $before_tbl;	
					include ESCROT_PLUGIN_PATH."templates/escrows/earnings-table.php"; 
	echo '</div></div></div>'; 
