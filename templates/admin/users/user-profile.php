<?php 

/**
 * Admin Template for frontend User's Profile
 * Display admin side frontend user's profile.
 * 
 * @package Escrowtics
 */
 
 
if(isset($_POST["user_id"]))  {
	   
	$user_id = sanitize_text_field($_POST["user_id"]);
	$user = get_user_by( 'ID', $user_id ); 
	
	if (!$user || !username_exists($user->user_login)) {
        echo "<h3>" . esc_html__('User no Longer Exist', 'escrowtics') . "</h3>";
        exit();
    }
	
	$username = $user->user_login;
	
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
		   ]
	];
	
	escrot_callapsable_dialogs($dialogs);
	
	$output = '';
  
	$user_data = $this->getUserById($user_id);
	$escrow_count = $this->getUserEscrowsCount($username);
	$earning_count = $this->getUserEarningsCount($username);	
	
	
?>	
<!-- Navigation Buttons -->
<div class="pr-5 pl-5 row"> 
	<div class="col-md-12 col-sm-12">  
		<div class="nav nav-pills d-sm-flex align-items-center justify-content-between mb-4" data-users-url="admin.php?page=escrowtics-users" id="escrot-user-account">
			<a class="escrot-user-profile-btn float-right btn shadow-lg escrot-btn-white" data-toggle="tab" href="#escrot-user-profile-tab" role="tablist">
			 <i class="fas fa-user"></i> <?= __("User Profile", "escrowtics"); ?>
			</a>
			<a id="escrot-user-escrows-btn" class="float-right btn shadow-lg escrot-btn-white" data-toggle="tab" href="#escrot-user-escrow-tab" role="tablist">
			 <i class="fas fa-filter-circle-dollar"></i> <?= __("User Escrows", "escrowtics"); ?>
			</a>
			<h3 class="d-none d-md-inline"> 
				<span class="escrot-user-profile-title"><?= __("User Profile", "escrowtics"); ?></span>
				<span class="escrot-user-escrow-tbl-title collapse"><?= __('User Escrows', 'escrowtics'); ?></span>
				<span class="escrot-user-earnings-tbl-title collapse"><?= __('User Earnings', 'escrowtics'); ?></span>
			</h3>
			<a id="escrot-user-earnings-btn" class="float-right btn shadow-lg escrot-btn-white" data-toggle="tab" href="#escrot-user-escrow-tab" role="tablist">
				<i class="fas fa-hand-holding-dollar"></i> <?= __("User Earnings", "escrowtics"); ?>
			</a>
			<a href="#" title="Delete User" id="<?= $user_data["ID"]; ?>" class="btn btn-danger m-1 shadow-lg escrot-delete-user-btn"> <i class="fas fa-trash"></i> 
				<span class="d-none d-md-inline"> <?= __("Delete User", "escrowtics"); ?></span>
			</a>
		</div>
		<!--Mobile Title-->
		<h3 class="d-block d-md-none text-center"> 
		    <span class="escrot-user-profile-title"><?= __("User Profile", "escrowtics"); ?></span>
			<span class="escrot-user-escrow-tbl-title collapse"><?= __('User Escrows', 'escrowtics'); ?></span>
			<span class="escrot-user-earnings-tbl-title collapse"><?= __('User Earnings', 'escrowtics'); ?></span>
		</h3> 
	</div>
</div>

 <!-- Tab Content -->
<div class="tab-content tab-space">
	<div class="tab-pane active" id="escrot-user-profile-tab">
		<?php include ESCROT_PLUGIN_PATH."templates/admin/users/user-dashboard.php"; ?>	
	</div>	
	<div class="p-5 tab-pane" id="escrot-user-escrow-tab">
		<div class='card escrot-admin-forms'>
			<div class='card-body'>
				<div class="table-responsive escrot-user-escrow-tbl">
				</div>
			</div>
		</div>
	</div>
</div>	

<?php  } ?>
   
	   

