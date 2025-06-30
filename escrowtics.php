<?php

/*
 * Plugin Name: Escrowtics
 * Plugin URI: #
 * Description: Safe Peer-to-Peer Escrow Payment Wordpress Plugin.
 * Author: Godlove Nokwe
 * Author URI: #
 * Text Domain: escrowtics
 * Domain Path: /languages
 * Version: 1.0.0
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

defined('ABSPATH') or die(); 


//Include Composer Autoload
if(file_exists(dirname( __FILE__ ).'/vendor/autoload.php')){
	require_once dirname( __FILE__ ).'/vendor/autoload.php';
}

	
//Define General plugin constants
defined('ESCROT_TEXTDOMAIN') || define('ESCROT_TEXTDOMAIN', 'escrowtics');
defined('ESCROT_PLUGIN_NAME') || define('ESCROT_PLUGIN_NAME', 'escrowtics');
defined('ESCROT_VERSION') || define('ESCROT_VERSION', '1.0.0');
defined('ESCROT_PLUGIN_URL') || define('ESCROT_PLUGIN_URL', plugin_dir_url(__FILE__));
defined('ESCROT_PLUGIN_PATH') || define('ESCROT_PLUGIN_PATH', plugin_dir_path(__FILE__));
defined('ESCROT_PLUGIN_SLUG_PATH') || define('ESCROT_PLUGIN_SLUG_PATH', plugin_basename(__FILE__));
 


// Register Activation & Deactivation Hooks
if (class_exists('Escrowtics\\base\\Activator')) {
    register_activation_hook(__FILE__, ['Escrowtics\\base\\Activator', 'activate']);
} 

if (class_exists('Escrowtics\\base\\Deactivator')) {
    register_deactivation_hook(__FILE__, ['Escrowtics\\base\\Deactivator', 'deactivate']);
} 

//Register all Services & Start the plugin 
if(class_exists('Escrowtics\\EscrotInit')){
  Escrowtics\EscrotInit::register_services();
}
