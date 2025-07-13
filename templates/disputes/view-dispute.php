<?php

/**
 * Admin Template to view a Dispute
 * Dispute chat container
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */

use Escrowtics\Database\DisputesDBManager; 

defined('ABSPATH') || exit;

if(!isset($_GET['dispute_id'])){ exit(); }

$output  = '';

$dispute = new DisputesDBManager();

$dispute_id = sanitize_text_field($_GET["dispute_id"]);

$dispute_data = $dispute->getDisputeById($dispute_id);

$dispute_meta = $dispute->getDisputeMetaById($dispute_id);

$status = $dispute_data['status'] == 0? "Open" : "Closed";

$toggle = ESCROT_INTERACTION_MODE == "modal"? 'modal' : 'collapse';
$target = ESCROT_INTERACTION_MODE == "modal"? 'escrot-dispute-status-modal' : 'escrot-dispute-status-dialog';

$dialogs = [
   ['id' => 'escrot-dispute-status-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Update Dispute Status", "escrowtics"),
	'callback' => 'update-dispute-status-form.php',
	'type' => ''
   ]
];


?>

<div class="d-sm-flex align-items-center justify-content-between mb-4" data-escrow-id="<?= $dispute_id; ?>"
id="escrot-admin-area-title">

	<div class="card-header d-none d-md-block " style="text-align:center;">
	    <h4> 
			<span class="escrot-tbl-header">
				<b><?= __("Dispute/Escrow", "escrowtics"); ?> #: </b> 
				<span class="text-secondary"><?= $dispute_data["ref_id"]; ?></span> &nbsp; :: &nbsp;
				<b><?= __("Parties", "escrowtics"); ?>: </b> 
				<span class="text-secondary"><?= $dispute_data['complainant']." Vs ".$dispute_data['accused']; ?></span> &nbsp; :: &nbsp;
				<b><?= __("Priority", "escrowtics"); ?>: </b> 
				<span class="text-secondary"><?= $dispute_data["priority"]; ?></span> &nbsp;:: &nbsp;
				<b><?= __("Status", "escrowtics"); ?>: </b> 
				<span class="text-secondary"><?= $status; ?></span> 
				<a href="#" class="text-success escrot-update-dispute-status" title="Edit Status" id="<?= $dispute_id; ?>" 
				data-toggle="<?= $toggle; ?>" data-target="#<?= $target; ?>"> <i class="fas fa-pen"></i> </a>
			</span>
	    </h4>
	</div>
	  
</div>
	
<?php escrot_callapsable_dialogs($dialogs); // Render collapsible dialogs ?>	
	  
<div class="card mb-3">
	<div class="card-body">
	    <div id="escrot-view-dispute-table-wrapper">
			<?php include ESCROT_PLUGIN_PATH."templates/disputes/dispute-chat.php"; ?>
	    </div>
   </div>
</div>