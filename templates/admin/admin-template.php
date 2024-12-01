<?php

/**
* Admin area template for the plugin
* @since      1.0.0
*/

defined('ABSPATH') or die();  // Exit if accessed directly.

include_once ESCROT_PLUGIN_PATH."templates/admin/template-parts/header.php"; //Header
include_once ESCROT_PLUGIN_PATH."templates/admin/template-parts/sidebar.php"; //Sidebar

?>

<div class="main-panel escrot-main-panel">

	<?php //Navbar
		include_once ESCROT_PLUGIN_PATH."templates/admin/template-parts/navbar.php"; 
		if(ESCROT_ADMIN_NAV_STYLE == 'no-menu' ){ echo'<div class="mt-5"></div>'; }
		if(ESCROT_ADMIN_NAV_STYLE == 'top-menu' && !wp_is_mobile()){
			include_once ESCROT_PLUGIN_PATH."templates/admin/template-parts/top-nav-menu.php";
		}
	?>
   
	<div class="content">
		<?php echo escrot_ajax_loader(); ?>
		<div class="container-fluid">
  
			<?php //Content Area Start
				if($_GET['page'] == "escrowtics-dashboard"){
				   include_once ESCROT_PLUGIN_PATH."templates/admin/dashboard/dashboard.php"; 
				} elseif($_GET['page'] == "escrowtics-view-escrow") {
					include_once  ESCROT_PLUGIN_PATH."templates/escrows/view-escrow.php"; 
				} elseif($_GET['page'] == "escrowtics-view-ticket") {
					include_once  ESCROT_PLUGIN_PATH."templates/support/view-ticket.php"; 
				} elseif($_GET['page'] == "escrowtics-stats") {
				   include_once ESCROT_PLUGIN_PATH."templates/admin/stats/stats.php";  
				} elseif($_GET['page'] == "escrowtics-settings") {
					include_once ( ESCROT_PLUGIN_PATH."templates/admin/template-parts/settings-panel.php" );
				}  else {
					if(isset($_GET['user_id'])){ ?>
						<div id="escrot-profile-container"><?php echo escrot_loader(__("Loading..", "escrowtics")); ?></div>
					<?php }  else { ?>
					   <div id="escrot-admin-container"><?php echo escrot_loader(__("Loading..", "escrowtics")); ?></div>
					<?php }
				}//Content Area End
			?>
		</div>
	</div>

	<?php 
		include_once ESCROT_PLUGIN_PATH."templates/admin/template-parts/footer.php"; 
		if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { 
		   include_once ESCROT_PLUGIN_PATH."templates/admin/template-parts/modals.php"; 
		} 
		if (isset($IsStatsPage) && $IsStatsPage) {
			include_once ESCROT_PLUGIN_PATH."templates/admin/stats/charts.php";
		}
	?>

</div>

</div><!-- bodyWrapper end -->	

