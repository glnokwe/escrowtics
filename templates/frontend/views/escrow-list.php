<?php
   
	$data_count = $escrow_count;
	$data = $user->userEscrows($username);
	
	$before_tbl = '';
	$before_tbl .= ' 
		<div class="escrot-content">	
			<div><center><h3 class="text-dark">'.ESCROT_ESCROW_TABLE_LABEL.'<a type="button" class="btn btn-sm btn-outline-secondary btn-round float-right"'; 
			   if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") {
					$before_tbl .= 'data-toggle="modal" data-target="#escrot-add-escrow-modal"';
				} else { 
					$before_tbl .=' data-toggle="collapse" data-target="#escrot-add-escrow-form-dialog"'; 
				} 
				$before_tbl .=' 
					><i class="fas fa-plus"></i> '.__("Add Escrow", "escrowtics").'</a></h3></center></div><br>
					<div class="card shadow-lg p-3">
					<div class="table-responsive" id="escrot-escrow-table-wrapper"> ';
			echo $before_tbl;	
			include ESCROT_PLUGIN_PATH."templates/escrows/escrows-table.php";
		echo '</div></div></div>'; 
