<?php

use Escrowtics\database\EscrowConfig; 

defined('ABSPATH') or die();

if(!isset($_GET['escrow_id'])){ exit(); }

$escrow = new EscrowConfig();

$escrow_id = $_GET["escrow_id"];

$data = $escrow->getEscrowByID($escrow_id);

$meta_data = $escrow->getEscrowMetaByID($escrow_id);

$escrow_meta_count = $escrow->escrowMetaCount($escrow_id);
	
$escrow_count = $escrow->checkEscrow($escrow_id);

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4" data-escrow-id="<?php echo $escrow_id; ?>"
id="escrot-admin-area-title">
	
	<button type="button" class="btn btn-round btn-icon-text escrot-btn-white addEscrow"
	 <?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { ?> data-toggle="modal" data-target="#escrot-milestone-form-modal"
	 <?php } else { ?> data-toggle="collapse" data-target="#escrot-milestone-form-dialog" <?php } ?> >
	   <i class="fas fa-plus"></i> <?php echo __("Create Milestone", "escrowtics"); ?>
	</button>
	  
	<div class="card-header d-none d-md-block " style="text-align:center;">
	   <h3> <i class="fas fa-circle-dollar-to-slot tbl-icon"></i>
	   <span class="escrot-tbl-header"><?php echo __("Escrow History For ", "escrowtics").$data["payer"].' & '.$data["earner"]; ?></span></h3>
	</div>
	  
	<button id="escrot-export-to-excel" data-action="escrot_export_escrow_meta_excel" class="btn btn-round m-1 float-right escrot-btn-white"> <i class="fa fa-download"></i> <?php echo __("Export Excel", "escrowtics"); ?> </button>
	
	<div class="card-header  d-block d-md-none" style="text-align:center;">
	  <h3> <i class="fas fa-circle-dollar-to-slot tbl-icon"></i>
	  <span class="escrot-tbl-header"><?php echo __("Escrows", "escrowtics"); ?></span> &nbsp;&nbsp;  <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="Reload Table" id="reloadTable"><i class="fas fa-sync-alt"></i></button></h3>
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
			   ['id' => 'escrot-view-milestone-dialog',
				'data_id' => 'escrot-milestone-details',
				'header' => '',
				'title' => __("Escrow Milestone Details", "escrowtics"),
				'callback' => '',
				'type' => 'data'
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
				'title' => __("Escrow Search Results", "escrowtics"),
				'callback' => '',
				'type' => 'data'
			   ]
		];

	escrot_callapsable_dialogs($dialogs); 
   
?>	
	  
<div class="card mb-3 p-5">
	<div class="card-body">

	   <div class="table-responsive" id="escrot-view-escrow-table-wrapper">

		 <?php include ESCROT_PLUGIN_PATH."templates/escrows/view-escrow-table.php"; ?>
	   
	   </div>
   </div>
</div>