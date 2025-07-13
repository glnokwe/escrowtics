<?php

/**
 * Fired when the plugin is uninstalled.
 * @since      1.0.0
 * @package    Escrowtics
 */

	//if uninstall not called from WordPress, then exit.
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit;
	}


	function escrotDeletePlugin() {
		
		global $wpdb;

		delete_option( 'escrowtics_options' );
		
		$escrot_tbls = $wpdb->get_col("SHOW TABLES like '{$wpdb->prefix}escrowtics%'");
		
		foreach ($escrot_tbls as $table) {
			$wpdb->query( "DROP TABLE IF EXISTS ".$table );
		}
	}

	if ( ! defined( 'ESCROT_VERSION' ) ) {
		escrotDeletePlugin();
	}

