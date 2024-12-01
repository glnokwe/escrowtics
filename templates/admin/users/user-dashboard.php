<?Php
    		
	$bio_data1 = [
		__('First Name', 'escrowtics') => $user_data["firstname"],
		__('Last Name', 'escrowtics')  => $user_data["lastname"],
		__('Main Role', 'escrowtics') => ($escrow_count > $earning_count? 'Payer' : 'Earner')
	];
	
		
	$bio_data2 = [
	    __('Phone', 'escrowtics')   => $user_data["phone"],
		__('Country', 'escrowtics') => $user_data["country"],
		__('Email', 'escrowtics')   => $user_data["email"]
	];
	
	$metrics = [
		__('Escrow List', 'escrowtics') => ['icon' => 'circle-dollar-to-slot', 'count' => $escrow_count ],
		__('Earning List', 'escrowtics') => ['icon' => 'hand-holding-dollar', 'count' => $earning_count],
		__('Total Balance', 'escrowtics') => ['icon' => 'wallet', 'count' => $user_data['balance']]
	];
	
	$approved_swal = "Swal.fire('".__('Complete Profile', 'escrowtics')."', '".__('User Profile 100% Complete', 'escrowtics')."', 'success');";
	$pending_swal = "Swal.fire('".__('Incomplete Profile', 'escrowtics')."', '".__('Please Complete Your Profile!', 'escrowtics')."', 'warning');";
	
?>
<div class="section escrot-user-dashboard gray-bg text-light">
	<div class="row p-4">
		<div class="col-md-12">
			<div class="card shadow-lg row <?= wp_is_mobile()? 'p-3' : 'p-5';  ?> align-items-center flex-row-reverse">
				<div class="col-lg-7">
					<div class="about-text go-to">
						<h3 class="escrot-label"><?php echo $user_data["firstname"].' '.$user_data["lastname"]; ?> 
							<span class="h3">
								<button type="button"  id="<?php echo $user_data["user_id"]; ?>"
									<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ ?>
										data-toggle="modal" data-target="#escrot-edit-user-modal"
									<?php } else { ?>
										data-toggle="collapse" data-target="#escrot-edit-user-form-dialog"
									<?php } ?>
									class="btn btn-sm btn-round btn-success escrot-user-edit-btn mt-0"> 
									<i class="fas fa-user-pen"></i> <?php echo __("edit", "escrowtics"); ?>
								</button>
							</span>
						</h3>
						<p class="lead text-secondary">
							<span class="badge badge-secondary">
								<?php echo $escrow_count > $earning_count? 'Escrow Payer' : 
								           ($escrow_count == 0 && $earning_count == 0 ? 'New User' : 'Escrow Earner') ?>
							</span> <b>::</b> 
							<a href="<?php echo (empty($user_data["website"])? '#' : $user_data["website"]);  ?>">
								<?php  echo $user_data["company"]; ?>
							</a> <b>::</b> 
							<small><i class="fa fa-clock"></i> <?php echo $user_data["creation_date"]; ?> </small>
						</p>

						<p><?php echo $user_data["bio"]; ?></p><hr/>
						<div class="row about-list">
							<div class="col-md-6">
								<?php foreach($bio_data1 as $tle => $val){  ?>
									<div class="media">
										<label><?php echo $tle; ?></label>
										<p><?php echo $val; ?></p>
									</div>
							  <?php } ?>	 
							</div>
							<div class="col-md-6">
								<?php foreach($bio_data2 as $tle => $val) { ?>
									<div class="media">
										<label><?php echo $tle; ?></label>
										<p><?php echo $val; ?></p>
									</div>
							   <?php } ?>	 
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="about-avatar">
						<?php echo escrot_image($user_data["user_image"], '350', 'escrot-rounded'); ?>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div class="row p-4">
		<?php foreach($metrics as $tle => $val) { ?>
			<div class="col-md-4">
				<div class="card escrot-rounded shadow-lg text-center pt-3">
					<h3><i class="text-secondary fa fa-<?php echo $val['icon']; ?>"></i> 
						<?php echo escrot_minify_count($val['count']); ?></h3>
					<p class="m-0px font-w-600">
						<?php 
							echo '<b>'.$tle.'</b>'; 
							if($tle == "Total Balance"){
								echo ' | '.ESCROT_CURRENCY.' <b>'.$val['count'].'</b>';
							} else {
								echo ' | <b>'.escrot_minify_count($val['count']).'</b> Members'; 
							} 
						?> 
					</p>
				</div>
			</div>
		<?Php }	?>  
	</div>
	
</div>