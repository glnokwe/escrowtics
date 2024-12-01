
<div class="d-sm-flex align-items-center justify-content-between mb-4">

	<button id="BackupDB" type="button" class="btn btn-round btn-icon-text escrot-btn-white">
		<i class="fas fa-plus"></i> <?php echo __("Create", "escrowtics"); ?> 
		<span class="d-none d-md-inline"><?php echo __("New DB", "escrowtics"); ?></span> 
		<?php echo __("Backup", "escrowtics"); ?>
	</button>
	  
	<!--- Desktop Only ----->
	<div class="card-header d-none d-md-block">
	  <h3>  <i class="fa-solid fa-database tbl-icon"></i><span class="escrot-tbl-header"> 
	  <?php echo __("Escrowtics Database Backups", "escrowtics"); ?> </span></h3>
	</div>
	  
	<button id="GLotDBRestore" class="btn m-1 float-right escrot-btn-white btn-round" 
		<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { ?> data-toggle="modal" data-target="#escrot-db-restore-modal" 
		<?php } else { ?> data-toggle="collapse" data-target="#escrot-db-restore-form-dialog" <?php } ?> >
		<i class="fa fa-sync"></i> <?php echo __("Restore", "escrowtics"); ?> 
		<span class="d-none d-md-inline"><?php echo __("Old Backup", "escrowtics"); ?></span> 
	</button>

	
	<!--- Mobile Only ----->
	<div class="card-header  d-block d-md-none" style="text-align:center;">
	   <h3>
			<i class="fa-solid fa-paste tbl-icon"></i>
			<span class="escrot-tbl-header"><?php echo __("Database Backups", "escrowtics"); ?></span>
	   </h3>
	</div>
	
</div>


<?php 

	$dialogs = [
			   
			   ['id' => 'escrot-db-restore-form-dialog',
				'data_id' => '',
				'header' => '',
				'title' => 'Restore Database Backup',
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
	 <div class="table-responsive" id="tableDataDbBackup"> 
	
	 <?php include_once ESCROT_PLUGIN_PATH."templates/admin/db-backup/dbbackups-table.php"; ?>
	
	 </div>
   </div>
   
</div>