<?php 

    $form_type = "add"; 
    if(ESCROT_ESCROW_FORM_STYLE == "normal") { 
    
	?>  
                
		<div id="add-trkg-dialog"></div>
            <form id="AddEscrowForm" enctype = "multi-part/form-data">
				<div class="card-body">
					<div class="text-danger" id="escrot-escrow-error"></div>
                    <div class="row">
						<?php 
							$form_tle = is_escrot_front_user()? __("Username (Earner)", "escrowtics") : __("Escrow Parties (Payer & Earner)", "escrowtics"); 
						?>
					    <div class="col-md-12"><label><h3 class="text-light"> 
						<?php echo '<h3 class="text-dark">'.$form_tle.'</h3>'; ?></h3></label></div>
					    <?php include ESCROT_PLUGIN_PATH."templates/forms/form-fields/escrow-form-fields/escrow-info-form-fields.php"; ?>      
						<div class="col-md-12"><label><h3 class="text-dark">Transaction Details</h3></label></div>
						<?php include ESCROT_PLUGIN_PATH."templates/forms/form-fields/escrow-form-fields/escrow-meta-form-fields.php"; ?>
	                </div>
					<div class="row" id="appendCF"></div>	
					<br><br><div style="color: red;" class="add_error_msg"></div><br>
                    <button type="submit" class="btn escrot-btn-primary text-white" id="addTrackingBtn">Add Escrow</button>
					<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
					<?php } else { ?>
				        <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-add-escrow-form-dialog">
							Close Form
	                    </button> 
						<?php } ?>		
                </div>
            </form>
				    
    <?php } else { ?>
	
		<div class="wizard-container">
		  <div class="card card-wizard bg-transparent p-0" data-color="purple" id="wizardProfile" 
		  style="border:none !important; box-shadow: none !important;">
			<form method="post" id="AddEscrowForm">
			 <div class="text-danger" id="escrot-escrow-error"></div>  
			
			  <div class="wizard-navigation">
				<ul class="nav nav-pills">
				  <li class="nav-item">
				   <a class="nav-link active" data-toggle="tab" href="#EscrowInfoTab" role="tab">
				  <?php echo __("Escrow Users", "escrowtics"); ?>
				  </a>
				</li>	 
				<li class="nav-item">
				   <a class="nav-link" data-toggle="tab" href="#DetailsTab" role="tab">
				 <?php echo __("Transaction Details", "escrowtics"); ?> 
				  </a>
				</li>	 
				</ul>
			  </div>
			  
			  
			<div class="mt-5 card-footer">
				<div class="mr-auto">
				  <input type="button" class="btn btn-outline-secondary btn-round btn-previous btn-fill btn-wd disabled" name="previous" value="Previous">
				</div>
				<div class="ml-auto">
				  <input type="button" class="btn btn-outline-info btn-next btn-round btn-fill btn-wd" name="next" value="<?php echo __("Next", "escrowtics"); ?>">
				  <button type="submit" class="btn btn-outline-success btn-finish btn-round btn-fill btn-wd" name="finish"  style="display: none;"><i class='fas fa-user-plus'></i> <?php echo __("Add Escrow", "escrowtics"); ?></button>
				</div>
				<div class="clearfix"></div>
			  </div>
			  
			  
			  <div class="card-body">
				<div class="tab-content">
				
				  <div class="tab-pane active" id="EscrowInfoTab">
					<h3 class="text-light"> Escrow Parties (Payer & Earner)</h3><br><br>
					<div class="row justify-content-center">
					  <?php include ESCROT_PLUGIN_PATH."templates/forms/form-fields/escrow-form-fields/escrow-info-form-fields.php"; ?>
					</div>
				  </div>
				  
				  <div class="tab-pane" id="DetailsTab">
					<h3 class="text-light"> Transaction Details </h3><br><br>
					<div class="row justify-content-center">
						<?php include ESCROT_PLUGIN_PATH."templates/forms/form-fields/escrow-form-fields/escrow-meta-form-fields.php"; ?>
					</div>
				  </div>
				  
				</div>
			  </div>
			  
			  
			  <div class="mt-5 card-footer">
				<div class="mr-auto">
				  <input type="button" class="btn btn-outline-secondary btn-round btn-previous btn-fill btn-wd disabled" name="previous" value="Previous">
				</div>
				<div class="ml-auto">
				  <input type="button" class="btn btn-outline-info btn-next btn-round btn-fill btn-wd" name="next" value="<?php echo __("Next", "escrowtics"); ?>">
				  <button type="submit" class="btn btn-outline-success btn-finish btn-round btn-fill btn-wd" name="finish"  style="display: none;"><i class='fas fa-user-plus'></i> <?php echo __("Add Escrow", "escrowtics"); ?></button>
				</div>
				<div class="clearfix"></div>
			  </div>
			  
			</form>
			
			<div class="text-danger add_error_mge"></div>
		  </div>
		</div>
			
			
    <?php } ?>		
		