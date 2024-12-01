<?php
/**
* Tickets Table.
* List all available support tickets.
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
			class='btn btn-danger escrot-tbl-action-btn escrot-ticket-mult-delete-btn'> 
			<i class='fas fa-trash' ></i> ".__('Delete', 'escrowtics')."</a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div>";
	}
	$output .="
		<table class='table border escrot-data-table stripe hover order-column' id='escrot-ticket-table' data-ticket-url='".$routes['view_ticket']."'>
			<thead class='escrot-data-tbl-header'>
				<tr>";
					if(!is_escrot_front_user()){
						$output .= "
						<th data-orderable='false'>
							<input style='border: solid gold !important;' type='checkbox' id='escrot-select-all'>
						</th>";
					}
					$output .= "
						<th class='escrot-th'>".__('No', 'escrowtics')."</th>
						<th class='escrot-th escrot-back-only'>".__('Ref#/User', 'escrowtics')."</th>
						<th class='escrot-th escrot-front-only'>".__('Ref#', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Department', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Ticket Subject', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Status', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Priority', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Last Updated', 'escrowtics')."</th>
						<th class='escrot-th'>".__('<center>Action', 'escrowtics')."</center></th>
				</tr>
			</thead>
			<tbody>";

			foreach ($data as $data) {
				
				$toggle = ESCROT_PLUGIN_INTERACTION_MODE == "modal"? 'modal' : 'collapse';
				$target = ESCROT_PLUGIN_INTERACTION_MODE == "modal"? 'escrot-ticket-status-modal' : 'escrot-ticket-status-dialog';
				
			    if($data['status'] == 0){
                    $status = "Open";  					
					if($data['priority'] == "High") { $bg = 'danger';}
					elseif($data['priority'] == "Medium") { $bg = 'warning'; }
					elseif($data['priority'] == "Low") { $bg = 'success'; }
				} else {
					$bg = 'gray';
					$status = "Closed"; 
				}
			
				$output.=" 
					<tr id='".$data['ticket_id']."'> ";
						if(!is_escrot_front_user()){
							$output .= " 
							<td>
								<input type='checkbox' class='escrot-checkbox' data-escrot-row-id='".$data['ticket_id']."'>
							</td>";
						}
						$output .= " 
						<td></td>
						<td class='escrot-back-only'>#".$data['ref_id']." <br> ".$data['user']."</td>
						<td class='escrot-front-only'>#".$data['ref_id']." 
						<td>".$data['department']."</td>
						<td>".$data['subject']."</td>
						<td>".$status."
							<a href='#' class='text-success escrot-update-ticket-status' title='Edit Status' id='".$data['ticket_id']."' data-toggle='".$toggle."' data-target='#".$target."'><i class='fas fa-pen'></i>
							</a>
						</td>
						<td class='text-light bg-".$bg."'>".$data['priority']."</td>
						<td>".$data['last_updated']."</td>
						<td>
							<center>";
								if(is_escrot_front_user()){
									//use ajax posted url when reloading table
									$url = isset($_POST['ticket_url'])? $_POST['ticket_url'] : $routes['view_ticket'];
									$output.="
										<a href='".add_query_arg(['ticket_id' => $data['ticket_id']], $url)."'  class='btn btn-behance btn-icon-text escrot-btn-sm'> 
											<i class='fas fa-eye'></i> &nbsp;".__('View Ticket', 'escrowtics')."
										</a>";
								} else {
									$output.="
										<a href='admin.php?page=escrowtics-view-ticket&ticket_id=".$data['ticket_id']."' class='btn btn-behance btn-icon-text escrot-btn-sm'> 
											<i class='fas fa-eye'></i> &nbsp;".__('View Ticket', 'escrowtics')."
										</a>
										<a href='#' id='".$data['ticket_id']."' class='btn btn-danger btn-icon-text escrot-btn-sm escrot-delete-ticket-btn'> 
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
						<th class='escrot-th'>".__('No', 'escrowtics')."</th>
						<th class='escrot-th escrot-back-only'>".__('Ref#/User', 'escrowtics')."</th>
						<th class='escrot-th escrot-front-only'>".__('Ref#', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Department', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Ticket Subject', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Status', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Priority', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Last Updated', 'escrowtics')."</th>
						<th class='escrot-th'>".__('<center>Action', 'escrowtics')."</center></th>
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

				<div id='escrot-option2b' style='display: none;' class='escrot-apply-btn2'><a type='button' class='btn btn-danger escrot-tbl-action-btn escrot-ticket-mult-delete-btn'><i class='fas fa-trash' ></i> ".__('Delete', 'escrowtics')." </a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div> ";
		}

echo $output; 

}else{
	echo '<h3 class="text-dark text-center mt-5">'.__("No records found", "escrowtics").'</h3>';
}