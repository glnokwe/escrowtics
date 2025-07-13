<?php

/**
 * Add plugin action Links on the installed plugins page
 * @since      1.0.0
 * @package    Escrowtics
 */
	
    namespace Escrowtics;
	
	defined('ABSPATH') || exit;
 
    class AdminPluginLinks {

	    public function register() {
            //Register hooks 
		    add_filter( 'plugin_action_links',   array($this, 'pluginActionLinks'), 10, 2);
	    }
  
   	    
		//Add the Links
	    public function pluginActionLinks( $links, $plugin) {
		
		    if ( $plugin == ESCROT_PLUGIN_SLUG_PATH ) {

			    $links['dashboard'] = '<a href="admin.php?page=escrowtics-dashboard">Dashboard</a>';
				$links['settings'] = '<a href="admin.php?page=escrowtics-settings">Settings</a>';
		    }

		    return $links;
	    }
	
    }
	
	
	
	
