<?php

/**
 * Define the internationalization functionality
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 * @since      1.0.0
 * @package    Escrowtics
 */
	
	namespace Escrowtics\Base;
	
	defined('ABSPATH') || exit;
	
	
    class I18n {


        public function register() {
           //Register hooks 
	       add_action( 'init',  array( $this, 'loadTextDomain') );
	    }
		

        //Load the plugin text domain for translation.
	    public function loadTextDomain() {
		    load_plugin_textdomain('escrowtics', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/');
	    }
		
	
	}    




