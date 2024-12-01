<?php

/**
 * Option Fields Class
 * Defines parameters for all option fields
 * Since  1.0.0.
 * @package  Escrowtics
 */
 
 
namespace Escrowtics\base;

defined('ABSPATH') || exit;

class OptionFields {

    public $options;
	
	public $sections;

    public function __construct() {
		
        $this->options = [
		
            // General Settings
            [
                'id'          => 'plugin_interaction_mode',
                'title'       => 'Plugin Interaction Mode',
                'callback'    => 'selectField',
                'page'        => 'escrowtics-general',
                'section'     => 'escrot_general_settings',
                'placeholder' => '',
                'description' => 'Choose how users interact with the plugin.',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'cog',
                'default'     => 'page'
            ],
			[
			   'id'           => 'access_role',
			   'title'        => 'Plugin Access Role',
			   'callback'     => 'selectField',
			   'page'         => 'escrowtics-general',
			   'section'      => 'escrot_general_settings',
			   'placeholder'  => '',  
			    'description' => 'Choose which other admin user role other than Administrators, has access to the plugin. NB: Administrators are granted access by default. Also, only administrators can alter plugin settings',
			   'divclasses'   => 'col-md-6 p-3 card shadow-lg setTogg', 	
			   'icon'         => 'lock',
			   'default'      => 'editor'
            ],
            [
                'id'          => 'currency',
                'title'       => 'Currency',
                'callback'    => 'selectField',
                'page'        => 'escrowtics-general',
                'section'     => 'escrot_general_settings',
                'placeholder' => '',
                'description' => 'Default currency for transactions.',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'money-bill',
                'default'     => 'USD'
            ],
            [
                'id'          => 'timezone',
                'title'       => 'Timezone',
                'callback'    => 'selectField',
                'page'        => 'escrowtics-general',
                'section'     => 'escrot_general_settings',
                'placeholder' => '',
                'description' => 'Set a default timezone for the plugin (default is: UTC GMT+0:00)',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'clock',
                'default'     => 'UTC'
            ],
            [
                'id'          => 'company_address',
                'title'       => 'Company Address',
                'callback'    => 'textField',
                'page'        => 'escrowtics-general',
                'section'     => 'escrot_general_settings',
                'placeholder' => 'Enter company address',
                'description' => 'Enter the formal address of Your Company (used to Populate Email/invoice/waybill headers & footers)',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'map-marker',
                'default'     => ''
            ],
            [
                'id'          => 'company_phone',
                'title'       => 'Company Phone',
                'callback'    => 'textField',
                'page'        => 'escrowtics-general',
                'section'     => 'escrot_general_settings',
                'placeholder' => 'Enter company phone',
                'description' => 'Enter your Company\'s Office phone (used to Populate Email/invoice/waybill headers & footers)',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'phone',
                'default'     => ''
            ],
            [
                'id'          => 'company_logo',
                'title'       => 'Company Logo',
                'callback'    => 'fileField',
                'page'        => 'escrowtics-general',
                'section'     => 'escrot_general_settings',
                'placeholder' => '',
                'description' => 'Upload your company logo (will be displayed on tracking results page, invoices and waybills). Desired size: 156 x 36px',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'image',
                'default'     => ''
            ],
            [
                'id'          => 'logo_width',
                'title'       => 'Logo Width',
                'callback'    => 'textField',
                'page'        => 'escrowtics-logo-size-settings',
                'section'     => 'escrot_company_logo_size',
                'placeholder' => 'Enter width in px',
                'description' => 'Define a suitable Logo width (in pixels) for your logo',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => '156'
            ],
            [
                'id'          => 'logo_height',
                'title'       => 'Logo Height',
                'callback'    => 'textField',
                'page'        => 'escrowtics-logo-size-settings',
                'section'     => 'escrot_company_logo_size',
                'placeholder' => 'Enter height in px',
                'description' => 'Define a suitable Logo height (in pixels) for your logo',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => '36'
            ],
			// Escrow Options
            [
                'id'          => 'escrow_form_style',
                'title'       => 'Order Form Style',
                'callback'    => 'selectField',
                'page'        => 'escrowtics-backend-escrow',
                'section'     => 'escrot_backend_escrow_settings',
                'placeholder' => '',
                'description' => 'Select the escrow form style for adding and editing escrows, options include simple flow and tabs',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'circle-dollar-to-slot',
                'default'     => 'simple_flow'
            ],
            // Reference ID
            [
                'id'          => 'refid_length',
                'title'       => 'Reference ID Length',
                'callback'    => 'textField',
                'page'        => 'escrowtics-ref-id',
                'section'     => 'escrot_ref_id_settings',
                'placeholder' => 'enter a digit..e.g 12.',
                'description' => 'Enter desired autogenerated reference ID length (number of characters..e.g 14) this will be used to auto generate reference IDs for escrows. The default length is 12 digits. Note: Reference ID is a unique identifier for escrows.',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3 refid_length',
                'icon'        => 'pen-ruler',
                'default'     => '12'
            ],
            [
                'id'          => 'refid_xter_type',
                'title'       => 'Reference ID Character Type',
                'callback'    => 'selectField',
                'page'        => 'escrowtics-ref-id',
                'section'     => 'escrot_ref_id_settings',
                'placeholder' => 'enter a digit..e.g 12.',
                'description' => 'Select the desired character type for autogenerated reference id (e.g. numeric, alphanumeric..etc). This will be used to auto generate the reference IDs for escrows. Default is Numeric',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3 refid_xter_type',
                'icon'        => 'arrow-up-a-z',
                'default'     => '0123456789'
            ],

            // Email Settings
			[
                'id'          => 'company_email',
                'title'       => 'Admin/Company Email',
                'callback'    => 'textField',
                'page'        => 'escrowtics-emails',
                'section'     => 'escrot_email_settings',
                'placeholder' => 'Enter company email, default is WP admin email',
                'description' => 'Enter Your Company\'s Email Address (Used as Sender Email Address, Default is WP admin Email)',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'envelope',
                'default'     => get_option('admin_email') 
            ],
            [
                'id'          => 'user_new_escrow_email',
                'title'       => 'Notify Users on Escrow Creation',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-emails',
                'section'     => 'escrot_email_settings',
                'placeholder' => '',
                'description' => 'Should users receive email notification when their escrows are generated?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'envelope-open-text',
                'default'     => false
            ],
            [
                'id'          => 'user_new_milestone_email',
                'title'       => 'Notify Users on Adding Escrow Milestone',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-emails',
                'section'     => 'escrot_email_settings',
                'placeholder' => '',
                'description' => 'Should users receive email notification when their escrow is modified/updated?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'envelope-open-text',
                'default'     => false
            ],
            [
                'id'          => 'admin_new_escrow_email',
                'title'       => 'Notify Admin on Escrow Creation',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-emails',
                'section'     => 'escrot_email_settings',
                'placeholder' => '',
                'description' => 'Should admin receive email notification when an escrow is generated?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'envelope-open-text',
                'default'     => true
            ],
            [
                'id'          => 'admin_new_milestone_email',
                'title'       => 'Notify Admin on Adding Escrow Milestone',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-emails',
                'section'     => 'escrot_email_settings',
                'placeholder' => '',
                'description' => 'Should admin receive email notification when an escrow is modified/updated?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'envelope-open-text',
                'default'     => true
            ],
            [
                'id'          => 'notify_admin_by_email',
                'title'       => 'Send Admin Notifications as Email',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-emails',
                'section'     => 'escrot_email_settings',
                'placeholder' => '',
                'description' => 'Receive an email equivalent of admin notifications. These include notifications of tracking attempts, user assignments, user responses, etc.',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'envelope-open-text',
                'default'     => false
            ],
            [
                'id'          => 'smtp_protocol',
                'title'       => 'Send Emails Through Custom SMTP',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-emails',
                'section'     => 'escrot_email_settings',
                'placeholder' => '',
                'description' => 'Check to send emails with custom SMTP instead of the default WordPress mail function. If so, please set up the custom SMTP below.',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'shield',
                'default'     => false
            ],
            [
                'id'          => 'smtp_host',
                'title'       => 'SMTP Host',
                'callback'    => 'textField',
                'page'        => 'escrowtics-smtp-settings',
                'section'     => 'escrot_smtp_details',
                'placeholder' => 'Enter SMTP host address',
                'description' => 'Enter Custom SMTP Host (e.g., smtp.example.com)',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => ''
            ],
            [
                'id'          => 'smtp_user',
                'title'       => 'SMTP User',
                'callback'    => 'textField',
                'page'        => 'escrowtics-smtp-settings',
                'section'     => 'escrot_smtp_details',
                'placeholder' => 'Enter SMTP username..e.g email@example.com',
                'description' => 'Enter Username (e.g., email@example.com)',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => ''
            ],
            [
                'id'          => 'smtp_pass',
                'title'       => 'SMTP Password',
                'callback'    => 'textField',
                'page'        => 'escrowtics-smtp-settings',
                'section'     => 'escrot_smtp_details',
                'placeholder' => 'Enter SMTP password',
                'description' => 'Enter Email Account Password',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => ''
            ],
            [
                'id'          => 'smtp_port',
                'title'       => 'SMTP Port',
                'callback'    => 'textField',
                'page'        => 'escrowtics-smtp-settings',
                'section'     => 'escrot_smtp_details',
                'placeholder' => 'Enter SMTP port..e.g 587',
                'description' => 'Enter SMTP Port (e.g., 587)',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => ''
            ],
            [
                'id'          => 'user_new_escrow_email_subject',
                'title'       => 'User New Escrow Email Subject',
                'callback'    => 'textField',
                'page'        => 'escrowtics-user-escrow-email',
                'section'     => 'escrot_user_escrow_email',
                'placeholder' => 'Subject for new escrow email',
                'description' => 'Default subject for user new escrow email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'envelope',
                'default'     => self::defaultUserNewEscrowEmailSubject()
            ],
            [
                'id'          => 'user_new_escrow_email_body',
                'title'       => 'User New Escrow Email Body',
                'callback'    => 'textareaField',
                'page'        => 'escrowtics-user-escrow-email',
                'section'     => 'escrot_user_escrow_email',
                'placeholder' => 'Body for new escrow email',
                'description' => 'Default body for user new escrow email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'file-alt',
                'default'     => self::defaultUserNewEscrowEmailBody()
            ],
            [
                'id'          => 'user_new_escrow_email_footer',
                'title'       => 'User New Escrow Email Footer',
                'callback'    => 'textareaField',
                'page'        => 'escrowtics-user-escrow-email',
                'section'     => 'escrot_user_escrow_email',
                'placeholder' => 'Footer for new escrow email',
                'description' => 'Default footer for user new escrow email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'file-alt',
                'default'     => self::defaultUserNewEscrowEmailFooter()
            ],
			[
				'id'          => 'user_new_milestone_email_subject',
				'title'       => 'Email Subject on Adding Escrow Milestone',
				'callback'    => 'textField',
				'page'        => 'escrowtics-user-escrow-email',
				'section'     => 'escrot_user_escrow_email',
				'placeholder' => 'Subject for new escrow email',
				'description' => 'Default body for user new milestone email.',
				'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
				'icon'        => 'file-alt',
				'default'     => self::defaultUserNewEscrowEmailBody() // Default method for this option
			],
			[
				'id'          => 'user_new_milestone_email_body',
				'title'       => 'User New Milestone Email Body',
				'callback'    => 'textareaField',
				'page'        => 'escrowtics-user-escrow-email',
				'section'     => 'escrot_user_escrow_email',
				'placeholder' => 'Body for new milestone email',
				'description' => 'Default body for user new milestone email.',
				'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
				'icon'        => 'file-alt',
				'default'     => self::defaultUserNewMilestoneEmailBody() // Default method for this option
			],
			[
				'id'          => 'user_new_milestone_email_footer',
				'title'       => 'User New Milestone Email Footer',
				'callback'    => 'textareaField',
				'page'        => 'escrowtics-user-escrow-email',
				'section'     => 'escrot_user_escrow_email',
				'placeholder' => 'Footer for new milestone email',
				'description' => 'Default footer for user new milestone email.',
				'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
				'icon'        => 'file-alt',
				'default'     => self::defaultUserNewMilestoneEmailFooter() // Default method for this option
			],
            [
                'id'          => 'admin_new_escrow_email_subject',
                'title'       => 'Admin New Escrow Email Subject',
                'callback'    => 'textField',
                'page'        => 'escrowtics-admin-escrow-email',
                'section'     => 'escrot_admin_escrow_email',
                'placeholder' => 'Subject for admin new escrow email',
                'description' => 'Default subject for admin new escrow email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'envelope',
                'default'     => self::defaultAdminNewEscrowEmailSubject()
            ],
            [
                'id'          => 'admin_new_escrow_email_body',
                'title'       => 'Admin New Escrow Email Body',
                'callback'    => 'textareaField',
                'page'        => 'escrowtics-admin-escrow-email',
                'section'     => 'escrot_admin_escrow_email',
                'placeholder' => 'Body for admin new escrow email',
                'description' => 'Default body for admin new escrow email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'file-alt',
                'default'     => self::defaultAdminNewEscrowEmailBody()
            ],
            [
                'id'          => 'admin_new_escrow_email_footer',
                'title'       => 'Admin New Escrow Email Footer',
                'callback'    => 'textareaField',
                'page'        => 'escrowtics-admin-escrow-email',
                'section'     => 'escrot_admin_escrow_email',
                'placeholder' => 'Footer for admin new escrow email',
                'description' => 'Default footer for admin new escrow email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'file-alt',
                'default'     => self::defaultAdminNewEscrowEmailFooter()
            ],
            [
                'id'          => 'admin_new_milestone_email_subject',
                'title'       => 'Admin New Milestone Email Subject',
                'callback'    => 'textField',
                'page'        => 'escrowtics-admin-escrow-email',
                'section'     => 'escrot_admin_escrow_email',
                'placeholder' => 'Subject for admin milestone email',
                'description' => 'Default subject for admin new milestone email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'envelope',
                'default'     => self::defaultAdminNewMilestoneEmailSubject()
            ],
            [
                'id'          => 'admin_new_milestone_email_body',
                'title'       => 'Admin New Milestone Email Body',
                'callback'    => 'textareaField',
                'page'        => 'escrowtics-admin-escrow-email',
                'section'     => 'escrot_admin_escrow_email',
                'placeholder' => 'Body for admin milestone email',
                'description' => 'Default body for admin new milestone email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'file-alt',
                'default'     => self::defaultAdminNewMilestoneEmailBody()
            ],
            [
                'id'          => 'admin_new_milestone_email_footer',
                'title'       => 'Admin New Milestone Email Footer',
                'callback'    => 'textareaField',
                'page'        => 'escrowtics-admin-escrow-email',
                'section'     => 'escrot_admin_escrow_email',
                'placeholder' => 'Footer for admin milestone email',
                'description' => 'Default footer for admin new milestone email.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'file-alt',
                'default'     => self::defaultAdminNewMilestoneEmailFooter()
            ],
			//Admin Styling
			[
				'id'          => 'theme_class',
				'title'       => 'Admin Theme Colour Scheme',
				'callback'    => 'selectField',
				'page'        => 'escrowtics-admin-appearance',
				'section'     => 'escrot_admin_appearance_settings',
				'placeholder' => '',
				'description' => 'Choose between light and dark theme colour schemes',
				'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
				'icon'        => 'palette',
				'default'     => 'light_edition'
			],
			[
				'id'          => 'admin_nav_style',
				'title'       => 'Admin Navigation Menu Style',
				'callback'    => 'selectField',
				'page'        => 'escrowtics-admin-appearance',
				'section'     => 'escrot_admin_appearance_settings',
				'placeholder' => '',
				'description' => 'Choose desired admin navigation menu style',
				'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
				'icon'        => 'palette',
				'default'     => 'top-menu'
			],
			[
				'id'          => 'fold_wp_menu',
				'title'       => 'Fold WP Menu while Using Plugin',
				'callback'    => 'checkboxField',
				'page'        => 'escrowtics-admin-appearance',
				'section'     => 'escrot_admin_appearance_settings',
				'placeholder' => '',
				'description' => 'Keep WordPress menu folded while using this plugin? You will still be able to expand & fold it manually.',
				'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
				'icon'        => 'minimize',
				'default'     => false
			],
			[
				'id'          => 'fold_escrot_menu',
				'title'       => 'Fold Escrowtics Menu (Sidebar Menu)',
				'callback'    => 'checkboxField',
				'page'        => 'escrowtics-admin-appearance',
				'section'     => 'escrot_admin_appearance_settings',
				'placeholder' => '',
				'description' => 'Keep Escrowtics menu folded (show only icon menu bar with details on hover)? You will still be able to expand & fold it manually. Works only with vertical navigation (sidebar menu).',
				'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
				'icon'        => 'minimize',
				'default'     => false
			],
			// Frontend Styling
            [
                'id'          => 'primary_color',
                'title'       => 'Primary Frontend Colour',
                'callback'    => 'colourField',
                'page'        => 'escrowtics-public-appearance',
                'section'     => 'escrot_public_appearance_settings',
                'placeholder' => 'Select colour',
                'description' => 'Choose a primary colour to match your brand or website',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'code',
                'default'     => '#ff5604'
            ],
            [
                'id'          => 'secondary_color',
                'title'       => 'Secondary Frontend Colour',
                'callback'    => 'colourField',
                'page'        => 'escrowtics-public-appearance',
                'section'     => 'escrot_public_appearance_settings',
                'placeholder' => 'Select colour',
                'description' => 'Choose a secondary colour to match your brand or website',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'code',
                'default'     => '#8080ff'
            ],
            [
                'id'          => 'custom_css',
                'title'       => 'Custom Css (frontend)',
                'callback'    => 'textareaField',
                'page'        => 'escrowtics-public-appearance',
                'section'     => 'escrot_public_appearance_settings',
                'placeholder' => 'Enter all your frontend custom css here',
                'description' => 'Add all custom CSS for frontend tracking results page',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'code',
                'default'     => ''
            ],

            // Labels
            [
                'id'          => 'escrow_detail_label',
                'title'       => 'Escrow Details',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is "Escrow Details"',
                'description' => 'Enter text to replace escrow detail Label at frontend. Default is "Escrow Details"',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Escrow Details'
            ],
            [
                'id'          => 'escrow_table_label',
                'title'       => 'Escrow Table',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is Escrow Table',
                'description' => 'Enter text to replace escrow table Label at frontend. Default label is Escrow Table',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Escrow Table'
            ],
            [
                'id'          => 'earning_table_label',
                'title'       => 'Earnings Table',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is Earnings Table',
                'description' => 'Enter text to replace earnings table Label at frontend. Default label is Earnings Table',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Earnings Table'
            ],
            [
                'id'          => 'log_table_label',
                'title'       => 'Transaction Log',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is Transaction Log',
                'description' => 'Enter text to replace transaction log table Label at frontend. Default label is Transaction Log',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Transaction Log'
            ],
            [
                'id'          => 'deposit_history_table_label',
                'title'       => 'Deposit History',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is Deposit History',
                'description' => 'Enter text to replace deposit history table Label at frontend. Default label is Deposit History',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Deposit History'
            ],
            [
                'id'          => 'withdraw_history_table_label',
                'title'       => 'Withdrawal History',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is Withdrawal History',
                'description' => 'Enter text to replace withdrawal history table Label at frontend. Default label is Withdrawal History',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Withdrawal History'
            ],
            [
                'id'          => 'escrow_list_label',
                'title'       => 'Escrow List',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is RECENT ESCROW COMMENTS',
                'description' => 'Enter text to replace escrow list metric Label at frontend. Default label is Escrow List',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Escrow List'
            ],
            [
                'id'          => 'earning_list_label',
                'title'       => 'Earning List',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is Earning List',
                'description' => 'Enter text to replace earning list metric Label at frontend. Default label is Earning List',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'Earning List'
            ],
            [
                'id'          => 'login_form_label',
                'title'       => 'User Login',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is User Login',
                'description' => 'Enter text to replace user login form Label at frontend. Default label is User Login',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'User Login'
            ],
            [
                'id'          => 'signup_form_label',
                'title'       => 'User Signup',
                'callback'    => 'textField',
                'page'        => 'escrowtics-labels',
                'section'     => 'escrot_label_settings',
                'placeholder' => 'Default label is User Signup',
                'description' => 'Enter text to replace user signup form Label at frontend. Default label is User Signup',
                'divclasses'  => 'col-md-6 p-3',
                'icon'        => '',
                'default'     => 'User Signup'
            ],
			// DB Backup Options
            [
                'id'          => 'dbackup_log',
                'title'       => 'Enable Database Backup Log',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-db',
                'section'     => 'escrot_dbbackup_settings',
                'placeholder' => '',
                'description' => 'Should a backup log file be viewable on the backup table?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'list',
                'default'     => false
            ],
            [
                'id'          => 'auto_dbackup',
                'title'       => 'Enable Auto Database Backup',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-db',
                'section'     => 'escrot_dbbackup_settings',
                'placeholder' => '',
                'description' => 'Should a backup be created automatically according to a defined schedule? If yes, please choose schedule below.',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'sync',
                'default'     => false
            ],
            [
                'id'          => 'auto_db_freq',
                'title'       => 'Auto DB Backup Frequency',
                'callback'    => 'selectField',
                'page'        => 'escrowtics-db',
                'section'     => 'escrot_dbbackup_settings',
                'placeholder' => '',
                'description' => 'Choose the frequency of backups, how often do you want a backup to be created automatically?',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3 auto_db_freq',
                'icon'        => 'clock',
                'default'     => 'weekly'
            ],

            // Payment Options
            [
                'id'          => 'enable_bitcoin_payment',
                'title'       => 'Bitcoin Payment (Via Blockomics API)',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-payment',
                'section'     => 'escrot_payment_settings',
                'placeholder' => '',
                'description' => 'Want users to make deposits and withdrawals through bitcoin?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'bitcoin-sign',
                'default'     => false
            ],
            [
                'id'          => 'enable_paypal_payment',
                'title'       => 'Paypal Payment (Via Paypal API)',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-payment',
                'section'     => 'escrot_payment_settings',
                'placeholder' => '',
                'description' => 'Want users to make deposits and withdrawals through PayPal?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'paypal',
                'default'     => false
            ],
            [
                'id'          => 'blockonomics_api_key',
                'title'       => 'Blockomics API Key',
                'callback'    => 'textField',
                'page'        => 'escrowtics-payment',
                'section'     => 'escrot_payment_settings',
                'placeholder' => '',
                'description' => 'Enter your Blockonomics API key. Required for bitcoin payment',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-4 blockonomics_api_key',
                'icon'        => 'key',
                'default'     => ''
            ],
            [
                'id'          => 'escrot_blockonomics_enpoint_url',
                'title'       => 'Your Blockomics Endpoint URL',
                'callback'    => 'textField',
                'page'        => 'escrowtics-payment',
                'section'     => 'escrot_payment_settings',
                'placeholder' => '',
                'description' => 'Blockomics URL. Use this to set up Bitcoin payment at https://blockomics.com/api',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'link',
                'default'     => ''
            ],
            [
                'id'          => 'paypal_email',
                'title'       => 'Paypal Email',
                'callback'    => 'textField',
                'page'        => 'escrowtics-payment',
                'section'     => 'escrot_payment_settings',
                'placeholder' => '',
                'description' => 'Enter your PayPal email',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'envelope',
                'default'     => ''
            ],

            // Advanced Options
            [
                'id'          => 'enable_rest_api',
                'title'       => 'Share Plugin Data via REST API?',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-advanced',
                'section'     => 'escrot_advanced_settings',
                'placeholder' => '',
                'description' => 'Want to send plugin REST API Endpoint data through HTTPS Request?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'share-nodes',
                'default'     => false
            ],
            [
                'id'          => 'enable_rest_api_key',
                'title'       => 'Require API Key for REST API Access?',
                'callback'    => 'checkboxField',
                'page'        => 'escrowtics-advanced',
                'section'     => 'escrot_advanced_settings',
                'placeholder' => '',
                'description' => 'Want to authenticate REST API Endpoint data request with a key?',
                'divclasses'  => 'col-md-6 card shadow-lg setTogg p-3',
                'icon'        => 'key',
                'default'     => false
            ],
            [
                'id'          => 'rest_api_key',
                'title'       => 'Your REST API key for Escrowtics',
                'callback'    => 'textField',
                'page'        => 'escrowtics-advanced',
                'section'     => 'escrot_advanced_settings',
                'placeholder' => '',
                'description' => 'Create API key for custom REST API endpoint authentication. Block unauthorized access to plugin REST API data.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'key',
                'default'     => '' 
            ],
            [
                'id'          => 'rest_api_enpoint_url',
                'title'       => 'Your REST API Endpoint URL',
                'callback'    => 'textField',
                'page'        => 'escrowtics-advanced',
                'section'     => 'escrot_advanced_settings',
                'placeholder' => '',
                'description' => 'REST API custom Endpoint URL. Do not share with unauthorized users!',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'link',
                'default'     => '' 
            ],
            [
                'id'          => 'rest_api_data',
                'title'       => 'Select Custom Data to Send Via REST API',
                'callback'    => 'multSelectField',
                'page'        => 'escrowtics-advanced',
                'section'     => 'escrot_advanced_settings',
                'placeholder' => '',
                'description' => 'Choose specific data to share via your REST API Endpoint.',
                'divclasses'  => 'col-md-12 card shadow-lg setTogg12 p-3',
                'icon'        => 'list-check',
                'default'     => [] 
            ]
			
        ];
		
		
		
		
		
		$this->sections = [
			[
				'id'    => 'escrot_general_settings',
				'title' => 'General Settings',
				'page'  => 'escrowtics-general'
			],
			[
				'id'    => 'escrot_admin_appearance_settings',
				'title' => 'Admin Appearance Settings',
				'page'  => 'escrowtics-admin-appearance'
			],
			[
				'id'    => 'escrot_public_appearance_settings',
				'title' => 'Frontend Appearance Settings',
				'page'  => 'escrowtics-public-appearance'
			],
			[
				'id'    => 'escrot_backend_escrow_settings',
				'title' => 'Escrow Settings',
				'page'  => 'escrowtics-backend-escrow'
			],
			[
				'id'    => 'escrot_email_settings',
				'title' => 'Email Notification Settings',
				'page'  => 'escrowtics-emails'
			],
			[
				'id'    => 'escrot_dbbackup_settings',
				'title' => 'DB Backup Settings',
				'page'  => 'escrowtics-db'
			],
			[
				'id'    => 'escrot_payment_settings',
				'title' => 'Payment Settings',
				'page'  => 'escrowtics-payment'
			],
			[
				'id'    => 'escrot_advanced_settings',
				'title' => 'Advanced Settings',
				'page'  => 'escrowtics-advanced'
			],
			// Section Groups
			[
				'id'    => 'escrot_smtp_details',
				'title' => '',
				'page'  => 'escrowtics-smtp-settings'
			],
			[
				'id'    => 'escrot_company_logo_size',
				'title' => '',
				'page'  => 'escrowtics-logo-size-settings'
			],
			[
				'id'    => 'escrot_user_escrow_email',
				'title' => '',
				'page'  => 'escrowtics-user-escrow-email'
			],
			[
				'id'    => 'escrot_admin_escrow_email',
				'title' => '',
				'page'  => 'escrowtics-admin-escrow-email'
			],
			[
				'id'    => 'escrot_label_settings',
				'title' => '',
				'page'  => 'escrowtics-labels'
			],
			[
				'id'    => 'escrot_ref_id_settings',
				'title' => '',
				'page'  => 'escrowtics-ref-id'
			]
		];

    }

