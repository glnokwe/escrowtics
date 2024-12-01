<?php
   
	$data_count = $user->userTicketCount($username);
	$data = $user->userTickets($username);
	
	$before_tbl = '';
	$before_tbl .= '
		<div class="escrot-content">	
		   <div><center><h3 class="text-dark">User Tickets<a type="button" class="btn btn-sm btn-outline-secondary btn-round float-right"'; 
			   if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") {
					$before_tbl .= 'data-toggle="modal" data-target="#escrot-add-ticket-modal"';
				} else { 
					$before_tbl .=' data-toggle="collapse" data-target="#escrot-add-ticket-form-dialog"'; 
				} 
				$before_tbl .=' 
			><i class="fas fa-plus"></i> '.__("Open New Ticket", "escrowtics").'</a></h3></center></div><br>
				<div class="card shadow-lg p-3">
					<div class="table-responsive escrot-sa-users-tbl" id="escrot-ticket-table-wrapper"> ';
						echo $before_tbl;	
						include ESCROT_PLUGIN_PATH."templates/support/tickets-table.php";
		echo '</div></div></div></div>'; 
