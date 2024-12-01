<?php

/**
 * Fired during plugin activation.
 * Defines all code necessary to run during the plugin's activation.
 * @since      1.0.0
 * @package    Escrowtics
 */
	
	namespace Escrowtics\base;
	
	defined('ABSPATH') or die();
 
 
    class Activator {
	 
		public static function activate() {
			
			// Check PHP version compatibility
			$required_php_version = '7.4.0';
			if (version_compare(PHP_VERSION, $required_php_version, '<')) {
				add_action('admin_notices', function() use ($required_php_version) {
					echo '<div class="notice notice-error"><p>';
					printf(
						__('This plugin requires PHP version %s or higher. Please update your PHP version.', 'escrowtics'),
						$required_php_version
					);
					echo '</p></div>';
				});
			}
			
			//Create necessary database tables (example action usage)
			do_action('escrot_db_migration');

			// Securely add a custom role
			if (!get_role('escrowtics_user')) {
				add_role('escrowtics_user', 'Escrowtics User', get_role('subscriber')->capabilities);
			}

			// Check if the options are already set
			if (get_option('escrowtics_options')) {
				return;
			}

			// Securely load and validate default options
			$file_path = ESCROT_PLUGIN_PATH . "includes/base/default-options.json";
			if (!file_exists($file_path)) {
				wp_die(__('Default options file not found during activation.', 'escrowtics'));
			}

			$file_contents = file_get_contents($file_path);
			$options = json_decode($file_contents, true);

			if (json_last_error() !== JSON_ERROR_NONE || !is_array($options)) {
				wp_die(__('Invalid JSON in default options file.', 'escrowtics'));
			}

			// Validate and sanitize options
			$allowed_keys = ['plugin_interaction_mode','access_role','currency','timezone','company_logo','logo_width',			  
			 'logo_height','company_address','company_phone','escrow_form_style','refid_length','refid_xter_type','dbackup_log',  
			 'auto_dbackup','auto_db_freq','company_email','user_new_escrow_email','user_new_milestone_email',  
			 'admin_new_escrow_email','admin_new_milestone_email','user_new_escrow_email_subject','user_new_escrow_email_body',  
			 'user_new_escrow_email_footer','user_new_milestone_email_subject','user_new_milestone_email_body',  
			 'user_new_milestone_email_footer','admin_new_escrow_email_subject','admin_new_escrow_email_body',  
			 'admin_new_escrow_email_footer','admin_new_milestone_email_subject','admin_new_milestone_email_body',  
			 'admin_new_milestone_email_footer','smtp_protocol','smtp_host','smtp_user','smtp_pass','smtp_port','theme_class',  
			 'admin_nav_style','fold_wp_menu','fold_escrot_menu','primary_color','secondary_color','custom_css',  
			 'escrow_detail_label','withdraw_history_table_label','escrow_table_label','earning_table_label','log_table_label',  
			 'earning_list_label','escrow_list_label','login_form_label','signup_form_label','deposit_history_table_label',  
			 'enable_bitcoin_payment','blockonomics_api_key','blockonomics_endpoint_url','enable_paypal_payment','paypal_email',  
			 'enable_rest_api','enable_rest_api_key','rest_api_key','rest_api_enpoint_url','rest_api_data'];
			$sanitized_options = array_intersect_key($options, array_flip($allowed_keys));

			// Update the options in the database
			update_option('escrowtics_options', $sanitized_options);
			
		}


}
