<?php
   
	$escrow_id = ( isset($_GET["escrow_id"])? $_GET["escrow_id"] : (isset($_GET["earn_id"])? $_GET["earn_id"] : '') );
	$data      = escrot_get_escrow_data($escrow_id);
	$meta_data = $user->getEscrowMetaByID($escrow_id);
	$escrow_meta_count = $user->escrowMetaCount($escrow_id);
	$tbl_tle = isset($_GET["escrow_id"])? 'Escrow History For '.ucwords($data["earner"]) : 'Escrow History by '.ucwords($data["payer"]);
					
	$before_tbl = '
		<div class="escrot-content">	
			<div><center><h3 class="text-dark">'.$tbl_tle.'<br><a type="button" class="btn btn-sm btn-outline-secondary btn-round float-right"'; 
			   if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") {
					$before_tbl .= 'data-toggle="modal" data-target="#escrot-milestone-form-modal"';
				} else { 
					$before_tbl .=' data-toggle="collapse" data-target="#escrot-milestone-form-dialog"'; 
				} 
			$before_tbl .=' 
				><i class="fas fa-plus"></i> '.__("Add Milestone", "escrowtics").'</a></h3></center></div><br><br>
				<div class="card shadow-lg p-3">
				<div class="table-responsive escrot-sa-users-tbl" id="escrot-view-escrow-table-wrapper">';
	echo $before_tbl;				
	include ESCROT_PLUGIN_PATH."templates/escrows/view-escrow-table.php";
	echo '</div></div></div>'; 