<?php

use Escrowtics\database\SupportConfig; 

defined('ABSPATH') or die();

if(!isset($_GET['ticket_id'])){ exit(); }

$ticket = new SupportConfig();

$ticket_id = wp_unslash($_GET["ticket_id"]);;

$data = $ticket->getTicketByID($ticket_id);

$output  = '';

$ticket_meta = $ticket->getTicketMetaByID($ticket_id);

$status = $data['status'] == 0? "Open" : "Closed";

$toggle = ESCROT_PLUGIN_INTERACTION_MODE == "modal"? 'modal' : 'collapse';
$target = ESCROT_PLUGIN_INTERACTION_MODE == "modal"? 'escrot-ticket-status-modal' : 'escrot-ticket-status-dialog';

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4" data-escrow-id="<?php echo $ticket_id; ?>"
id="escrot-admin-area-title">

	<div class="card-header d-none d-md-block " style="text-align:center;">
	    <h4> 
			<span class="escrot-tbl-header">
				<b><?= __("Ticket", "escrowtics"); ?> #: </b> 
				<span class="text-secondary"><?= $data["ref_id"]; ?></span> &nbsp; :: &nbsp;
				<b><?= __("Department", "escrowtics"); ?>: </b> 
				<span class="text-secondary"><?= $data["department"]; ?></span> &nbsp; :: &nbsp;
				<b><?= __("User", "escrowtics"); ?>: </b> 
				<span class="text-secondary"><?= $data["user"]; ?></span> 
				&nbsp; :: &nbsp;
				<b><?= __("Priority", "escrowtics"); ?>: </b> 
				<span class="text-secondary"><?= $data["priority"]; ?></span> &nbsp;:: &nbsp;
				<b><?= __("Status", "escrowtics"); ?>: </b> 
				<span class="text-secondary"><?= $status; ?></span> 
				<a href="#" class="text-success escrot-update-ticket-status" title="Edit Status" id="<?= $ticket_id; ?>" 
				data-toggle="<?= $toggle; ?>" data-target="#<?= $target; ?>"> <i class="fas fa-pen"></i> </a>
			</span>
	    </h4>
	</div>
	  
</div>
	
<?php 

$dialogs = [
			   
   ['id' => 'escrot-milestone-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Add Milestone", "escrowtics"),
	'callback' => 'add-milestone-form.php',
	'type' => 'add-form'
   ],
   ['id' => 'escrot-db-restore-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Restore Database Backup", "escrowtics"),
	'callback' => 'db-restore-form.php',
	'type' => 'restore-form'
   ],
   ['id' => 'escrot-search-results-dialog',
	'data_id' => 'escrot-escrow-search-results-dialog-wrap',
	'header' => '',
	'title' => __("Ticket Search Results", "escrowtics"),
	'callback' => '',
	'type' => 'data'
   ],
   ['id' => 'escrot-ticket-status-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Update Ticket Status", "escrowtics"),
	'callback' => 'update-ticket-status-form.php',
	'type' => ''
   ]
];

escrot_callapsable_dialogs($dialogs); 
   
?>	
	  
<div class="card mb-3">
	<div class="card-body">
	    <div id="escrot-view-ticket-table-wrapper">
			<?php include ESCROT_PLUGIN_PATH."templates/support/ticket-chat.php"; ?>
	    </div>
   </div>
</div>