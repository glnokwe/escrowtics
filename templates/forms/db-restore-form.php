<form id="RestoreDBForm" enctype="multipart/form-data">
	<div class="card-body p-5">
		<div style="color: red;" id="error_msgdbres"></div>
	    <div class="row">
		<input type="hidden" name="action" value="escrot_extfile_dbrestore"><!-- Ajax action callback-->
		<div class="col-md-12" style="padding-top: 15px !important;">
			<div class="fileinput fileinput-new" data-provides="fileinput">
			    <div>
				    <span class="btn btn-round escrot-btn-primary btn-file btn-sm">
					    <span class="fileinput-new"><?php echo __("Choose Backup File", "escrowtics"); ?></span>
					    <span class="fileinput-exists"><?php echo __("Change File", "escrowtics"); ?></span>
					    <input type="file" name="backup_file" accept=".sql" required> 
				    </span>  
				    <span class="text-light fileinput-preview "><?php echo __("File must be in sql format", "escrowtics"); ?></span>
				    <br/>
				    <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists escrot-btn-sm" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo __("Remove", "escrowtics"); ?></a>
				</div>
			</div>
		</div>
	   </div><br><br>
		<button type="submit" class="btn escrot-btn-primary" id="restoredb">
		<?php echo __("Restore DB", "escrowtics"); ?></button>
		<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
		   <button type="button" class="btn btn-default" data-dismiss="modal">
		   <?php echo __("Cancel", "escrowtics"); ?></button>
		<?php } else { ?>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-db-restore-form-dialog">
			   <?php echo __("Close Form", "escrowtics"); ?>
			</button> 
		<?php } ?>	
	</div>
</form>