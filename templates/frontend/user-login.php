<section class="escrot-content-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<?php 
					if(isset($_GET['endpoint']) && $_GET['endpoint'] == 'user_signup'){ 
						include ESCROT_PLUGIN_PATH."templates/forms/user-signup-form.php";
					} else {
						include ESCROT_PLUGIN_PATH."templates/forms/login-form.php"; 
					}
				?>
			</div>
		</div>
	</div>
</section>
