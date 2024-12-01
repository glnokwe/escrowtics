<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
	  <div class="text-center">
		<button id="impSett" type="button" class="btn btn-round btn-icon-text btn-behance" data-toggle="modal" data-target="#escrot-options-import-modal"><i class="fas fa-upload"></i> <?php echo __("Import Settings", "escrowtics"); ?>
		   </button>
		   <button id="expSett" class="btn btn-round m-1 btn-info"> 
			<i class="fa fa-download"></i> <?php echo __("Export Settings", "escrowtics"); ?>
		</button>
	</div><br>
<?php } ?>	
<form method="post" action="options.php" id="escrot-options-form">

   <?php settings_errors(); ?>
   
   <div id="escrot-settings-panel">
   
	<?php settings_fields( 'escrowtics_plugin_settings' ); ?>	
	 <div class="card-body">
	<ul class="nav nav-pills" style="width: 100% !important" role="tablist">
  
		<li class="nav-item">
		   <a class="nav-link active" data-toggle="tab" href="#GeneralTab" role="tablist">
		  <i class="fa fa-gear"></i> <?php echo __("General", "escrowtics"); ?>
		  </a>
		</li>	 
		<li class="nav-item">
		   <a class="nav-link" data-toggle="tab" href="#EscrowsTab" role="tablist">
		  <i class="fa fa-circle-dollar-to-slot"></i> <?php echo __("Escrows", "escrowtics"); ?> 
		  </a>
		</li> 
		<li class="nav-item">
		   <a class="nav-link" data-toggle="tab" href="#EmailsTab" role="tablist">
		  <i class="fa fa-envelope"></i> <?php echo __("Email", "escrowtics"); ?> 
		  </a>
		</li>	 
		<li class="nav-item">
		   <a class="nav-link" data-toggle="tab" href="#StylingTab" role="tablist">
		  <i class="fa fa-paint-brush"> </i> <?php echo __("Styling", "escrowtics"); ?> 
		  </a>
		</li>	 
		<li class="nav-item">
		   <a class="nav-link" data-toggle="tab" href="#DBBackupTab" role="tablist">
		  <i class="fa fa-database"> </i> <?php echo __("DB Backup", "escrowtics"); ?>
		  </a>
		</li>
		
		<li class="nav-item">
		   <a class="nav-link" data-toggle="tab" href="#PaymentTab" role="tablist">
		  <i class="fa fa-dollar-sign"> </i> <?php echo __("Payments", "escrowtics"); ?>
		  </a>
		</li>
		
		<li class="nav-item">
		   <a class="nav-link" data-toggle="tab" href="#AdvancedTab" role="tablist">
		  <i class="fa fa-shield"> </i> <?php echo __("Advanced", "escrowtics"); ?>
		  </a>
		</li>
   
	</ul>
		  
	<div class="tab-content tab-space">
		  
			<div class="tab-pane active" id="GeneralTab">
			   <div class="row">
				 <?php do_settings_sections( 'escrowtics-general' );?>	
				  <div class="col-md-6 card shadow-lg setTogg pl-3 pr-3">
					<label for="company Logo Size">
					 <span class="text-light"> <i class="fas fa-pen-ruler sett-icon"></i>
					 &nbsp; <?php echo __("Logo Size (Width x Height)", "escrowtics"); ?></span>
					</label><br><br>
					<div class="row">
						<?php do_settings_sections( 'escrowtics-logo-size-settings' ); ?>
					</div> 
				</div>
			   </div>
			</div>
			
			<div class="tab-pane" id="EscrowsTab">
			   <div class="row">
				<?php do_settings_sections( 'escrowtics-backend-escrow' ); ?>
				
				<div id="EscrotRefID" class="col-md-12 pl-3 pr-3"><br><br>
					<label>
					 <h4 class="text-light">
					 <?php echo __("Reference ID/Number Options", "escrowtics"); ?></h4>
					</label><br><br>
					<div class="row">
					   <?php do_settings_sections( 'escrowtics-ref-id' ); ?>
					</div> 
				</div>
				
			   </div> 
			</div>
			
			
			<div class="tab-pane" id="EmailsTab">
			   <div class="row">
				<?php do_settings_sections( 'escrowtics-emails' ); ?>
				<div id="SmtpSetup" class="col-md-12 card shadow-lg setTogg12 p-5">
					<label>
					 <h4 class="text-light">
					   <?php echo __("Mail SMTP Setup (Required to use custom SMTP)", "escrowtics"); ?>
					 </h4>
					</label><br>
					<div class="row">
					   <?php do_settings_sections( 'escrowtics-smtp-settings' ); ?>
					</div>    
				</div>  
				<div id="EmailSetup" class="col-md-12 card shadow-lg setTogg12 pl-5 pt-5 pr-3">
					<label>
					 <h3 class="text-light text-center"><?php echo __("Notification Email Setup", "escrowtics"); ?></h3>
					</label><br>
						<div id="EscrotMergeTags" class="text-gray">
						<span class="small">
						  <?php echo __("Use the following merge tags in the form fields if necessary", "escrowtics"); ?>
						</span>
						  <table class="table-responsive escrot-tbl">
						   <tr class="escrot-tr">
							<th class="escrot-th escrot-th-sm"><?php echo __("Escrow Ref ID", "escrowtics"); ?></th> 
							<th class="escrot-th escrot-th-sm"><?php echo __("Escow Status", "escrowtics"); ?></th> 
							<th class="escrot-th escrot-th-sm"><?php echo __("Escrow Earner", "escrowtics"); ?></th>
							<th class="escrot-th escrot-th-sm"><?php echo __("Escrow Amount", "escrowtics"); ?></th>
							<th class="escrot-th escrot-th-sm"><?php echo __("Earner Email", "escrowtics"); ?></th>
							<th class="escrot-th escrot-th-sm"><?php echo __("Escrow Title", "escrowtics"); ?></th>
							<th class="escrot-th escrot-th-sm"><?php echo __("Escrow Details", "escrowtics"); ?></th>
							<th class="escrot-th escrot-th-sm"><?php echo __("Current Year", "escrowtics"); ?></th>
							<th class="escrot-th escrot-th-sm"><?php echo __("website Title", "escrowtics"); ?></th>
							<th class="escrot-th escrot-th-sm"><?php echo __("Company address", "escrowtics"); ?></th>
						   </tr>
						   <tr class="escrot-tr">
							<td class="escrot-td">{ref-id}</td> 
							<td class="escrot-td">{status}</td> 
							<td class="escrot-td">{earner}</td>
							<td class="escrot-td">{amount}</td>
							<td class="escrot-td">{earner_email}</td>
							<td class="escrot-td">{title}</td>
							<td class="escrot-td">{details}</td>
							<td class="escrot-td">{current-year}</td>
							<td class="escrot-td">{site-title}</td>
							<td class="escrot-td">{company-address}</td>
						   </tr>
						  </table>
						</div>   
					  
					   
						<div class="col-xs-12 pt-5" id="escrot-tabs">
							<nav>
								<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active text-light" data-toggle="tab" href="#OnCreate" 
									role="tab" aria-selected="true">
										<?php echo __("User Notification Email Setup", "escrowtics"); ?>
									</a>
									<a class="nav-item nav-link text-light" data-toggle="tab" href="#OnUpdate" role="tab"  
									aria-selected="false">
										<?php echo __("Admin Notification Email Setup", "escrowtics"); ?>
									</a>
								</div>
							</nav>
							<div class="tab-content py-3 px-3 px-sm-0">
								<div class="tab-pane fade show active" id="OnCreate" role="tabpanel">
									<?php do_settings_sections( 'escrowtics-user-escrow-email' ); ?>
								</div>
								<div class="tab-pane fade" id="OnUpdate" role="tabpanel">
									<?php do_settings_sections( 'escrowtics-admin-escrow-email' ); ?>
								</div>
							</div>
						</div>
					</div> 
			    </div>	
			</div>
			
			<div class="tab-pane" id="StylingTab">
				<div class="row">
					<?php do_settings_sections( 'escrowtics-admin-appearance' ); ?>
				</div>
				
					<div class="row">
					<?php do_settings_sections( 'escrowtics-public-appearance' ); ?>
					
					 
						<div id="EscrotLabels" class="col-md-12 card shadow-lg setTogg12 p-5">
							<label>
							 <h4 class="text-light">
							 <?php echo __("Custom Labels (Change all default labels on tracking results)", "escrowtics"); ?></h4>
							</label>
							<div class="row">  
								<?php do_settings_sections( 'escrowtics-labels' ); ?>
							</div>
						</div>
					</div> 
			</div>	
			
			<div class="tab-pane" id="DBBackupTab">
			  <div class="row">
			   <?php do_settings_sections( 'escrowtics-db' ); ?> 
			  </div>
			</div>
			
			
			<div class="tab-pane" id="PaymentTab">
				<div class="row">
					<?php do_settings_sections( 'escrowtics-payment' ); ?>
			   </div> 
			</div>
			
			<div class="tab-pane" id="AdvancedTab">
				<div class="row">
					<?php do_settings_sections( 'escrowtics-advanced' ); ?>
			   </div> 
			</div>
			   
		   
  
		</div>
	   </div>				

	   <br><br> 
	   
	   <button type="submit" name="submit" id="escrot-submit-settings" class="button btn-round btn btn-success">
		<i class="fa fa-save"></i> <?php echo __("Save Settings", "escrowtics"); ?>
	   </button>
			 
	   <button type="button" id="resetSett" class="btn btn-round btn-danger ml-5">
		<i class="fa fa-shuffle"></i> <?php echo __("Reset Settings", "escrowtics"); ?>
	   </button>
			 
	   <?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal" && !wp_is_mobile()){ ?>
			<button type="button" class="btn btn-round btn-default float-right" data-dismiss="modal">
				<?php echo __("Close Panel", "escrowtics"); ?>
			</button> 
		<?php } ?>	
	   <br><br> 
			 
  
</div>

</form>


		
		
		

		
  
