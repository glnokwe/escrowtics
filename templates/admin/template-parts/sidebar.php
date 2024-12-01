
        <div <?php if(ESCROT_ADMIN_NAV_STYLE == 'sidebar'){ ?> 
		      class="sidebar" 
	         <?php } else { ?>  class="sidebar d-block d-md-none" <?php } ?> 
			 data-color="azure" data-background-color="default">

	        <?php  
			    include ESCROT_PLUGIN_PATH."templates/admin/template-parts/escrot-admin-logo.php";
		        include ESCROT_PLUGIN_PATH."templates/admin/template-parts/menu-list.php";
            ?>
		
	   
	        <div class="sidebar-wrapper">
		
                <ul class="nav">
		
		            <?php  $nav_menu = '';
		  
		                    foreach($menus as $menu){ 
		
                                $nav_menu .= '
			
                                    <li class="nav-item '.$menu["li-classes"].'" id="'.$menu["li-id"].'">';
				
				                        if($menu["li-id"] == 'EscrotSettMenuItem' && ESCROT_PLUGIN_INTERACTION_MODE == "modal"){
					                        $nav_menu .= '<a class="nav-link escrot-nav-link" id="BtnSettings" data-toggle="modal" data-target="#escrot-sett-modal">';
				                        } else {
					                        $nav_menu .= '<a class="nav-link escrot-nav-link"';
					
					                        if($menu["type"] == 'drop-down'){ $nav_menu .= 'data-toggle="collapse"'; }
					
					                        $nav_menu .= 'href="'.$menu["href"].'">';
				                        }
				
				                        $nav_menu .= '
                                          <i class="fas fa-'.$menu["icon"].'"></i>
                                          <p>'. __($menu["title"], "escrowtics").'';
				                             if($menu["type"] == 'drop-down'){ $nav_menu .= '<b class="caret"></b>'; }
                                        $nav_menu .= '					 
                                          </p>
                                         </a>';
				 
			                            if($menu["type"] == 'drop-down'){ 
			                                $nav_menu .= '
                                                <div class="collapse" id="'.$menu["collapse-id"].'">
                                                    <ul class="nav">';
				  
				                                        foreach($menu['submenus'] as $submenu){ 
                                                            $nav_menu .= '
                                                                <li class="nav-item" id="'.$submenu["li-id"].'">
                                                                    <a class="nav-link escrot-nav-link"';
						
						                                                if($submenu["li-id"] == 'EscrotQuikResDB'){  
						                                                   if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ $nav_menu .= 'data-toggle="modal" data-target="#escrot-db-restore-modal"';
			                                                               } else {  $nav_menu .= 'data-toggle="collapse" data-target="#escrot-db-restore-form-dialog"'; }
						                                                } 
						 
                                                                    $nav_menu .= '
						                                              href="'.$submenu["href"].'">
                                                                        <i class="fas fa-'.$submenu["icon"].'"></i>
                                                                        <span class="sidebar-normal">'.__($submenu["title"], "escrowtics").'</span>
                                                                     </a>
                                                                </li>';
				                                        }
														
                                                $nav_menu .= '
                                                    </ul>
                                                </div>';
			                            }

                                $nav_menu .= '
								    </li>';
			
		                    } 
		
		                echo  $nav_menu;   ?>
		  
                </ul>
	        </div>
        </div>
