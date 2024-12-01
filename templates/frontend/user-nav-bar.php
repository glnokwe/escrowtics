<?php 
    
$active_class = [];
foreach($endpoints as $endpoint) {
	if($escrot_endpoint && $_GET['endpoint'] == $endpoint){
		$active_class[$endpoint] = ' active show';
	} else {
		$active_class[$endpoint] = '';
	}
}

function escrot_front_menu_manager($menus){
	$nav_menu = '';	
	foreach($menus as $menu){ 
		$nav_menu .= '
			<li class="nav-item';  
			if($menu["type"] == 'drop-down'){ 
				$nav_menu .= ' dropdown'; 
			} 
			$nav_menu .= $menu["li-classes"].'" id="'.$menu["li-id"].'">
				<a class="nav-link '.$menu["active_classes"];  
					if($menu["type"] == 'drop-down'){ 
					   $nav_menu .= 'dropdown-toggle"';
					   $nav_menu .= ' href="#" id="'.$menu["collapse-id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
					} else { $nav_menu .= '"  href="'.$menu["href"].'"'; }
					$nav_menu .= '> <i class="escrot-nav-icon fas fa-'.$menu["icon"].'"></i>&nbsp;'.$menu["title"].'
				</a>';
				if($menu["type"] == 'drop-down'){ 
					$nav_menu .= '
						<div class="dropdown-menu dropdown-menu-right rounded p-2"  
						aria-labelledby="'.$menu["collapse-id"].'">';
							foreach($menu['submenus'] as $submenu){
							   $nav_menu .= '													
								<a id="'.$submenu["li-id"].'" class="dropdown-item escrot-rounded" 
								   href="'.$submenu["href"].'"';
									if($submenu["li-id"] == 'EscrotAddTicketsFrontNavItem'){  
										if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ 
										  $nav_menu .= 'data-toggle="modal" data-target="#escrot-add-ticket-modal"';
										} else {  
										   $nav_menu .= 'data-toggle="collapse" data-target="#escrot-add-ticket-form-dialog"';
										}
									} 
									$nav_menu .= '> 
										<i class="escrot-nav-icon fas fa-'.$submenu["icon"].'"></i>
										&nbsp;'.$submenu["title"].'
								</a>'; 
								if($submenu['li-id'] !== end($menu['submenus'])['li-id']){
									$nav_menu .='<div class="dropdown-divider"></div>'; 
								}
							}	 
						$nav_menu .= '</div>';
				}
		$nav_menu .= '</li>';
	}		
	echo $nav_menu;	
}

include ESCROT_PLUGIN_PATH."templates/frontend/front-menu-list.php";

?>
<div class="card-nav-tabs">
	<div class="escrot-user-nav escrot-bg-primary escrot-rounded-top">
		<div class="nav-tabs-navigation">
			<div class="nav-tabs-wrapper row">
				<div class="d-sm-flex col-md-9">
					<ul class="nav nav-tabs d-sm-flex align-items-center justify-content-between" data-tabs="tabs">
					<?php escrot_front_menu_manager($main_menu); ?>
					</ul>
				</div>
				<div class="col-md-3">
					<ul class="nav nav-tabs float-right">
						<li class="nav-item dropdown escrot-view-notif pt-2">
							<a class="nav-link" href="javascript:;" id="escrot-front-user-noty" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-endpoint-url="<?= $routes['view_ticket']; ?>">
								<i class="text-light fa fa-bell escrot-nav-icon"></i>
								<span style="background: transparent; border: none !important;" class="notification"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right notif-content rounded" aria-labelledby="escrot-front-user-noty"></div>
						</li>
						<?php escrot_front_menu_manager($profile_menu); ?>
					</ul>
					
				</div>
				
			</div>
		</div>
	</div>
	
</div>

<hr/>