    /**
     * Default subject for user new escrow email
     * @return string
     */
    private static function defaultUserNewEscrowEmailSubject() {
        return __('Your escrow has been successfully created.', 'escrowtics');
    }

    /**
     * Default body for user new escrow email
     * @return string
     */
    private static function defaultUserNewEscrowEmailBody() {
        return __('<p>Hello,</p><p>Thank you for creating an escrow with us. Your escrow has been successfully created and is now active.</p>', 'escrowtics');
    }

    /**
     * Default footer for user new escrow email
     * @return string
     */
    private static function defaultUserNewEscrowEmailFooter() {
        return __('<p>Best regards,<br>The Escrowtics Team</p>', 'escrowtics');
    }

    /**
     * Default subject for user new milestone email
     * @return string
     */
    private static function defaultUserNewMilestoneEmailSubject() {
        return __('A new milestone has been added to your escrow.', 'escrowtics');
    }

    /**
     * Default body for user new milestone email
     * @return string
     */
    private static function defaultUserNewMilestoneEmailBody() {
        return __('<p>Hello,</p><p>A new milestone has been successfully added to your escrow. Please review the milestone details in your dashboard.</p>', 'escrowtics');
    }

    /**
     * Default footer for user new milestone email
     * @return string
     */
    private static function defaultUserNewMilestoneEmailFooter() {
        return __('<p>Best regards,<br>The Escrowtics Team</p>', 'escrowtics');
    }

