<?php

/**
 * Admin Callbacks
 * Defines all admin-related callbacks.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\Callbacks;

defined('ABSPATH') || exit;

class AdminCallbacks{
	
	private const ADMIN_TEMPLATE = ESCROT_PLUGIN_PATH . 'templates/admin/admin-template.php';
	
    /**
     * Load General Admin Template
     *
     * @return void
     */
    public function adminGenTemplate()
    {
        require_once self::ADMIN_TEMPLATE;
    }

    /**
     * Load Settings Panel Template
     *
     * @return void
     */
    public function settingsTemplate()
    {
        if (defined('ESCROT_INTERACTION_MODE') && ESCROT_INTERACTION_MODE === 'modal' && !wp_is_mobile()) {
            wp_safe_redirect( admin_url('admin.php?page=escrowtics-dashboard') );
			exit;
        }

        require_once self::ADMIN_TEMPLATE;
    }
}

	
