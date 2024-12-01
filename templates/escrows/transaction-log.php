
		<div class="d-sm-flex align-items-center justify-content-between mb-4" id="escrot-admin-area-title">
			
			<button type="button" class="btn btn-round btn-icon-text escrot-btn-white">
			   <i class="fas fa-arrow-left"></i> <?php echo __("Back home", "escrowtics"); ?>
            </button>
			  
			<div class="card-header d-none d-md-block " style="text-align:center;">
               <h3> <i class="fas fa-circle-dollar-to-slot tbl-icon"></i>
               <span class="escrot-tbl-header"><?php echo __("Transaction Log", "escrowtics"); ?></span>&nbsp;<button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="Reload Table" id="reloadTable"><i class="fas fa-sync-alt"></i></button></h3>
			</div>
			  
			<button id="escrot-export-to-excel" data-action="escrot_export_log_excel" class="btn btn-round m-1 float-right escrot-btn-white"> <i class="fa fa-download"></i> <?php echo __("Export Excel", "escrowtics"); ?> </button>
			
			<div class="card-header  d-block d-md-none" style="text-align:center;">
              <h3> <i class="fas fa-circle-dollar-to-slot tbl-icon"></i>
              <span class="escrot-tbl-header"><?php echo __("Transaction Log", "escrowtics"); ?></span> &nbsp;&nbsp;  <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="Reload Table" id="reloadTable"><i class="fas fa-sync-alt"></i></button></h3>
			 </div>
		</div>
		
		
			
		<?php 
		
		   $dialogs = [
					   
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
	
               <div class="table-responsive" id="escrot-escrow-log-table-wrapper">
			   
                 <?php include ESCROT_PLUGIN_PATH."templates/escrows/transaction-log-table.php"; ?>
			   
               </div>
		   </div>
        </div>