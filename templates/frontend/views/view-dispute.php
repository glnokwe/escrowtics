<?php

defined('ABSPATH') || exit;
	
if(!isset($_GET['dispute_id'])){ exit(); }

$dispute_id = sanitize_text_field($_GET["dispute_id"]);

// Check if dispute exist			  
if( !escrot_dispute_exist($dispute_id) ) { echo __('Dispute not found. It may have been deleted', 'escrowtics'); exit; };	

$dispute_data = $user->getDisputeById($dispute_id);
$dispute_meta = $user->getDisputeMetaById($dispute_id);
$status = $dispute_data['status'] == 0? "Open" : "Closed";

$output = ''; 

$before_tbl = '
<div class="p-4">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<div class="d-none d-md-block p-2" style="text-align:center;">
			<b> 
				<span class="escrot-tbl-header">
					<b>'. __("Dispute", "escrowtics").' #: </b> 
					<span class="text-secondary">'.$dispute_data["ref_id"].'</span> &nbsp;  &nbsp;
					<b>'.__("Reason for Dispute", "escrowtics").': </b> 
					<span class="text-secondary">'.$dispute_data["reason"].'</span> &nbsp;  &nbsp;
					<b>'.__("Priority", "escrowtics").': </b> 
					<span class="text-secondary">'.$dispute_data["priority"].'</span> &nbsp; &nbsp;
					<b>'.__("Status", "escrowtics").': </b> 
					<span class="text-secondary">'.$status.'</span> 
				</span>
			</b>
		</div>
	</div>';
echo $before_tbl;	
include ESCROT_PLUGIN_PATH."templates/disputes/dispute-chat.php";
echo '</div>';
