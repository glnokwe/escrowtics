
<div class="d-sm-flex align-items-center justify-content-between mb-4" id="escrot-admin-area-title">
	<button type="button" class="btn btn-round btn-icon-text escrot-btn-white"
	 <?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { ?> data-toggle="modal" data-target="#escrot-add-ticket-modal"
	 <?php } else { ?> data-toggle="collapse" data-target="#escrot-add-ticket-form-dialog" <?php } ?> >
	   <i class="fas fa-plus"></i> <?php echo __("Add Ticket", "escrowtics"); ?>
	</button>
	  
	<div class="card-header d-none d-md-block " style="text-align:center;">
	   <h3> <i class="fas fa-circle-dollar-to-slot tbl-icon"></i>
	   <span class="escrot-tbl-header"><?php echo __("Support Tickets", "escrowtics"); ?></span>&nbsp;<button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="Reload Table" id="reloadTable"><i class="fas fa-sync-alt"></i></button></h3>
	</div>
	  
	<button id="escrot-export-to-excel" data-action="escrot_export_tickets_excel" class="btn btn-round m-1 float-right escrot-btn-white"> <i class="fa fa-download"></i> <?php echo __("Export Excel", "escrowtics"); ?> </button>
	
	<div class="card-header  d-block d-md-none" style="text-align:center;">
	  <h3> <i class="fas fa-circle-dollar-to-slot tbl-icon"></i>
	  <span class="escrot-tbl-header"><?php echo __("Tickets", "escrowtics"); ?></span> &nbsp;&nbsp;  <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="Reload Table" id="reloadTable"><i class="fas fa-sync-alt"></i></button></h3>
	 </div>
</div>


	
<?php 

   $dialogs = [
			   
		   ['id' => 'escrot-add-ticket-form-dialog',
			'data_id' => '',
			'header' => '',
			'title' => __("Add Ticket", "escrowtics"),
			'callback' => 'add-ticket-form.php',
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
			'data_id' => 'escrot-ticket-search-results-dialog-wrap',
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

	   <div class="table-responsive" id="escrot-ticket-table-wrapper">

		 <?php include ESCROT_PLUGIN_PATH."templates/support/tickets-table.php"; ?>
	   
	   </div>
   </div>
</div>