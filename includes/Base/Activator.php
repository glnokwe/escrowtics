<?php

/**
 * Fired during plugin activation.
 * Handles all tasks necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Base;

defined('ABSPATH') || exit;

class Activator {

    /**
     * Fired during plugin activation.
     *
     * @return void
     */
    
	public static function activate() {
		self::checkPhpVersion();
        self::createCustomRoles();
		do_action('escrot_db_migration');
	    !get_option('escrowtics_options') && do_action('escrot_default_options');
    }
	
	
	public static function checkPhpVersion() {
        // Check PHP version compatibility
        $required_php_version = '7.4.0';
        if (version_compare(PHP_VERSION, $required_php_version, '<')) {
            add_action('admin_notices', function () use ($required_php_version) {
                printf(
                    '<div class="notice notice-error"><p>%s</p></div>',
                    esc_html__(
                        "Escrowtics requires PHP version {$required_php_version} or higher. Please update your PHP version.",
                        'escrowtics'
                    )
                );
            });

            // Exit to prevent activation if PHP version is incompatible
            deactivate_plugins(plugin_basename(__FILE__));
            return;
        }
	 }	


    private static function createCustomRoles() {
        // Add custom roles
        if (!get_role('escrowtics_user')) {
            add_role('escrowtics_user', 'Escrowtics User', get_role('subscriber')->capabilities);
        }
    }
	
	
}
