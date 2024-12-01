<div class="escrot-main-panel" id="escrot-front-wrapper">
	<?php
		echo escrot_ajax_loader('working..');
	
		if(is_user_logged_in()){
			if(is_escrot_front_user()){
				include ESCROT_PLUGIN_PATH."templates/frontend/user-profile.php";
			
				if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { 
				   include_once ESCROT_PLUGIN_PATH."templates/frontend/front-modals.php"; 
				}	
			} else { 
				include ESCROT_PLUGIN_PATH."templates/frontend/user-login.php"; 
			}				
		} else { 
			include ESCROT_PLUGIN_PATH."templates/frontend/user-login.php"; 
		}
	?>
</div>
