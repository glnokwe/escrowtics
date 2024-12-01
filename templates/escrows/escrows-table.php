<?php
/**
* The escrow Table.
* List all available escrows.
* @since      1.0.0
*/


$swalfire = 'Swal.fire("'.__("No Action Selected!", "escrowtics").'", "'.__("Please select an action to continue!", "escrowtics").'", "warning");';

$output = "";


if ($data_count > 0) {
	if(!is_escrot_front_user()){
		$output .="	 

			<select id='escrot-list-actions'>
			  <option value='escrot-option1'>".__('Select action', 'escrowtics')."</option>
			  <option value='escrot-option2'>".__('Delete', 'escrowtics')."</option>
			</select>

			<div id='escrot-option1' style='display: none;' class='escrot-apply-btn'><a type='button' class='btn escrot-tbl-action-btn' onclick='".$swalfire."'><i class='fas fa-success'></i> ".__('Apply', 'escrowtics')."</a></div>

			<div id='escrot-option2' style='display: none;' class='escrot-apply-btn'><a type='button'
			class='btn btn-danger escrot-tbl-action-btn escrot-mult-delete-btn' data-action='escrot_del_escrows'> 
			<i class='fas fa-trash' ></i> ".__('Delete', 'escrowtics')."</a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div>";
	}
	$output .="
		<table class='table border escrot-data-table stripe hover order-column' id='escrot-escrow-table' data-escrow-url='".(is_escrot_front_user()? $routes['view_transaction'] : '')."'>
			<thead class='escrot-data-tbl-header'>
				<tr>";
					if(!is_escrot_front_user()){
						$output .= "
						<th data-orderable='false'>
							<input style='border: solid gold !important;' type='checkbox' id='escrot-select-all'>
						</th>";
					}
					$output .= "
					<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
					<th class='escrot_so_payer escrot-th'>".__('Payer', 'escrowtics')."</th>
					<th class='escrot_so_earner escrot-th'>".__('Earner', 'escrowtics')."</th>
					<th class='escrot_so_created escrot-th'>".__('Created Date', 'escrowtics')."</th>
					<th class='escrot-th'><center>".__('Action', 'escrowtics')."</center></th>
				</tr>
			</thead>
			<tbody>";

			foreach ($data as $data) {
			
				$output.=" 
					<tr id='".$data['escrow_id']."'> ";
						if(!is_escrot_front_user()){
								$output .= " 
								<td>
									<input type='checkbox' class='escrot-checkbox' data-escrot-row-id='".$data['escrow_id']."'>
								</td>";
							}
						$output .= " 	
						<td></td>
						<td class='escrot_so_payer'>". $data['payer']."</td>
						<td class='escrot_so_earner'>". $data['earner']."</td>
						<td class='escrot_so_created'> <i class='fa fa-calendar-days'></i> ".date('Y-m-d H:i A', strtotime($data['creation_date']))."</td>
						<td>
							<center>";
								if(is_escrot_front_user()){
									//use ajax posted url when reloading table
									$url = isset($_POST['escrow_url'])? $_POST['escrow_url'] : $routes['view_transaction'];
									$output.="
										<a href='".add_query_arg(['escrow_id' => $data['escrow_id']], $url)."'  class='btn btn-behance btn-icon-text escrot-btn-sm'> 
											<i class='fas fa-eye'></i> &nbsp;".__('View Transaction', 'escrowtics')."
										</a>";
								} else {
									$output.="
										<a href='admin.php?page=escrowtics-view-escrow&escrow_id=".$data['escrow_id']."' class='btn btn-behance btn-icon-text escrot-btn-sm'> 
											<i class='fas fa-eye'></i> &nbsp;".__('View Transaction', 'escrowtics')."
										</a>
										<a href='#' id='".$data['escrow_id']."' class='btn btn-danger btn-icon-text escrot-btn-sm escrot-delete-btn' data-action='escrot_del_escrow'> 
											<i class='fas fa-trash'></i> &nbsp;".__('Delete', 'escrowtics')."
										</a>";	
								}
							$output.="	
							</center>
						</td> 
					</tr>";    
			}

			$output .= "
			</tbody>
			<thead class='escrot-th'>
				<tr>";
					if(!is_escrot_front_user()){
						$output .= "
						<th data-orderable='false'>
							<input style='border: solid gold !important;' type='checkbox' id='escrot-select-all2'>
						</th>";
					}
					$output .= "
					<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
					<th class='escrot_so_tracking_code escrot-th'>".__('Payer', 'escrowtics')."</th>
					<th class='escrot_so_receiver_name escrot-th'>".__('Earner', 'escrowtics')."</th>
					<th class='escrot_so_created escrot-th'>".__('Created Date', 'escrowtics')."</th>
					<th class='escrot-th'><center>".__('Action', 'escrowtics')."</center></th>
				</tr>
			</thead>
		</table>
		<br>";
		if(!is_escrot_front_user()){
			$output .="	 
				<select id='escrot-list-actions2'>
				  <option value='escrot-option1b'>".__('Select action', 'escrowtics')."</option>
				  <option value='escrot-option2b'>".__('Delete', 'escrowtics')."</option>
				</select>

				<div id='escrot-option1b' style='display: none;' class='escrot-apply-btn2'><a type='button' class='btn escrot-tbl-action-btn' 
				onclick='".$swalfire."'><i class='fas fa-check' ></i> ".__('Apply', 'escrowtics')."</a></div>

				<div id='escrot-option2b' style='display: none;' class='escrot-apply-btn2'><a type='button' class='btn btn-danger escrot-tbl-action-btn escrot-mult-delete-btn' data-action='escrot_del_escrows'> ".__('Delete', 'escrowtics')." </a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div> ";
		}

    echo $output; 

}else{
	echo '<h3 class="text-dark text-center mt-5">'.__("No records found", "escrowtics").'</h3>';
}