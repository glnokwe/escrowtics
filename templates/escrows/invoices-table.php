<?php
/**
* Payment Invoices Table.
* List all available invoices.
* 
* @since      1.0.0
*/

$output = "";

if ($invoices_count > 0) {

	$output .="	
	<table class='table border escrot-data-table stripe hover order-column' id='escrot-invoices-table'>
		<thead class='escrot-th'>
			<tr>
				<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Invoice ID', 'escrowtics')."</th>
				<th class='escrot-th escrot-back-only'>".__('User', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Address', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Amount', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Status', 'escrowtics')."</th>	
				<th class='escrot-th escrot-back-only'>".__('User IP', 'escrowtics')."</th>	
				<th class='escrot_so_created escrot-th'>".__('Date', 'escrowtics')."</th>
				<th class='escrot-th'><center>".__('Action', 'escrowtics')."</center></th>
				</tr>
		</thead>
		<tbody>";

		foreach ($invoices as $invoice) {
			$status = $invoice['status'];
			if($status == 0){
				$status = "<span class='text-warning'>PENDING</span>";
			}else if($status == 1){
				$status = "<span class='text-warning'>PENDING</span>";
			}else if($status == 2){
				$status = "<span class='text-success'>PAID</span>";
			}else if($status == -1){
				$status = "<span class='text-danger'>UNPAID</span>";
			}else if($status == -2){
				$status = "<span class='text-danger'>Too little paid, please pay the rest.</span>";
			}else {
				$status = "<span class='text-danger'>Error, expired</span>";
			}
		
			$output.=" 
				<tr id='".$invoice['id']."'>
					<td></td>
					<td class='escrot-td'>".$invoice['code']."</td>
					<td class='escrot-td escrot-back-only'>".escrot_get_user_data($invoice['user_id'])['username']."</td>
					<td class='escrot-td'>".$invoice['address']."</td>
					<td class='escrot-td'>".$invoice['amount']."</td>
					<td class='escrot-td'>".$status."</td>
					<td class='escrot-td escrot-back-only'>".$invoice['ip']."</td>
					<td class='escrot-td'> <i class='fa fa-calendar-days'></i> ".date('Y-m-d H:i A', strtotime($invoice['creation_date']))."</td>
					<td>
						<center>";
					if(!is_escrot_front_user() && $isBackWithdrawPage){
						$output.=" ";
							if($invoice['status'] == 2) { $output.="-"; } else {
								$output.="
								<a href='#' id='escrot-dropdown-invoices' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <button class='btn btn-flat escrot-btn-sm escrot-btn-primary'><i class='fas fa-ellipsis-vertical'></i></button></a>
							  
								<div class='dropdown-menu dropdown-menu-right' aria-labelledby='escrot-dropdown-invoices'>
									<a href='#' id='".$invoice['code']."' class='dropdown-item escrot-rounded escrot-update-invoice-btn'"; 
										if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ 
										   $output.="data-toggle='modal' data-target='#escrot-withdrawal-status-modal'";
										} else {
											$output.="data-toggle='collapse' data-target='#escrot-withdrawal-status-dialog'";
										}
										$output.="><i class='text-info fas fa-eye'></i> &nbsp; ".__('Update Status', 'escrowtics')."
									</a>
								</div>";
							}
					} elseif(is_escrot_front_user()) {
						$invoice_url = $invoice['product'] == "User Deposit"? $routes['bitcoin_deposit_invoice'] : $routes['bitcoin_withdraw_invoice'];
						$invoice_url = add_query_arg(['code' => $invoice['code']],  $invoice_url );
						$output.="
							<a title='View Payment Invoice' href='".$invoice_url."' class='btn btn-behance btn-icon-text escrot-btn-sm'> <i class='fa-solid fa-file-invoice'></i> &nbsp;".__('invoice', 'escrowtics')."
							</a>";
					} else {
						$output.="-"; 
					}
					$output.=" 
						</center>
					</td>
				</tr>";    
		}

		$output .= "
		</tbody> 
		<thead class='escrot-th'>
			<tr>
				<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Invoice ID', 'escrowtics')."</th>
				<th class='escrot-th escrot-back-only'>".__('User', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Address', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Amount', 'escrowtics')."</th>
				<th class='escrot-th'>".__('Status', 'escrowtics')."</th>	
				<th class='escrot-th escrot-back-only'>".__('User IP', 'escrowtics')."</th>	
				<th class='escrot-th'>".__('Date', 'escrowtics')."</th>
				<th class='escrot-th'><center>".__('Action', 'escrowtics')."</center></th>
			</tr>
		</thead>
		
	</table>
	<br>";

echo $output;  

}else{
    echo '<h3 class="text-dark text-center mt-5">'.__("No records found", "escrowtics").'</h3>';
}