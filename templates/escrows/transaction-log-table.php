<?php
/**
* Transaction Log Table.
* List all available escrows.
* 
* @since      1.0.0
*/

$output = "";


if ($log_count > 0) {

	$output .="	
	<table class='table border escrot-data-table stripe hover order-column' id='escrot-log-table'>
		<thead class='escrot-th'>
			<tr>
				<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Transaction ID', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Details', 'escrowtics')."</th>
				<th class='escrot-th escrot-front-only'>".__('Amount', 'escrowtics')."</th>
				<th class='escrot-th escrot-front-only'>".__('Balance', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Date', 'escrowtics')."</th>
			</tr>
		</thead>
		<tbody>";

		foreach ($log as $log) {
		
			$output.=" 
				<tr id='".$log['id']."'>
					<td></td>
					<td>".$log['ref_id']."</td>
					<td>".ucwords($log['details'])."</td>
					<td class='escrot-front-only'>".$log['amount']."</td>
					<td class='escrot-front-only'>".$log['balance']."</td>
					<td> <i class='fa fa-calendar-days'></i> ".date('Y-m-d H:i A', strtotime($log['creation_date']))."</td> 
				</tr>";    
		}

		$output .= "
		</tbody> 
		<thead class='escrot-th'>
			<tr>
				<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Transaction ID', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Details', 'escrowtics')."</th>
				<th class='escrot-front-only escrot-th'>".__('Amount', 'escrowtics')."</th>
				<th class='escrot-th escrot-front-only'>".__('Balance', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Date', 'escrowtics')."</th>
			</tr>
		</thead>
	</table>
	<br>";

	echo $output;  


}else{
	echo '<h3 class="text-dark text-center mt-5">'.__("No records found", "escrowtics").'</h3>';
}