<?php

/**
 * The Shortcode manager class of the plugin.
 * DEfines all plugin Shortcodes.
 * @since      1.0.0
 * @package  Escrowtics
 */
 
    namespace Escrowtics\base;
	
	defined('ABSPATH') or die();
 
    class Shortcodes {
	
	    public function register() {
			add_shortcode( 'escrot_account', array($this, 'escrotAccount' ));
	    }
		
		
		public function escrotAccount(){
		    ob_start();
		    include ESCROT_PLUGIN_PATH."templates/frontend/account.php";
		    return ob_get_clean();
        }
	
    }
	
	
	
	
