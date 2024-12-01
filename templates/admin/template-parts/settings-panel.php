
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			
			<button id="impSett" type="button" class="btn escrot-btn-sm pr-4 pl-4 pt-3 pb-3 btn-round btn-icon-text escrot-btn-white" 
			    <?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { ?> data-toggle="modal" data-target="#doptions-import" 
                <?php } else { ?> data-toggle="collapse" data-target="#DisplayOptionsImportForm" <?php } ?> >
			   <i class="fas fa-upload"></i> <?php echo __("Import Settings", "escrowtics"); ?>
            </button>
			  
			<div class="card-header d-none d-md-block " style="text-align:center;">
               <h3> <i class="fas fa fa-sliders tbl-icon"></i>
               <span class="escrot-tbl-header"><?php echo __("Escrowtics Settings", "escrowtics"); ?></span></h3>
			</div>
			  
			<button id="expSett" class="btn escrot-btn-sm pr-4 pl-4 pt-3 pb-3 btn-round m-1 float-right escrot-btn-white"> <i class="fa fa-download"></i> 
			<?php echo __("Export Settings", "escrowtics"); ?></button>
			
			<div class="card-header  d-block d-md-none" style="text-align:center;">
              <h3> <i class="fas fa-circle-dollar-to-slot tbl-icon"></i>
              <span class="escrot-tbl-header"><?php echo __("Settings", "escrowtics"); ?></span></h3>
			</div>
		</div>
		  
	    <?php 
            
			$dialogs = [
			
			           ['id' => 'DisplayOptionsImportForm',
					    'data_id' => '',
						'header' => '',
				        'title' => 'Import Options',
						'callback' => 'options-import-form.php',
						'type' => 'restore-form'
				       ],
					   
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
          
        <div class="card mb-3 p-5 escrot-admin-forms">
            <div class="card-body" style="padding:30px 7%;">

                 <?php  include_once ( ESCROT_PLUGIN_PATH."templates/forms/settings-form.php" );  ?>
				 
			   
		   </div>
        </div>