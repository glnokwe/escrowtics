<form id="escrot-options-imp-form" enctype="multipart/form-data">
	<div class="card-body p-5">
	    <div style="color: red;" id="escrot-option-import-error"></div>
		<div class="row">
			<input type="hidden" name="action" value="escrot_imp_options">
				
			<div class="col-md-12" style="padding-top: 15px !important;">
				<div class="fileinput fileinput-new" data-provides="fileinput">
				    <div>
						<span class="btn btn-round escrot-btn-primary btn-file escrot-btn-sm">
							<span class="fileinput-new"><?= __("Choose OPtions File", "escrowtics"); ?></span>
							<span class="fileinput-exists"><?= __("Change", "escrowtics"); ?> 
							<?= __("File", "escrowtics"); ?></span>
							<input type="file" name="option_file" accept="application/json" required> 
						</span>  
						<span class="text-light fileinput-preview">
							<?= __("File must be in Json (.json) format", "escrowtics"); ?>
						</span>
						<br/>
					    <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists escrot-btn-sm" data-dismiss="fileinput"><i class="fa fa-times"></i> <?= __("Remove", "escrowtics"); ?></a>
				    </div>
				</div>
			</div>
	    </div><br><br>
	    <button type="submit" class="btn escrot-btn-primary" id="imp_options_btn">
	    <?= __("Import Options", "escrowtics"); ?></button>
	    <?php if(ESCROT_INTERACTION_MODE == "modal"){ ?>
		   <button type="button" class="btn btn-default" data-dismiss="modal">
		   <?= __("Cancel", "escrowtics"); ?></button>
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#DisplayOptionsImportForm">
			   <?= __("Close Form", "escrowtics"); ?>
			</button> 
		<?php } ?>	
	  </div>
</form>