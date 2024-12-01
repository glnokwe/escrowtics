<?php    
	
	
	$modals = array(

                array(
                 "id" => "escrot-db-restore-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "escrot-modal-sm",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "sync",
				 "title" => __("Database Restore", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "db-restore-form.php"
                ),
                array(
                 "id" => "escrot-sett-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "sett-modal",
                 "modal-content-class" => "setContent",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "sliders",
				 "title" => __("Escrowtics Settings Panel", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "settings-form.php"
                ),
                array(
                 "id" => "escrot-options-import-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "escrot-modal-sm",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "upload",
				 "title" => __("Import Options", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "options-import-form.php"
                ),
				array(
                 "id" => "escrot-add-user-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Add User", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "add-user-form.php"
                ),
                
                array(
                 "id" => "escrot-edit-user-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Edit User", "escrowtics").' [<span class="small" id="CrtEditUserID"></span>]',
				 "modal-body-id" => "",
				 "callback" => "edit-user-form.php"
                ),
                array(
                 "id" => "escrot-add-escrow-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Add Escrow", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "add-escrow-form.php"
                ),
				array(
                 "id" => "escrot-milestone-form-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Add Escrow Milestone", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "add-milestone-form.php"
                ),
				array(
                 "id" => "escrot-add-ticket-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Add Support Ticket", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "add-ticket-form.php"
                ),
				array(
                 "id" => "escrot-escrow-search-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Escrow Search Results", "escrowtics"),
				 "modal-body-id" => "escrot-escrow-search-results-modal-body",
				 "callback" => ""
                ),
				array(
                 "id" => "escrot-view-milestone-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "escrot-modal-sm",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Escrow Milestone Details", "escrowtics"),
				 "modal-body-id" => "escrot-view-milestone-modal-body",
				 "callback" => ""
                ),
				array(
                 "id" => "escrot-withdrawal-status-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "escrot-modal-sm",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Update Withdrawwal Status", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "update-invoice-status-form.php"
                ),
				array(
                 "id" => "escrot-ticket-status-modal",
				 "modal-static" => false,
				 "modal-dialog-class" => "",
                 "modal-content-class" => "escrot-modal-sm",
				 "header-status" => false, "header" => "",
				 "modal-title-class" => "",
				 "type" => "",  "icon" => "",
				 "title" => __("Update Ticket Status", "escrowtics"),
				 "modal-body-id" => "",
				 "callback" => "update-ticket-status-form.php"
                )

    );
	
	 
	foreach($modals as $modal){ ?> 
	 
	    <div class="modal fade"<?php echo ($modal["modal-static"]? ' data-backdrop="static"' : ' style="z-index: 1045;"');  ?> id="<?php echo $modal["id"]; ?>">
          <div class="modal-dialog <?php echo $modal["modal-dialog-class"]; ?>">
            <div class="modal-content <?php echo $modal["modal-content-class"]; ?>">
                <div class="modal-header">
	                <h3 class="modal-title text-dark <?php echo $modal["modal-title-class"]; ?>">
					    <?php if($modal["header-status"]){ 
						   include_once(ESCROT_PLUGIN_PATH."templates/admin/template-parts/".$modal["header"]); 
						} else { ?>
						    <i class="fa fa-<?php echo $modal["icon"]; ?> sett-icon"></i> 
					        &nbsp;<?php if($modal["type"]== "edit-form") {echo $modal["title"]; } else { 
						    echo $modal["title"]; } 
						} ?>
					</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="<?php echo $modal["modal-body-id"]; ?>">
			        <?php if(!empty($modal["callback"])) { 
					  include_once(ESCROT_PLUGIN_PATH."templates/forms/".$modal["callback"] ); }
					?>
                </div>
            </div>
          </div>
        </div>
		
	<?php } ?>