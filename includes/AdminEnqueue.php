<?php

/**
 * Handles admin-specific styles and scripts for Escrowtics.
 *
 * @package Escrowtics
 * @since   1.0.0
 */

namespace Escrowtics;

defined('ABSPATH') || exit;

/**
 * Class AdminEnqueue
 */
class AdminEnqueue {

    /**
     * Registers hooks for enqueueing styles and scripts.
     */
    public function register() {
        add_action('admin_enqueue_scripts', [$this, 'enqueueStyles']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Checks if the current page matches any of the specified pages.
     *
     * @param array|string $pages Page slug(s) to check.
     * @return bool True if the current page matches, false otherwise.
     */
    private function isEscrotUniquePage($pages) {
        if (!isset($_GET['page'])) {
            return false;
        }

        $currentPage = sanitize_text_field($_GET['page']);
        if (is_array($pages)) {
            return in_array($currentPage, $pages, true);
        }

        return $currentPage === $pages;
    }
	
	
	/**
	 * Check if the current URL is an Escrowtics page.
	 *
	 * @param string $page The page identifier to check.
	 * @return bool True if the current URL matches the specified page, otherwise false.
	 */
	public function isEscrotPage($page) {
		if (isset($_GET['page'])) {
			$current_page = sanitize_text_field($_GET['page']);
			$url_array = explode('-', $current_page);

			return in_array($page, $url_array, true);
		}

		return false;
	}


    /**
     * Enqueues styles for admin pages.
     */
    public function enqueueStyles() {
        // Styles for all Escrowtics admin pages.
        if ($this->isEscrotPage('escrowtics')) {
            $styles = [
                'escrot-mdb-admin-css'     => 'lib/bootstrap/css/m-dash.min.css',
                'escrot-choices-admin-css' => 'lib/bootstrap/css/choices.min.css',
                'escrot-chat-admin-css'    => 'assets/css/escrot-chat.css',
                'escrot-fa-admin-css'      => 'lib/fontawesome/css/all.min.css',
                'escrot-datatb-admin-css'  => 'lib/jquery/css/jquery.dataTables.min.css',
                'escrot-admin-css'         => 'assets/css/escrot-admin.css',
            ];

            foreach ($styles as $handle => $path) {
                wp_enqueue_style($handle, ESCROT_PLUGIN_URL . $path, [], ESCROT_VERSION);
            }

            // Add inline CSS (escrowtics top navigation, hide wp components).
            wp_add_inline_style('escrot-admin-css', $this->getInlineAdminCss());
        }

        // General WordPress admin styles for all pages.
        wp_enqueue_style('escrot-wp-admin', ESCROT_PLUGIN_URL . 'assets/css/escrot-wp-admin-styles.css', [], ESCROT_VERSION);
    }

    /**
     * Enqueues scripts for admin pages.
     */
    public function enqueueScripts() {
        // Shared scripts for all Escrowtics admin pages.
        if ($this->isEscrotPage('escrowtics')) {// Load scripts only if Escrowtics admin area
            $sharedScripts = [
                'jquery',
                'jquery-form',
                'media-upload',
                'escrot-popper-js'    => 'lib/jquery/js/popper.min.js',
                'escrot-bootstrap-js' => 'lib/bootstrap/js/m-design.min.js',
                'escrot-choices-js'   => 'lib/bootstrap/js/choices.min.js',
                'escrot-swal-js'      => 'lib/jquery/js/sweetalert2.min.js',
                'escrot-noty-js'      => 'assets/js/notification-script.js',
                'escrot-settings-js'  => 'assets/js/settings-script.js',
                'escrot-jasny-js'     => 'lib/bootstrap/js/jasny-bootstrap.min.js',
                'escrot-wizard-js'    => 'lib/bootstrap/js/jquery.bootstrap-wizard.js',
                'escrot-bs-colpkr-js' => 'lib/bootstrap/js/bootstrap-colorpicker.min.js',
				'escrot-datatables-js'=> 'lib/jquery/js/jquery.dataTables.min.js',
				'escrot-escrow-js'    => 'assets/js/escrow-script.js',
				'escrot-fxns-js'      => 'assets/js/escrot-functions.js',
				'escrot-admin-js'     => 'assets/js/escrot-admin.js'
            ];
			

            foreach ($sharedScripts as $handle => $path) {
                if (is_int($handle)) {
                    wp_enqueue_script($path);
                } else {
                    wp_enqueue_script($handle, ESCROT_PLUGIN_URL . $path, ['jquery'], ESCROT_VERSION, true);
                }
            }
			
			// Load WP media scripts
			wp_enqueue_media();

			// Page-specific scripts with multiple page support.
			$pageScripts = [
				['pages' => ['escrowtics-users', 'escrowtics-user-profile'], 'scripts' => [
					'escrot-user-js' => 'assets/js/users-script.js',
				]],
				['pages' => ['escrowtics-disputes', 'escrowtics-view-dispute'], 'scripts' => [
					'escrot-sup-js' => 'assets/js/dispute-script.js',
				]],
				['pages' => ['escrowtics-db-backups'], 'scripts' => [
					'escrot-db-backup-js' => 'assets/js/db-backup-script.js',
				]],
				['pages' => ['escrowtics-dashboard', 'escrowtics-stats', 'escrowtics-user-profile'], 'scripts' => [
					'canvas-js' => 'lib/jquery/js/canvasjs.min.js',
				]],
			];

			foreach ($pageScripts as $group) {
				if ($this->isEscrotUniquePage($group['pages'])) {
					foreach ($group['scripts'] as $handle => $path) {
						wp_enqueue_script($handle, ESCROT_PLUGIN_URL . $path, ['jquery'], ESCROT_VERSION, true);
					}
				}
			}

			//localize
			$this->LocalizeScripts();
			
		}	
    }

    /**
     * Returns custom inline CSS
     *
     * @return string CSS styles.
     */
	private function getInlineAdminCss() : string {
		// Read each toggle only once
		$hideBar    = (bool) escrot_option('hide_wp_admin_bar');
		$hideMenu   = (bool) escrot_option('hide_wp_menu');
		$hideFooter = (bool) escrot_option('hide_wp_footer');
		$topNav     = escrot_option('admin_nav_style') === 'top-menu';

		$blocks = [];

		// 1) Hide WP Admin Bar
		if ($hideBar) {
			$blocks[] = <<<'CSS'
					#wpadminbar { display: none !important; }
					#wpcontent, #wpcontent .wrap { margin-top: -2% !important; }
					@media (min-width: 1920px) {
					  #wpcontent, #wpcontent .wrap { margin-top: -1.2% !important; }
					}
					CSS;
		}

		// 2) Hide WP Menu
		if ($hideMenu) {
				$blocks[] = <<<'CSS'
						#adminmenu, #adminmenuback, #adminmenuwrap { display: none !important; }
						#wpcontent, #wpfooter { margin-left: -1.2% !important; }
						.col-md-4 .toggleOn { margin: -0.5% 14% 0 6% !important; }
						CSS;
		}

		// 3) Plugin Sidebar top offset based on bar/menu
		if ($hideBar) {
			$blocks[] = '.folded .sidebar, .sidebar { top: 0; }';
		} elseif ($hideMenu) {
			$blocks[] = '.folded .sidebar, .sidebar { top: 2.6%; }';
		}

		// 4) Top-menu styling
		if ($topNav) {
			$blocks[] = <<<'CSS'
				@media (min-width: 991px) {
				  .main-panel { width: 100% !important; }
				}
				.main-panel > .content { margin-top: 10px; }
				.dark-edition .escrot-top-nav-item:hover { color: #fff !important; }
				.navbar.bg-dark .escrot-top-nav-item .active {
				  color: #2271b1 !important;
				  border: 1px solid #2271b1 !important;
				  margin-left: 0 !important;
				  border-radius: 0 !important;
				}
				.navbar.bg-dark .escrot-top-nav-item .active .fa { color: #2271b1 !important; }
				.dark-edition .navbar.bg-dark .escrot-top-nav-item .active {
				  background-color: #223663;
				  color: #fff !important;
				  border: 1px solid #fff !important;
				}
				.dark-edition .navbar.bg-dark .escrot-top-nav-item .active .fa { color: #fff !important; }
				#screen-options-wrap { width: 100% !important; }
				.navbar .collapse .navbar-nav .nav-item .nav-link { font-size: .78rem; }
				.footer { left: -0.5%; }
				@media (min-width: 1920px) {
				  #navbarSupportedContent { padding-left: 6.5% !important; }
				  .navbar.navbar-transparent { left: 0; }
				}
				CSS;
		}

		// 5) Hide WP Footer
		if ($hideFooter) {
			$blocks[] = <<<'CSS'
				#wpfooter { display: none !important; }
				.footer { margin-bottom: -30px; }
				CSS;
		}

		// Join all blocks into one CSS string
		return implode("\n\n", $blocks);
	}

	
	
	// Localize script parameters for general admin use.
	 private function LocalizeScripts() {
		   $add_dispute_confirm = escrot_option('dispute_fees') === 'no_fee'
			   ? __("Add for free. Cancel if not sure!", "escrowtics")
			   : (escrot_option('dispute_fees') === 'fixed_fee'
					? sprintf(
						__("This dispute will cost the complainant %s. Cancel if not sure", "escrowtics"), escrot_option('currency').escrot_option('dispute_fee_amount')
					) 
					: sprintf(
						__("This dispute will cost the complainant %s of the escrow amount. Cancel if not sure", "escrowtics"), escrot_option('dispute_fee_percentage').'%'
					) 
				  );
			$params = [
				'ajaxurl'                    => admin_url('admin-ajax.php'),
				'is_front_user'              => escrot_is_front_user() ? true : false,
				'light_svg'                  => escrot_light_svg(),
				'rest_api_data'              => escrot_option('rest_api_data'),
				'dispute_evidence_file_types'=> escrot_option('dispute_evidence_file_types'),
				'wpfold'                     => escrot_option('fold_wp_menu'),
				'checkUsersMessage'          => esc_html__('Payer and Earner cannot be the same user. Go back!', 'escrowtics'),
				'home_url'                   => home_url(),
				'interaction_mode'           => ESCROT_INTERACTION_MODE,
				'dbbackup_log_state'         => escrot_option('dbackup_log'),
				'swal'  =>[
				
					'success' => [
						'delete_success' => __('deleted successfully', 'escrowtics'),
						'export_excel_success' => __('Excel Sheet Generated Successfully', 'escrowtics'),
						'checkbox_select_title' => __('Selected', 'escrowtics'),
						'save_sett_success' => __('Settings updated successfully', 'escrowtics'),
						'checkbox_on_text' => __('ON', 'escrowtics'),
						'checkbox_off_text' => __('OFF', 'escrowtics'),
					 ],	
					 'warning' => [
						'title' => __('Are you sure?', 'escrowtics'),
						'text' => __('Cancel if you are not sure!', 'escrowtics'),
						'export_excel_title' => __('Export to Excel?', 'escrowtics'),
						'export_excel_text' => __('An Excel Sheet of your table will be created', 'escrowtics'),
						'export_excel_confirm' => __('Yes, export excel', 'escrowtics'),
						'error_title' => __('Error!', 'escrowtics'),
						'datatable_no_data_text' => __('No data available', 'escrowtics'),	
						'no_records_title' => __('No Record Selected', 'escrowtics'),	
						'no_records_text' => __('Please, select at least 1 record to continue', 'escrowtics'),
						'db_restore_text' => __('Make sure you have a backup copy of the current database before proceeding', 'escrowtics'),
						'db_file_restore_text' => __('Please make sure you choose the right file (use only backup files that were generated here), restoring a wrong file or interrupting the restore process will completely break things and lead to complete lost of data. Please note that already existing database tables will be destroyed. Cancel if you are not sure', 'escrowtics'),
						'delete_records_confirm' => __('Yes, delete records', 'escrowtics'),
						'delete_record_confirm' => __('Yes, delete record', 'escrowtics'),
						'form_error_text' => __('Please fix the errors in the form first', 'escrowtics'),
						'reset_sett_confirm' => __('Yes, restore default settings', 'escrowtics'),
						'import_sett_confirm' => __('Yes, import settings', 'escrowtics'),
						'import_sett_loader_text' => __('Importing Options..Please Wait!', 'escrowtics'),
						'save_sett_loader_text' => __('Saving...Please Wait!', 'escrowtics'),
						'import_sett_text' => __("Please make sure you choose the right file (use only export files that were generated here). Importing a wrong file will lead to complete loss of data. Cancel if you're not sure", 'escrowtics'),
					 ],
					 'escrow' => [
						'reject_confirm' => __('Yes, reject this amount', 'escrowtics'),
						'release_confirm' => __('Yes, release payment', 'escrowtics'),
						'add_escrow_confirm' => __('Yes, add escrow', 'escrowtics'),
						'add_milestone_confirm' => __('Yes, add milestone', 'escrowtics'),
						'delete_confirm' => __('Yes, delete', 'escrowtics'),
						'invoice_status_confirm' => __('Yes, update invoice', 'escrowtics'),
						'table_reload_success' => __('Table Reloaded successfully', 'escrowtics'),
						'form_error' => __('Please fix the errors in the form first (User does not exist )', 'escrowtics')
					 ],
					 'user' => [
						'user_not_found' => __('is not a valid user, user not found!!', 'escrowtics'),
						'email_already_exist' => __('User with the provided email already exists', 'escrowtics'),
						'user_already_exist' => __('User with the provided username already exists', 'escrowtics'),
						'add_user_confirm' => __('Yes, add user', 'escrowtics'),
						'delete_user_confirm' => __('Yes, delete User', 'escrowtics'),
						'delete_user_text' => __("You won't be able to revert this! All data linked to this User(s) (escrows, notifications..etc) will also be deleted. Do you still want to continue?", 'escrowtics'),
						'update_confirm' => __('Yes, update user', 'escrowtics'),
						'user_singular' => __('user', 'escrowtics'),
						'user_singular_deleted' => __('user deleted', 'escrowtics'),
						'user_plural' => __('users', 'escrowtics'),
						'user_plural_deleted' => __('users deleted', 'escrowtics')
					 ],
					 'dbbackup' => [
						'restore_confirm' => __('Yes, restore database', 'escrowtics'),
						'restore_init_text' => __('Initializing Restore...', 'escrowtics'),
						'restore_fail_title' => __('Restore Failed', 'escrowtics'),
						'restore_poll_fail_text' => __('AJAX polling failed', 'escrowtics'),
						'restore_fail_text' => __('An unexpected error occurred during the restore process', 'escrowtics'),
						'delete_confirm' => __('Yes, delete backup', 'escrowtics'),
						'backup_text' => __('A backup of your database will be created. Note: only plugin tables will be included', 'escrowtics'),
						'backup_confirm' => __('Yes, create backup', 'escrowtics'),
						'backup_singular' => __('backup', 'escrowtics'),
						'backup_singular_deleted' => __('backup deleted', 'escrowtics'),
						'backup_plural' => __('backups', 'escrowtics'),
						'backup_plural_deleted' => __('backups deleted', 'escrowtics')
					 ],
					  'dispute' => [
							'add_dispute_text' => $add_dispute_confirm,
							'add_dispute_title' => __('Really want to add Dispute?', 'escrowtics')
					 ]
				]	 
													
			];

			wp_localize_script('escrot-admin-js', 'escrot', $params);
			
	   }	
	   
	   
}
