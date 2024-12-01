<div class="pt-5 escrot-rounded e-profile">
    <form id="escrot-edit-user-form" class="form" enctype="multipart/form-data">
		<div style="color: red;" id="escrot_user_error"></div>
		<div class="row">
			<div class="col-12 col-sm-auto mb-3">
				<div class="mx-auto" style="width: 140px;">
					<div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
					   <?php echo escrot_image($user_data["user_image"], 100, "rounded-circle"); ?>
					</div>
				</div>
			</div>
			<div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
				<div class="text-center text-sm-left mb-2 mb-sm-0">
					<h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php $user_data["firstname"].' '.$user_data["lastname"]; ?></h4>
					<p class="mb-0">@<?php echo $user_data["username"]; ?></p>

					<div class="mt-2">
						<div class="fileinput fileinput-new text-center" data-provides="fileinput">
							<div class="fileinput-new thumbnail img-circle"></div>
							<div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
							<div>
								<span class="btn btn-round btn-primary btn-file btn-sm">
									<span class="fileinput-new"><i class="fa fa-fw fa-camera"></i>Update User Image</span>
									<span class="fileinput-exists"><i class="fa fa-fw fa-camera"></i>Change Image</span>
									<input type="file" name="file" accept="image/jpg,image/jpeg,image/png,image/webp"/>
								</span><br>
								<a href="javascript:;" class="btn btn-danger btn-round fileinput-exists btn-sm" data-dismiss="fileinput">
								<i class="fa fa-times"></i> Remove</a>
							</div>
						</div>
					</div>
				</div>
			  
				<div class="text-center text-sm-right">
					<span class="badge badge-secondary">User</span>
					<div class="text-muted"><small>Added: <?php echo $user_data["creation_date"]; ?></small></div>
				</div>
			</div>
		</div>

		<br><br>
		<div class="tab-content pt-3">
			<div class="tab-pane active">
				<input type="hidden" name="action" value="escrot_update_user">
				<?php wp_nonce_field('escrot_user_nonce', 'nonce'); ?>
				<div class="row">
					
					<div class="col-md-4">
						<div class="form-group">
							<label><b>Username</b> (Can't change)</label>
							<input class="disabled form-control" type="text" name="username" placeholder="Enter Phone No."
							value="<?php echo $user_data["username"]; ?>" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><b>First Name</b></label>
							<input class="form-control" type="text" name="firstname" placeholder="John Smith" 
							value="<?php echo $user_data["firstname"]; ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><b>Last Name</b></label>
							<input class="form-control" type="text" name="lastname" placeholder="Enter Last Name"
							value="<?php echo $user_data["lastname"]; ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><b>Email</b></label>
							<input class="form-control" type="text" name="email" placeholder="Enter Email" 
							value="<?php echo $user_data["email"]; ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><b>Phone</b></label>
							<input class="form-control" type="text" name="phone" placeholder="Enter Phone No."
							value="<?php echo $user_data["phone"]; ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						  <label><b>Country</b></label>
						  <select class="form-control" name="country">
						  <?php
								foreach (escrot_countries() as $option => $title) {
									echo "<option value='".$option."' ".($option == $user_data["country"]? 'selected' : '').">".$title."</option>";
								}
						   ?>
						  </select>
						</div>
					</div>
					<br>
					<div class="col-md-6">
						<div class="form-group">
							<label><b>Company</b></label>
							<input class="form-control" type="text" name="company" placeholder="Enter Company" 
							value="<?php echo $user_data["company"]; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><b>Company Website</b></label>
							<input class="form-control" type="text" placeholder="Enter Website" name="website" value="<?php echo $user_data["website"]; ?>">
						</div>
					 </div>
					
					<br>
					
					<div class="col-md-12">
						<div class="form-group">
							<label><b>Address</b></label>
							<input class="form-control" type="text" name="address" placeholder="Enter Address" 
							value="<?php echo $user_data["address"]; ?>">
						</div>
					</div>
					
					<br>
					<div class="col-md-12 mb-3">
						<div class="form-group">
						  <label><b>Company Bio</b></label>
						  <textarea class="form-control" name="bio" rows="5" placeholder="Enter Company Bio"><?php echo $user_data["bio"]; ?></textarea>
						</div>
					</div>
						
				</div>
				<br><br>
				<div class="col d-flex justify-content-end">
					<button class="btn text-light escrot-btn-primary escrot-rounded" type="submit">Save Changes</button>
				</div>
				<br><br>
			</div>
		</div>
	</form>
</div>
			
