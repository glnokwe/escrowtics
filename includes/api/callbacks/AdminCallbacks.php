<?php

/**
 * Admin Callback class_alias
 * Defines all admin callbacks  
 * @since      1.0.0
 * @package    Escrowtics
 */
	
	namespace Escrowtics\api\callbacks;
	
	defined('ABSPATH') or die();
 
 
    class AdminCallbacks {
	
	    //General Admin Template 
	    public function adminGenTemplate() {
           return require_once ( ESCROT_PLUGIN_PATH."templates/admin/admin-template.php" );
	    }
		
		 //Settings Panel Template 
	    public function settingsTemplate() {
			if(ESCROT_PLUGIN_INTERACTION_MODE == "modal" && !wp_is_mobile()){//redirect to dashboard if setting panel mode is modal
			    echo"<script>window.location = 'admin.php?page=escrowtics-dashboard'</script>";
			} else {
		        return require_once ( ESCROT_PLUGIN_PATH."templates/admin/admin-template.php" );
			}
	    } 

   
   
    }
	
