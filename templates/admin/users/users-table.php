<?php 
 /**
 * The Users Table.
 * List all available Users.
 * @since      1.0.0
 * @package    Escrowtics
 */ 
   
$users = $this->displayUsers();
$users_count = $this->totalUserCount();


$output = "";

$swalfire = 'Swal.fire("'.__("No Action Selected!", "escrowtics").'", "'.__("Please select an action to continue!", "escrowtics").'", "warning");';


if ($users_count > 0) {
  
	$output .= "	 

		<select id='escrot-list-actions'>
		  <option value='escrot-option1'>".__('Select action', 'escrowtics')."</option>
		  <option value='escrot-option2'>".__('Delete', 'escrowtics')."</option>
		</select>

		<div id='escrot-option1' style='display: none;' class='escrot-apply-btn'><a type='button' class='btn escrot-tbl-action-btn' onclick='".$swalfire."'><i class='fas fa-success'></i> ".__('Apply', 'escrowtics')."</a></div>

		<div id='escrot-option2' style='display: none;' class='escrot-apply-btn'><a type='button'
		class='btn btn-danger escrot-tbl-action-btn escrot-mult-delete-user-btn'> 
		<i class='fas fa-trash' ></i> ".__('Delete', 'escrowtics')."</a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div>
	
	    <table class='stripe hover order-column table border escrot-data-table' id='escrot-user-table'>
			<thead class='escrot-th'>
					<tr>
						<th data-orderable='false' style='color:#06accd !important;'>
							<input style='border: solid gold !important;' type='checkbox' id='escrot-select-all'>
						</th>
						<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Image', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Username', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Escrows', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Earnings', 'escrowtics')."</th>
						<th class='escrot-th'>".__('Balance', 'escrowtics')."(".ESCROT_CURRENCY.")</th>
						<th class='escrot-th'>".__('Created', 'escrowtics')."</th>
						<th class='escrot-th'>".__('<center>Action</center>', 'escrowtics')."</th>
					</tr>
				</thead>
			<tbody>";
			
		foreach ($users as $user) {
		 
			$output.="
				<tr id='".$user['user_id']."'>   
					<td><input type='checkbox' class='escrot-checkbox' data-escrot-row-id='".$user['user_id']."'></td>
					<td></td>
					<td>".escrot_image($user['user_image'], 40, "rounded")."</td>
					<td>".$user['username']."</td>
					<td><center><strong>".$this->userEscrowsCount($user['username'])."</strong></center></td>
					<td><center><strong>".$this->userEarningsCount($user['username'])."</strong></center></td>
					<td>".$user['balance']."</td>
					<td> <i class='fa fa-calendar-days'></i> ".date('Y-m-d H:i A', strtotime($user['creation_date']))."</td>
					
					<td><center>";
						if(!is_escrot_front_user()) {
							$output.="<a href='admin.php?page=escrowtics-user-profile&user_id=".$user['user_id']."' id='".$user['user_id']."' class='btn btn-behance btn-icon-text escrot-btn-sm' title='".__('View User', 'escrowtics')."'> 
								<i class='fas fa-user'></i> 
							</a>";
						}
						$output.="<a href='#' id='escrotDropdownUser' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <button class='btn btn-flat escrot-btn-sm escrot-btn-primary'><i class='fas fa-ellipsis-vertical'></i></button></a>
			  
						<div class='dropdown-menu dropdown-menu-right' aria-labelledby='escrotDropdownUser'>
					  
							<a href='#' id='".$user['user_id']."' class='dropdown-item escrot-user-edit-btn escrot-rounded'";
								if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){          
								 $output.="data-toggle='modal' data-target='#escrot-edit-user-modal'";
								} else {
								 $output.="data-toggle='collapse' data-target='#escrot-edit-user-form-dialog'";
								} 
								$output.=" ><i class='text-info fas fa-user-pen'></i> &nbsp; ".__('Quick Edit', 'escrowtics')."
							</a>
				
							<a href='#' id='".$user['user_id']."' class='dropdown-item escrot-delete-user-btn escrot-rounded'> <i class='text-danger fas fa-trash'></i> &nbsp; ".__('Delete', 'escrowtics')."
							</a>
					  
						</div>
					
					</a></center>
					</td>
				</tr> ";  
			  
		}
	 
		$output .= "
			</tbody>
			<thead class='escrot-th'>
				<tr>
					<th data-orderable='false'><input type='checkbox' id='escrot-select-all2'></th>
					<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Image', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Username', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Escrows', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Earnings', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Balance', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Created', 'escrowtics')."</th>
					<th class='escrot-th'>".__('<center>Action</center>', 'escrowtics')."</th>
				</tr>
			</thead>
		</table>
        <br>
		<select id='escrot-list-actions2'>
		    <option value='escrot-option1b'>".__('Select action', 'escrowtics')."</option>
		    <option value='escrot-option2b'>".__('Delete', 'escrowtics')."</option>
		</select>

		<div id='escrot-option1b' style='display: none;' class='escrot-apply-btn2'><a type='button' class='btn escrot-tbl-action-btn' 
		onclick='".$swalfire."'><i class='fas fa-check' ></i> ".__('Apply', 'escrowtics')."</a></div>

		<div id='escrot-option2b' style='display: none;' class='escrot-apply-btn2'><a type='button' class='btn btn-danger escrot-tbl-action-btn escrot-mult-delete-user-btn'> ".__('Delete', 'escrowtics')." </a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> ".__('Selected', 'escrowtics')."</span></div> ";
			
	echo $output;  
		
} else{
	echo '<h3 class="text-dark text-center mt-5">'.__("No records found", "escrowtics").'</h3>';
}