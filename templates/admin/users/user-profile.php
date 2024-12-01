<?php 


if(isset($_POST["user_id"]))  {
	   
	$user_id = $_POST["user_id"];	

	$username = escrot_get_user_data($user_id)['username'];
	  
	
	if(!escrot_user_exist($username)){ 
		echo "</h3>User no Longer Exist<h3>"; 
		exit(); 
	}
	
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
	
	$output = '';
  
	$user_data = $this->getUserByID($user_id);
	$escrow_count = $this->userEscrowsCount($username);
	$earning_count = $this->userEarningsCount($username);	
	
	
?>	

<div class="pr-5 pl-5 row"> 
	<div class="col-md-12 col-sm-12">  
		<div class="nav nav-pills d-sm-flex align-items-center justify-content-between mb-4" data-users-url="admin.php?page=escrowtics-users" id="escrot-user-account">
			<a class="float-right btn btn-round escrot-btn-white" data-toggle="tab" href="#escrot-user-profile-tab" role="tablist">
			 <i class="fas fa-user"></i> <?php echo __("User Profile", "escrowtics"); ?>
			</a>
			<a class="float-right btn btn-round escrot-btn-white" data-toggle="tab" href="#escrot-user-escrow-tab" role="tablist">
			 <i class="fas fa-circle-dollar-to-slot"></i> <?php echo __("User Escrows", "escrowtics"); ?>
			</a>
			<h3 class="d-none d-md-inline"> <i class="fas fa-user-check tbl-icon"></i>&nbsp;
				<span class="tblhead"><?php echo __("User Profile", "escrowtics"); ?></span>
			</h3>
			<a class="float-right btn btn-round escrot-btn-white" data-toggle="tab" href="#escrot-user-earnings-tab" role="tablist">
				<i class="fas fa-hand-holding-dollar"></i> <?php echo __("User Earnings", "escrowtics"); ?>
			</a>
			<a href="#" title="Delete User" id="<?php echo $user_data["user_id"]; ?>" class="btn btn-round btn-danger m-1 escrot-delete-user-btn"> <i class="fas fa-trash"></i> 
				<span class="d-none d-md-inline"> <?php echo __("Delete User", "escrowtics"); ?></span>
			</a>
		</div>
		<h3 class="d-block d-md-none text-center"> <i class="fas fa-user-check tbl-icon"></i> &nbsp;
			<span class="tblhead"><?php echo __("User Profile", "escrowtics"); ?></span>
		</h3> 
	</div>
</div>


<div class="tab-content tab-space">
	<div class="tab-pane active" id="escrot-user-profile-tab">
		<?php include ESCROT_PLUGIN_PATH."templates/admin/users/user-dashboard.php"; ?>	
	</div>	
	<div class="p-5 tab-pane" id="escrot-user-escrow-tab">
		<div class='card escrot-admin-forms'>
			<div class='card-body'>
				<div class="table-responsive escrot-user-escrow-tbl">
					<?php 
						$data_count = $this->userEscrowsCount($username);
						$data = $this->userEscrows($username);
						include ESCROT_PLUGIN_PATH."templates/escrows/escrows-table.php"; 
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="p-5 tab-pane" id="escrot-user-earnings-tab">
		<div class='card escrot-admin-forms'>
			<div class='card-body'>
				<div class="table-responsive escrot-user-earnings-tbl">
				   <?php 
						$data_count = $this->userEarningsCount($username);
						$data = $this->userEarnings($username);
						include ESCROT_PLUGIN_PATH."templates/escrows/earnings-table.php"; 
					?>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php  } ?>
   
	   

