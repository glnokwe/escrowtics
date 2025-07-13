<?php

/**
 * Enqueues all the public-facing scripts of the plugin.
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics;

defined('ABSPATH') || exit;

/**
 * Class PublicEnqueue
 */
class PublicEnqueue {

    /**
     * Register all frontend hooks.
     */
    public function register() {
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles'], 20);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Register frontend stylesheets.
     */
    public function enqueueStyles() {
        $styles = [
            'escrot-md-pub-css'   => 'lib/bootstrap/css/m-design.min.css',
            'escrot-dt-pub-css'   => 'lib/jquery/css/jquery.dataTables.min.css',
            'escrot-chat-pub-css' => 'assets/css/escrot-chat.css',
            'escrot-fa-pub-css'   => 'lib/fontawesome/css/all.min.css',
            'escrot-pub-css'      => 'assets/css/escrot-public.css',
        ];

        foreach ($styles as $handle => $path) {
            wp_enqueue_style($handle, ESCROT_PLUGIN_URL . $path, [], ESCROT_VERSION, 'all');
        }

        $this->addCustomCss();
    }

    /**
     * Adds custom inline CSS.
     */
    public static function addCustomCss() {
        $customColors = "
            :root {
                --escrot-primary-color: " . escrot_option('primary_color') . ";
                --escrot-secondary-color: " . escrot_option('secondary_color') . ";
                --escrot-font-family: inherit, jost, Roboto, Helvetica, Arial, tahoma;
            }";

        $customCss = is_user_logged_in()
            ? "@media only screen and (max-width: 600px) { .escrot-logged-out { display: none !important; } }"
            : "@media only screen and (max-width: 600px) { .escrot-logged-in { display: none !important; } }";

        wp_add_inline_style('escrot-pub-css', $customColors . $customCss . escrot_option('custom_css'));
    }

    /**
     * Register frontend JavaScripts.
     */
    public function enqueueScripts() {
        $scripts = [
            'jquery',
            'jquery-form',
            'escrot-popr-pup-js'   => 'lib/jquery/js/popper.min.js',
            'escrot-bt-pub-js'     => 'lib/bootstrap/js/m-design.min.js',
            'escrot-dt-pub-js'     => 'lib/jquery/js/jquery.dataTables.min.js',
            'escrot-swal-pub-js'   => 'lib/jquery/js/sweetalert2.min.js',
            'escrot-jny-pub-js'    => 'lib/bootstrap/js/jasny-bootstrap.min.js',
            'escrot-wiz-pub-js'    => 'lib/bootstrap/js/jquery.bootstrap-wizard.js',
            'escrot-escrow-pub-js' => 'assets/js/escrow-script.js',
            'escrot-user-pub-js'   => 'assets/js/users-script.js',
            'escrot-noty-pub-js'   => 'assets/js/notification-script.js',
            'escrot-disp-pub-js'   => 'assets/js/dispute-script.js',
			'escrot-fxns-pub-js'   => 'assets/js/escrot-functions.js',
			'escrot-pub-js'        => 'assets/js/escrot-public.js'
        ];

        foreach ($scripts as $handle => $path) {
           if (is_int($handle)) {
				wp_enqueue_script($path);
			} else {
				wp_enqueue_script($handle, ESCROT_PLUGIN_URL . $path, ['jquery'], ESCROT_VERSION, true);
			}
		}
		
		wp_enqueue_script(
			'escrot-paypal-sdk-js', 'https://www.paypal.com/sdk/js?client-id=AQbNXhnFYhosKiWCMVrxIhaWiqm-JBq5EdsnM6l-90TWpg-h-qs04oziCS1fSaIXKeaVIbInsIrCuXBu&currency=USD', 
			array('jquery'), // Dependencies (jQuery in this case)
			null, // Version (null disables versioning)
			true // Load script in the footer
		);

        // Localize script parameters
		$add_dispute_confirm = escrot_option('dispute_fees') === 'no_fee'
			   ? __("Add for free. Cancel if not sure!", "escrowtics")
			   : (escrot_option('dispute_fees') === 'fixed_fee'
					? sprintf(
						__("This dispute will cost you %s. Cancel if not sure", "escrowtics"), escrot_option('currency').escrot_option('dispute_fee_amount')
					) 
					: sprintf(
						__("This dispute will cost you %s of the escrow amount. Cancel if not sure", "escrowtics"), escrot_option('dispute_fee_percentage').'%'
					) 
				  );
        $params = [
            'ajaxurl'       => admin_url('admin-ajax.php'),
            'is_front_user' => escrot_is_front_user() ? true : false,
			'interaction_mode' => ESCROT_INTERACTION_MODE,
			'currency' => escrot_option('currency'),
			'user_bal_rest_url' => esc_url_raw(rest_url(ESCROT_PLUGIN_NAME.'/v1/get-current-balance')),
			'swal'  =>[

				'success' => [
					'delete_success' => __('deleted successfully', 'escrowtics'),
					'export_excel_success' => __('Excel Sheet Generated Successfully', 'escrowtics'),
					'checkbox_select_title' => __('Celected', 'escrowtics'),
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
				 ],
				 'escrow' => [
					'reject_confirm' => __('Yes, reject this amount', 'escrowtics'),
					'release_confirm' => __('Yes, release payment', 'escrowtics'),
					'add_escrow_confirm' => __('Yes, add escrow', 'escrowtics'),
					'add_milestone_confirm' => __('Yes, add milestone', 'escrowtics'),
					'delete_confirm' => __('Yes, delete', 'escrowtics'),
					'invoice_status_confirm' => __('Yes, update invoice', 'escrowtics'),
					'table_reload_success' => __('Table Reloaded successfully', 'escrowtics'),
					'form_error' => __('Please fix the errors in the form first (User does not exist )', 'escrowtics'),
					'deposit_confirm' => __('Yes, confirm deposit', 'escrowtics'),
					'withdraw_confirm' => __('Yes, confirm withdrawal', 'escrowtics')
				 ],
				  'user' => [
					'user_not_found' => __('is not a valid user, user not found!!', 'escrowtics'),
					'email_already_exist' => __('User with the provided email already exists', 'escrowtics'),
					'user_already_exist' => __('User with the provided username already exists', 'escrowtics'),
					'add_user_confirm' => __('Yes, add user', 'escrowtics'),
					'delete_user_confirm' => __('Yes, delete User', 'escrowtics'),
					'delete_user_text' => __("You won't be able to revert this! All data linked to this User(s) (escrows, notifications..etc) will also be deleted. Do you still want to continue?", 'escrowtics'),
					'update_confirm' => __('Yes, update user', 'escrowtics'),
					'logout_confirm' => __('Yes, logout', 'escrowtics'),
					'update_pass_confirm' => __('Yes, update password', 'escrowtics'),
					'update_pass_text' => __('You will need to login again', 'escrowtics'),
					'user_singular' => __('user', 'escrowtics'),
					'user_singular_deleted' => __('user deleted', 'escrowtics'),
					'user_plural' => __('users', 'escrowtics'),
					'user_plural_deleted' => __('users deleted', 'escrowtics')
				 ],
				 'dispute' => [
					'add_dispute_text' => $add_dispute_confirm,
					'add_dispute_title' => __('Really want to add Dispute?', 'escrowtics')
				 ]
			]
        ];
        wp_localize_script('escrot-pub-js', 'escrot', $params);
    }

    
}
                                                                        