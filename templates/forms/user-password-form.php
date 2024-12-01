<div class="p-5 escrot-rounded e-profile">

	<div style="color: red;" id="escrot_user_pass_error"></div>

    <br><br>
    <div class="tab-content pt-3">
		<div class="tab-pane active">
		  <form id="EditEscrotUserPassForm" class="form">
		    <input type="hidden" name="action" value="escrot_change_user_pass">
			<?php wp_nonce_field('escrot_user_pass_nonce', 'nonce'); ?>
			
			 <div class="row">
				<div class="col">
					<div class="form-group">
						<div class="mb-2 h3"><b>Change Password</b></div>
					</div>	
				</div>	
			</div><br><br>		
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label>Current Password</label>
						<input class="form-control" type="password" name="old_password" placeholder="••••••" required>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label>New Password</label>
						<input class="form-control" type="password" name="password" placeholder="••••••" required>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label>Confirm <span class="d-none d-xl-inline">Password</span></label>
						<input class="form-control" type="password" name="confirm_password" placeholder="••••••" required>
					</div>
				</div>
			</div><br><br>
			<div class="row">
			  <div class="col d-flex justify-content-end">
				<button class="btn text-light escrot-btn-primary escrot-rounded" type="submit">Save Changes</button>
			  </div>
			</div><br><br>
		  </form>

		</div>
	</div>
  
</div>
			
