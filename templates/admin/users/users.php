
<div class="d-sm-flex align-items-center justify-content-between mb-4" id="escrot-admin-area-title">
	<button type="button" class="btn btn-icon-text btn-round escrot-btn-white" 
		<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { ?> data-toggle="modal" data-target="#escrot-add-user-modal" 
		<?php } else { ?> data-toggle="collapse" data-target="#escrot-add-user-form-dialog" <?php } ?> >
		<i class="fas fa-plus"></i>  <?php echo __("Add User", "escrowtics"); ?>
	</button>
  
	<div class="card-header d-none d-md-block">
		<h3> <i class="fas fa-user-group tbl-icon"></i>
			<span class="escrot-tbl-header"><?php echo __("Users", "escrowtics"); ?></span>
		</h3>
	</div>
	
	<button id="escrot-export-to-excel" data-action="escrot_export_user_excel" class="btn m-1 float-right escrot-btn-white btn-round"> <i class="fa fa-download"></i> <?php echo __("Export To Excel", "escrowtics"); ?> </button>
	
	
	<!--- Mobile Only ----->
	<div class="card-header  d-block d-md-none" style="text-align:center;">
		<h3> <i class="fas fa-user-group tbl-icon"></i>
			 <span class="escrot-tbl-header"><?php echo __("Users", "escrowtics"); ?></span>
		</h3>
	</div>
</div>

<?php 

   $dialogs = [
			   
			   ['id' => 'escrot-add-user-form-dialog',
				'data_id' => '',
				'header' => '',
				'title' => __("Add User", "escrowtics"),
				'callback' => 'add-user-form.php',
				'type' => 'add-form'
			   ],
			   ['id' => 'escrot-edit-user-form-dialog',
				'data_id' => '',
				'header' => '',
				'title' => __("Edit User Account ", "escrowtics").' [<span class="small" id="CrtEditUserID"></span>]',
				'callback' => 'edit-user-form.php',
				'type' => 'edit-form'
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
	<div id="escrot-user-table-wrapper">
		<?php include_once ESCROT_PLUGIN_PATH."templates/admin/users/users-table.php"; ?>
	</div>
  </div>
</div>