    /**
     * Default subject for admin new escrow email
     * @return string
     */
    private static function defaultAdminNewEscrowEmailSubject() {
        return __('New Escrow Created', 'escrowtics');
    }

    /**
     * Default body for admin new escrow email
     * @return string
     */
    private static function defaultAdminNewEscrowEmailBody() {
        return __('<p>Hello Admin,</p><p>A new escrow has been created on the platform. Please review the escrow details in your admin panel.</p>', 'escrowtics');
    }

    /**
     * Default footer for admin new escrow email
     * @return string
     */
    private static function defaultAdminNewEscrowEmailFooter() {
        return __('<p>Best regards,<br>The Escrowtics System</p>', 'escrowtics');
    }

    /**
     * Default subject for admin new milestone email
     * @return string
     */
    private static function defaultAdminNewMilestoneEmailSubject() {
        return __('New Milestone Notification', 'escrowtics');
    }

    /**
     * Default body for admin new milestone email
     * @return string
     */
    private static function defaultAdminNewMilestoneEmailBody() {
        return __('<p>Hello Admin,</p><p>A new milestone has been added to an existing escrow. Please review the milestone details in your admin panel.</p>', 'escrowtics');
    }

    /**
     * Default footer for admin new milestone email
     * @return string
     */
    private static function defaultAdminNewMilestoneEmailFooter() {
        return __('<p>Best regards,<br>The Escrowtics System</p>', 'escrowtics');
    }
	
	
	
}
