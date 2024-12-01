<?php
	
	if(!isset($_GET['ticket_id'])){ exit(); }
	$ticket_id = wp_unslash($_GET["ticket_id"]);;
	$data = $user->getTicketByID($ticket_id);
	$ticket_meta = $user->getTicketMetaByID($ticket_id);
	$status = $data['status'] == 0? "Open" : "Closed";
	
	$output = ''; 
	
	$before_tbl = '
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<div class="d-none d-md-block p-2" style="text-align:center;">
				<b> 
					<span class="escrot-tbl-header">
						<b>'. __("Ticket", "escrowtics").' #: </b> 
						<span class="text-secondary">'.$data["ref_id"].'</span> &nbsp; || &nbsp;
						<b>'.__("Department", "escrowtics").': </b> 
						<span class="text-secondary">'.$data["department"].'</span> &nbsp; || &nbsp;
						<b>'.__("Subject", "escrowtics").': </b> 
						<span class="text-secondary">'.$data["subject"].'</span> &nbsp; || &nbsp;
						<b>'.__("Priority", "escrowtics").': </b> 
						<span class="text-secondary">'.$data["priority"].'</span> &nbsp;|| &nbsp;
						<b>'.__("Status", "escrowtics").': </b> 
						<span class="text-secondary">'.$status.'</span> 
					</span>
				</b>
			</div>
		</div>';
	echo $before_tbl;	
	include ESCROT_PLUGIN_PATH."templates/support/ticket-chat.php";
	
