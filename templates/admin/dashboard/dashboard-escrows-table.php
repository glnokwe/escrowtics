<?php 
 /**
 * The Dashboard escrows Table.
 * List 5 recent escrows on the dashboard .
 * 
 * @since      1.0.0
 */ 

$output = "";

$escrows = $this->fetchRecentEscrows();
$rowCnt = $this->getTotalEscrowCount();


if ($rowCnt > 0) { 
  
	$output .='	 
	<div class="table-responsive">

		<table class="escrot-table-numbering table" id="dashTable">
			<thead class="tbl-head">
				<tr>
					<th class="escrot-th">'.__("No.", "escrowtics").'</th>
					<th class="escrot-th">'.__("ID.", "escrowtics").'</th>
					<th class="escrot-th">'.__("Payer", "escrowtics").'</th>
					<th class="escrot-th">'.__("Earner", "escrowtics").'</th>
					<th class="escrot-th">'.__("Created", "escrowtics").'</th>
					<th class="escrot-th text-right"><center>'.__("Action", "escrowtics").'</center></th>
				</tr>
			</thead>
				  
			<tbody>';
					
			foreach ($escrows as $escrow) {

			   $output .="
		 
				<tr>
					<td style='font-weight: bold;'></td>
					<td>#".$escrow['ref_id']."</td>
					<td>".$escrow['payer']."</td>
					<td>".$escrow['earner']."</td>
					<td> <i class='fa fa-calendar-days'></i> ".date('Y-m-d', strtotime($escrow['creation_date']))."</td>
					   
				<td>
				<center>
				
					
					<a href='#' id='escrotDropdownEscrows' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <button class='btn btn-flat escrot-btn-sm escrot-btn-primary'><i class='fas fa-ellipsis-vertical'></i></button></a>
		  
					<div class='dropdown-menu dropdown-menu-right' aria-labelledby='escrotDropdownEscrows'>
					
						<a href='admin.php?page=escrowtics-view-escrow&escrow_id=".$escrow['escrow_id']."' id='".$escrow['escrow_id']."' class='dropdown-item'> 
							<i class='text-info fas fa-eye'></i> &nbsp; ".__('View', 'escrowtics')."
						</a>
					
				  
						<a href='#' id='".$escrow['escrow_id']."' class='dropdown-item escrot-delete-btn' data-action='escrot_del_escrow'>
							<i class='text-danger fas fa-trash'></i> &nbsp; ".__('Delete', 'escrowtics')."
						</a>
					
					</div>
					
				</center>
				</td> ";     
		   
				}							 
		   
				$output .='	 
				</tr>
		  </tbody>
		</table>
	</div>';
	
echo $output;  
	
} else{
	   echo '<h4 class="text-light text-center mt-5">'.__("No records found", "escrowtics").'</h4>';
}