<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
   
	<div class="container-fluid">
		<div class="navbar-wrapper">
		
			<?php if(ESCROT_ADMIN_NAV_STYLE == 'sidebar') { ?>
			<div class="navbar-minimize">
				<button id="minimizeSidebar" class="btn btn-just-icon bg-transparent btn-fab btn-round" title="Toggle Menu">
					<i class="text-light fa fa-maximize escrot-nav-icon text_align-center visible-on-sidebar-regular"></i>
					<i class="text-light fa fa-minimize escrot-nav-icon design_bullet-list-67 visible-on-sidebar-mini"></i>
				</button>
			</div>
			<?php } else { ?>
				<div class="p-2 pl-3 pr-3 mr-5 border rounded-pill border-primary d-none d-md-block">
					<?php include ESCROT_PLUGIN_PATH."templates/admin/template-parts/escrot-admin-logo.php"; ?>
				</div>
			<?php } ?>
		
			<!-- Breadcrumps -->
			<?php  include ESCROT_PLUGIN_PATH."templates/admin/template-parts/navbar-breadcrumps.php"; ?>
	

			<!--- Mobile Top Header ---->
			<div class="justify-content-end mobile-top d-block d-lg-none">
				<?php if(ESCROT_THEME_CLASS == "dark-edition"){ ?>
					<a href="#" class="toggle-theme" title="Toggle Light/Dark Mode" id="ToggleLightModeMbl">  
						 <?= escrot_light_svg(); ?> 
					</a>
			   <?php } else { ?>
					<a href="#" class="toggle-theme" title="Toggle Light/Dark Mode" id="ToggleDarkModeMbl">
						 <i class="fa fa-moon escrot-nav-icon text-light fixed-plugin-button-nav"></i> 
					</a>
				<?php } ?>
				<div class="escrot-view-notif">
					<a class="notify-mobile" href="#" id="ShowMnoty" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<i class="text-light fa fa-bell escrot-nav-icon"></i>
						<span style="background: transparent; border: none !important;" class="notification"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-left notif-content" aria-labelledby="ShowMnoty"> </div>
				</div>
			</div>
			<!--- Mobile Top Header End---->	  
		  
		</div>
	  
		<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon icon-bar text-light"></span>
			<span class="navbar-toggler-icon icon-bar text-light"></span>
			<span class="navbar-toggler-icon icon-bar text-light"></span>
		</button>
		
		
		
		<div class="collapse navbar-collapse justify-content-end">
		
		   <div class="ms-md-auto pe-md-3 d-flex align-items-center"><!--- Order Search --->
				<?php include ESCROT_PLUGIN_PATH."templates/forms/escrow-search-form.php";  ?>  
			 </div>
			
			
			<ul class="navbar-nav">
			
			   <li class="nav-item ps-3 d-flex align-items-center">
			   <?php if(ESCROT_THEME_CLASS == "dark-edition"){ ?>
					<a href="#" title="Toggle Light/Dark Mode" class="nav-link text-body p-0" id="ToggleLightMode">
						  <?= escrot_light_svg(); ?>
					</a>
			   <?php } else { ?>
					<a href="#" title="Toggle Light/Dark Mode" class="nav-link text-body p-0" id="ToggleDarkMode">
						 <i class="fa fa-moon escrot-nav-icon text-light fixed-plugin-button-nav"></i> 
					</a>
				<?php } ?>					
				</li>
			
			  <li class="nav-item px-3">
					<?php if(ESCROT_PLUGIN_INTERACTION_MODE == "modal") { ?>
						<a href="javascript:;" data-toggle="modal" data-target="#escrot-sett-modal" 
						class="nav-link text-body p-0">
					<?php } else { ?>
						  <a href="admin.php?page=escrowtics-settings" class="nav-link text-body p-0">
					<?php } ?>
						<i class="text-light fa fa-screwdriver-wrench escrot-nav-icon"></i>
					</a>
				</li> 
				
				<li class="nav-item px-3 dropdown escrot-view-notif">
					<a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" 
					aria-haspopup="true" aria-expanded="true">
						<i class="text-light fa fa-bell escrot-nav-icon"></i>
						<span style="background: transparent; border: none !important;" class="notification"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right notif-content" aria-labelledby="navbarDropdownMenuLink"> </div>
				</li>
			  
			</ul>
		</div>
	  
	</div>
	
</nav>
  
   