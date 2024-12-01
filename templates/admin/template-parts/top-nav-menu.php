<?php 
	
	include ESCROT_PLUGIN_PATH."templates/admin/template-parts/menu-list.php";

	$nav_menu = '';
	
	$nav_menu .= '

		<nav class="navbar escrot-top-nav navbar-expand-lg navbar-dark bg-dark">

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				
				<ul class="navbar-nav mr-auto">';
  
					foreach($menus as $menu){ 
					
						$nav_menu .= '
							<li class="text-light nav-item escrot-top-nav-item shadow-lg';  if($menu["type"] == 'drop-down'){ $nav_menu .= ' dropdown'; } $nav_menu .= ' '.$menu["li-classes"].'" id="'.$menu["li-id"].'">
							
								<a class="nav-link escrot-nav-link ';  if($menu["type"] == 'drop-down'){ $nav_menu .= 'dropdown-toggle'; } $nav_menu .= '"';
							
									if($menu["li-id"] == 'EscrotSettMenuItem' && ESCROT_PLUGIN_INTERACTION_MODE == "modal"){
									  $nav_menu .= ' id="BtnSettings" data-toggle="modal" data-target="#escrot-sett-modal"';
									} else {
										if($menu["type"] == 'drop-down'){ 
										   $nav_menu .= ' href="#" id="'.$menu["collapse-id"].'" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
										} else { $nav_menu .= 'href="'.$menu["href"].'"'; }
									}  		
								$nav_menu .= '>    
									<i class="fa fa-'.$menu["icon"].'"></i><span>'. __($menu["title"], "escrowtics").'</span>
								</a>';
								
								if($menu["type"] == 'drop-down'){ 
									$nav_menu .= '
										<div class="dropdown-menu" aria-labelledby="'.$menu["collapse-id"].'">';
											foreach($menu['submenus'] as $submenu){
											   $nav_menu .= '													
												 <a class="dropdown-item escrot-rounded" href="'.$submenu["href"].'"';
												 
												 if($submenu["li-id"] == 'EscrotQuikResDB'){  
													if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ 
													  $nav_menu .= 'data-toggle="modal" data-target="#escrot-db-restore-modal"';
													} else {  
													   $nav_menu .= 'data-toggle="collapse" data-target="#escrot-db-restore-form-dialog"';
													}
												 } 
												 
												 $nav_menu .= '> 
													<i class="fa fa-'.$submenu["icon"].'"></i>&nbsp;'.__($submenu["title"], "escrowtics").'
												 </a>';
											}	 
									$nav_menu .= '			 
										</div>';
								}
						$nav_menu .= '
							</li>';
							
					}
					
		$nav_menu .= '		
				</ul>
			</div>
		</nav>';
		
	echo  $nav_menu;	
		




