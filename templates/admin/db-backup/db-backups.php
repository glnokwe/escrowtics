
<div class="d-sm-flex align-items-center justify-content-between mb-4">

	<button id="BackupDB" type="button" class="btn btn-icon-text shadow-lg escrot-btn-white">
		<i class="fas fa-plus"></i> <?= __("Create", "escrowtics"); ?> 
		<span class="d-none d-md-inline"><?= __("New DB", "escrowtics"); ?></span> 
		<?= __("Backup", "escrowtics"); ?>
	</button>
	  
	<!--- Desktop Only ----->
	<div class="card-header d-none d-md-block">
	  <h3>  <i class="fa-solid fa-database tbl-icon"></i><span class="escrot-tbl-header"> 
	  <?= __("Escrowtics Database Backups", "escrowtics"); ?> </span></h3>
	</div>
	  
	<button id="GLotDBRestore" class="btn m-1 float-right shadow-lg escrot-btn-white" 
		<?php if(ESCROT_INTERACTION_MODE == "modal") { ?> data-toggle="modal" data-target="#escrot-db-restore-modal" 
		<?php } else { ?> data-toggle="collapse" data-target="#escrot-db-restore-form-dialog" <?php } ?> >
		<i class="fa fa-sync"></i> <?= __("Restore", "escrowtics"); ?> 
		<span class="d-none d-md-inline"><?= __("Old Backup", "escrowtics"); ?></span> 
	</button>

	
	<!--- Mobile Only ----->
	<div class="card-header d-block d-md-none" style="text-align:center;">
	   <h3>
			<i class="fa-solid fa-paste tbl-icon"></i>
			<span class="escrot-tbl-header"><?= __("Database Backups", "escrowtics"); ?></span>
	   </h3>
	</div>
	
</div>

<div class="card mb-3 p-5">
  <div class="card-body">
	 <div class="table-responsive" id="tableDataDBBackup"> 
	
	 <?php include_once ESCROT_PLUGIN_PATH."templates/admin/db-backup/dbbackups-table.php"; ?>
	
	 </div>
   </div>
   
</div>