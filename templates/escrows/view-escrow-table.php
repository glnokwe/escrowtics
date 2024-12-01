<?php
/**
* Escrow Milestone Table.
* List escrow history for 2 unique users.
* 
* @since      1.0.0
*/

		
$swalfire = 'Swal.fire("'.__("No Action Selected!", "escrowtics").'", "'.__("Please select an action to continue!", "escrowtics").'", "warning");';

$output = "";


if ($escrow_meta_count > 0) {

   if(!is_escrot_front_user()){
		$output .="		 

			<select id='escrot-list-actions'>
				<option value='escrot-option1'>".__('Select action', 'escrowtics')."</option>
				<option value='escrot-option2'>".__('Delete', 'escrowtics')."</option>
			</select>

			<div id='escrot-option1' style='display: none;' class='escrot-apply-btn'><a type='button' class='btn escrot-tbl-action-btn' onclick='".$swalfire."'><i class='fas fa-success'></i> ".__('Apply', 'escrowtics')."</a></div>

			<div id='escrot-option2' style='display: none;' class='escrot-apply-btn'><a type='button'  
			class='btn btn-danger escrot-tbl-action-btn escrot-mult-delete-btn' data-action='escrot_del_escrow_metas'> 
			<i class='fas fa-trash' ></i> ".__('Delete', 'escrowtics')."</a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div>";
   }		
   $output .="	
		<table class='table border escrot-data-table' id='escrot-escrow-meta-table' data-escrow-id='".$escrow_id."'>
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
					<th class='escrot_so_amount escrot-th'>".__('Amount', 'escrowtics')."</th>
					<th class='escrot_so_title escrot-th'>".__('Title', 'escrowtics')."</th>
					<th class='escrot_so_created escrot-th'>".__('Date Created', 'escrowtics')."</th>
					<th class='escrot_so_status escrot-th'>".__('Status', 'escrowtics')."</th>
					<th class='escrot-th'><center>".__('Action', 'escrowtics')."</center></th>
				</tr>
			</thead>
			<tbody>";

			foreach ($meta_data as $data) {
				
				$st = $data['status'];
				$status = ( $st == "Pending"? 'warning' : ($st == "Paid"? 'success' : 'danger' ) );
			
				$output.=" 
					<tr id='".$data['meta_id']."'>";
						if(!is_escrot_front_user()){
								$output .= " 
								<td>
									<input type='checkbox' class='escrot-checkbox' data-escrot-row-id='".$data['meta_id']."'>
								</td>";
							}
						$output .= "
						<td></td>
						<td class='escrot_so_amount'>". $data['amount']."</td>
						<td class='escrot_so_title'>". $data['title']."</td>
						
						<td class='escrot_so_created'> <i class='fa fa-calendar-days'></i> ".date('Y-m-d H:i A', strtotime($data['creation_date']))."</td>
						<td class='escrot_so_status'><button class='btn escrot-btn-sm btn-".$status."'>". $data['status']."</button></td>
						<td>
							<center>";
								if ($st == "Pending" ) {
									$output.="
										<a href='#' id='escrotDropdownOrders' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <button class='btn btn-flat escrot-btn-sm escrot-btn-primary'><i class='fas fa-ellipsis-vertical'></i></button></a>
								  
										<div class='dropdown-menu dropdown-menu-right' aria-labelledby='escrotDropdownOrders'>
							
									
											<a href='#' id='".$data['meta_id']."' class='dropdown-item escrot-rounded escrot-view-milestone-detail'"; 
												if(ESCROT_PLUGIN_INTERACTION_MODE !== "modal"){ 
												   $output.="data-toggle='collapse' data-target='#escrot-view-milestone-dialog'";
												} 
												$output.="><i class='text-info fas fa-eye'></i> &nbsp; ".__('View Details', 'escrowtics')."
											</a>";
											if(isset($_GET["escrow_id"]) || isset($_POST["escrow_id"]) || !is_escrot_front_user() ){
												$output.="
													<a href='#' title='Release Payment' id='".$data['meta_id']."' class='dropdown-item escrot-rounded escrot-release-pay'>
														<i class='text-success fas fa-coins'></i> &nbsp; ".__('Release Payment', 'escrowtics')."
													</a>";
											}
											if(isset($_GET["earn_id"]) || isset($_POST["earn_id"]) || !is_escrot_front_user()){
												$output.="
													<a href='#' title='Reject Amount' id='".$data['meta_id']."' class='dropdown-item escrot-rounded escrot-reject-amount'>
														<i class='text-danger fas fa-coins'></i> &nbsp; ".__('Reject Amount', 'glogistics')."
													</a>";
											}			
											if(is_escrot_front_user()){
											$output.="
												<a href='#' title='Admin Help' id='".$data['escrow_id']."' class='dropdown-item escrot-rounded escrot_admin_help'";
												if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") {
													$output .= 'data-toggle="modal" data-target="#escrot-add-ticket-modal"';
												} else { 
													$output .=' data-toggle="collapse" data-target="#escrot-add-ticket-form-dialog"';
												} 
												$output.=">
													<i class='text-info fas fa-question'></i> &nbsp; ".__('Admin Help', 'glogistics')."
												</a>";
											}
											if(!is_escrot_front_user()){
												$output.="	
													<a href='#' id='".$data['meta_id']."' class='dropdown-item escrot-rounded escrot-delete-btn' data-action='escrot_del_escrow_meta'>
														<i class='text-danger fas fa-trash'></i> &nbsp; ".__('Delete', 'glogistics')."
													</a>";
											}
										$output.="
										</div>";	
								} else {$output.="-";}
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
				<th class='escrot_so_amount escrot-th'>".__('Amount', 'escrowtics')."</th>
				<th class='escrot_so_title escrot-th'>".__('Title', 'escrowtics')."</th>
				<th class='escrot_so_created escrot-th'>".__('Date Created', 'escrowtics')."</th>
				<th class='escrot_so_status escrot-th'>".__('Status', 'escrowtics')."</th>
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

			<div id='escrot-option2b' style='display: none;' class='escrot-apply-btn2'><a type='button' class='btn btn-danger escrot-tbl-action-btn  escrot-mult-delete-btn' data-action='escrot_del_escrow_metas'> ".__('Delete', 'escrowtics')." </a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div> ";
	}		

echo $output;  

}else{
   echo '<h3 class="text-dark text-center mt-5">'.__("No transaction record found", "escrowtics").'</h3>';
}