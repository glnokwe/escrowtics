<?php

/**
 * Option Fields Class
 * Defines parameters for all option fields
 *
 * Since     1.0.0.
 * @package  Escrowtics
 */
 
 
namespace Escrowtics\Base;

defined('ABSPATH') || exit;


class OptionFields {

     public function fields() {
		
        return [
		
				//General Options
				[
					'id'          =>  'access_role',
					'title'       =>  __("Plugin Access Role", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_general',
					'section'     =>  'escrot_general_settings',
					'placeholder' =>  "",
					'description' =>  __("Choose which other admin user role other than Administrators, has access to the plugin. NB: Administrators are granted access by default. Also, only administrators can alter plugin settings", "escrowtics"),
					'divclasses'  =>  'col-md-4 p-3 card shadow-lg',
					'icon'        =>  'user-shield'  
				],
				[
					'id'          =>  'currency',
					'title'       =>  __("Currency", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_general',
					'section'     =>  'escrot_general_settings',
					'placeholder' =>  "",
					'description' =>  __("Default currency for transactions.", "escrowtics"),
					'divclasses'  =>  'col-md-4 card shadow-lg p-3',
					'icon'        =>  'money-bill-wave'  
				],

				[
					'id'          =>  'timezone',
					'title'       =>  __("Timezone", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_general',
					'section'     =>  'escrot_general_settings',
					'placeholder' =>  "",
					'description' =>  __("Set a default timezone for the plugin (default is: UTC GMT+0:00)", "escrowtics"),
					'divclasses'  =>  'col-md-4 card shadow-lg p-3',
					'icon'        =>  'globe'  
				],

				[
					'id'          =>  'company_address',
					'title'       =>  __("Company Address", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_general',
					'section'     =>  'escrot_general_settings',
					'placeholder' =>  __("Enter company address", "escrowtics"),
					'description' =>  __("Enter the formal address of Your Company (used to Populate Email/invoice/waybill headers & footers)", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'map-marker-alt'  
				],

				[
					'id'          =>  'company_phone',
					'title'       =>  __("Company Phone", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_general',
					'section'     =>  'escrot_general_settings',
					'placeholder' =>  __("Enter company phone", "escrowtics"),
					'description' =>  __("Enter your Company's Office phone (used to Populate Email/invoice/waybill headers & footers)", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'phone-alt' 
				],
				[
					'id'          =>  'company_logo',
					'title'       =>  __("Company Logo", "escrowtics"),
					'callback'    =>  'fileField',
					'page'        =>  'escrowtics_company_logo',
					'section'     =>  'escrot_company_logo_settings',
					'placeholder' =>  "",
					'description' =>  __("Upload your company logo (will be displayed on invoices). Desired size: 156 x 36px", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'image'  
				],
				[
					'id'          =>  'logo_width',
					'title'       =>  __("Logo Width", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_company_logo',
					'section'     =>  'escrot_company_logo_settings',
					'placeholder' =>  __("Enter width in px", "escrowtics"),
					'description' =>  __("Define a suitable Logo width (in pixels) for your logo", "escrowtics"),
					'divclasses'  =>  'col-md-3 p-3',
					'icon'        =>  'arrows-alt-h' 
				],
				[
					'id'          =>  'logo_height',
					'title'       =>  __("Logo Height", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_company_logo',
					'section'     =>  'escrot_company_logo_settings',
					'placeholder' =>  __("Enter height in px", "escrowtics"),
					'description' =>  __("Define a suitable Logo height (in pixels) for your logo", "escrowtics"),
					'divclasses'  =>  'col-md-3 p-3',
					'icon'        =>  'arrows-alt-v' 
				],
				
				// Escrow Options
				[
					'id'          =>  'escrow_form_style',
					'title'       =>  __("Order Form Style", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_backend_escrow',
					'section'     =>  'escrot_backend_escrow_settings',
					'placeholder' =>  "",
					'description' =>  __("Select the escrow form style for adding and editing escrows, options include simple flow and tabs", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'file-invoice-dollar' 
				],
				
				// Reference ID
				[
					'id'          =>  'refid_length',
					'title'       =>  __("Reference ID Length", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_ref_id',
					'section'     =>  'escrot_ref_id_settings',
					'placeholder' =>  __("enter a digit..e.g 12.", "escrowtics"),
					'description' =>  __("Enter desired autogenerated reference ID length (number of characters..e.g 14) this will be used to auto generate reference IDs for escrows. The default length is 12 digits. Note: Reference ID is a unique identifier for escrows.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'hashtag' 
				],
				[
					'id'          =>  'refid_xter_type',
					'title'       =>  __("Reference ID Character Type", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_ref_id',
					'section'     =>  'escrot_ref_id_settings',
					'placeholder' =>  __("enter a digit..e.g 12.", "escrowtics"),
					'description' =>  __("Select the desired character type for autogenerated reference id (e.g. numeric, alphanumeric..etc). This will be used to auto generate the reference IDs for escrows. Default is Numeric", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'font' 
				],
				
				// Escrow fees
				[
					'id'          =>  'escrow_fees',
					'title'       =>  __("Escrow Fee Option", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_escrow_fees',
					'section'     =>  'escrot_escrow_fees_settings',
					'placeholder' =>  "",
					'description' =>  __("Want to charge an escrow creation fee (this is different from commissions paid for escrow mediation). Decides the escrow fee mode you prefer, flat amount or percentage?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'percentage' 
				],
				[
					'id'          =>  'escrow_fee_description',
					'title'       =>  __("Description for Escrow Fee", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_escrow_fees',
					'section'     =>  'escrot_escrow_fees_settings',
					'placeholder' =>  "",
					'description' =>  __("Describe the escrow fee e.g Escrow Creation Fee", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'file-alt'
				],
				
				// Email Settings
				[
					'id'          =>  'company_email',
					'title'       =>  __("Admin/Company Email", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_email',
					'section'     =>  'escrot_email_settings',
					'placeholder' =>  __("Enter company email, default is WP admin email", "escrowtics"),
					'description' =>  __("Enter Your Company's Email Address (Used as Sender Email Address, Default is WP admin Email)", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'envelope' 
				],
				[
					'id'          =>  'user_new_escrow_email',
					'title'       =>  __("Notify Users on Escrow Creation", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_email',
					'section'     =>  'escrot_email_settings',
					'placeholder' =>  "",
					'description' =>  __("Should users receive email notification when their escrows are generated?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'bell'
				],
				[
					'id'          =>  'user_new_milestone_email',
					'title'       =>  __("Notify Users on Adding Escrow Milestone", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_email',
					'section'     =>  'escrot_email_settings',
					'placeholder' =>  "",
					'description' =>  __("Should users receive email notification when their escrow is modified/updated?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'tasks' 
				],
				[
					'id'          =>  'admin_new_escrow_email',
					'title'       =>  __("Notify Admin on Escrow Creation", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_email',
					'section'     =>  'escrot_email_settings',
					'placeholder' =>  "",
					'description' =>  __("Should admin receive email notification when an escrow is generated?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'user-cog'
				],
				[
					'id'          =>  'admin_new_milestone_email',
					'title'       =>  __("Notify Admin on Adding Escrow Milestone", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_email',
					'section'     =>  'escrot_email_settings',
					'placeholder' =>  "",
					'description' =>  __("Should admin receive email notification when an escrow is modified/updated?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'user-edit' 
				],
				[
					'id'          =>  'notify_admin_by_email',
					'title'       =>  __("Send Admin Notifications as Email", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_email',
					'section'     =>  'escrot_email_settings',
					'placeholder' =>  "",
					'description' =>  __("Receive an email equivalent of admin notifications. These include notifications of tracking attempts, user assignments, user responses, etc.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'mail-bulk'
				],
				[
					'id'          =>  'smtp_protocol',
					'title'       =>  __("Send Emails Through Custom SMTP", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_email',
					'section'     =>  'escrot_email_settings',
					'placeholder' =>  "",
					'description' =>  __("Check to send emails with custom SMTP instead of the default WordPress mail function. If so, please set up the custom SMTP below.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'server' 
				],
				[
					'id'          => 'smtp_host',
					'title'       => __("SMTP Host", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_smtp',
					'section'     => 'escrot_smtp_settings',
					'placeholder' => __("Enter SMTP host address", "escrowtics"),
					'description' => __("Enter Custom SMTP Host (e.g., smtp.example.com)", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'server'
				],
				[
					'id'          => 'smtp_user',
					'title'       => __("SMTP User", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_smtp',
					'section'     => 'escrot_smtp_settings',
					'placeholder' => __("Enter SMTP username..e.g email@example.com", "escrowtics"),
					'description' => __("Enter Username (e.g., email@example.com)", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'user'
				],
				[
					'id'          => 'smtp_pass',
					'title'       => __("SMTP Password", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_smtp',
					'section'     => 'escrot_smtp_settings',
					'placeholder' => __("Enter SMTP password", "escrowtics"),
					'description' => __("Enter Email Account Password", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'key'
				],
				[
					'id'          => 'smtp_port',
					'title'       => __("SMTP Port", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_smtp',
					'section'     => 'escrot_smtp_settings',
					'placeholder' => __("Enter SMTP port..e.g 587", "escrowtics"),
					'description' => __("Enter SMTP Port (e.g., 587)", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'network-wired'
				],
				
				
				[
					'id'          => 'user_new_escrow_email_subject',
					'title'       => __("User New Escrow Email Subject", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_user_escrow_email',
					'section'     => 'escrot_user_escrow_email_settings',
					'placeholder' => __("Subject for new escrow email", "escrowtics"),
					'description' => __("Default subject for user new escrow email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'envelope'
				],
				[
					'id'          => 'user_new_milestone_email_subject',
					'title'       => __("Email Subject on Adding Escrow Milestone", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_user_escrow_email',
					'section'     => 'escrot_user_escrow_email_settings',
					'placeholder' => __("Subject for new escrow email", "escrowtics"),
					'description' => __("Default body for user new milestone email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'user_new_escrow_email_body',
					'title'       => __("User New Escrow Email Body", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_user_escrow_email',
					'section'     => 'escrot_user_escrow_email_settings',
					'placeholder' => __("Body for new escrow email", "escrowtics"),
					'description' => __("Default body for user new escrow email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'user_new_milestone_email_body',
					'title'       => __("User New Milestone Email Body", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_user_escrow_email',
					'section'     => 'escrot_user_escrow_email_settings',
					'placeholder' => __("Body for new milestone email", "escrowtics"),
					'description' => __("Default body for user new milestone email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'user_new_escrow_email_footer',
					'title'       => __("User New Escrow Email Footer", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_user_escrow_email',
					'section'     => 'escrot_user_escrow_email_settings',
					'placeholder' => __("Footer for new escrow email", "escrowtics"),
					'description' => __("Default footer for user new escrow email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'user_new_milestone_email_footer',
					'title'       => __("User New Milestone Email Footer", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_user_escrow_email',
					'section'     => 'escrot_user_escrow_email_settings',
					'placeholder' => __("Footer for new milestone email", "escrowtics"),
					'description' => __("Default footer for user new milestone email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],

				// Admin Emails
				[
					'id'          => 'admin_new_escrow_email_subject',
					'title'       => __("Admin New Escrow Email Subject", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_admin_escrow_email',
					'section'     => 'escrot_admin_escrow_email_settings',
					'placeholder' => __("Subject for admin new escrow email", "escrowtics"),
					'description' => __("Default subject for admin new escrow email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'envelope'
				],
				[
					'id'          => 'admin_new_milestone_email_subject',
					'title'       => __("Admin New Milestone Email Subject", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_admin_escrow_email',
					'section'     => 'escrot_admin_escrow_email_settings',
					'placeholder' => __("Subject for admin milestone email", "escrowtics"),
					'description' => __("Default subject for admin new milestone email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'envelope'
				],
				[
					'id'          => 'admin_new_escrow_email_body',
					'title'       => __("Admin New Escrow Email Body", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_admin_escrow_email',
					'section'     => 'escrot_admin_escrow_email_settings',
					'placeholder' => __("Body for admin new escrow email", "escrowtics"),
					'description' => __("Default body for admin new escrow email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'admin_new_milestone_email_body',
					'title'       => __("Admin New Milestone Email Body", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_admin_escrow_email',
					'section'     => 'escrot_admin_escrow_email_settings',
					'placeholder' => __("Body for admin milestone email", "escrowtics"),
					'description' => __("Default body for admin new milestone email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'admin_new_escrow_email_footer',
					'title'       => __("Admin New Escrow Email Footer", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_admin_escrow_email',
					'section'     => 'escrot_admin_escrow_email_settings',
					'placeholder' => __("Footer for admin new escrow email", "escrowtics"),
					'description' => __("Default footer for admin new escrow email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'admin_new_milestone_email_footer',
					'title'       => __("Admin New Milestone Email Footer", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_admin_escrow_email',
					'section'     => 'escrot_admin_escrow_email_settings',
					'placeholder' => __("Footer for admin milestone email", "escrowtics"),
					'description' => __("Default footer for admin new milestone email.", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				
				// Admin Styling
				[
					'id'          => 'interaction_mode_admin',
					'title'       => __("Admin Interaction Mode", "escrowtics"),
					'callback'    => 'selectField',
					'page'        => 'escrowtics_admin_appearance',
					'section'     => 'escrot_admin_appearance_settings',
					'placeholder' => "",
					'description' => __("Choose interaction mode for admin users (dialogs/modals)", "escrowtics"),
					'divclasses'  => 'col-md-4 card shadow-lg p-3',
					'icon'        => 'sliders'
				],
				[
					'id'          => 'theme_class',
					'title'       => __("Admin Theme Colour Scheme", "escrowtics"),
					'callback'    => 'selectField',
					'page'        => 'escrowtics_admin_appearance',
					'section'     => 'escrot_admin_appearance_settings',
					'placeholder' => "",
					'description' => __("Choose between light and dark theme colour schemes", "escrowtics"),
					'divclasses'  => 'col-md-4 card shadow-lg p-3',
					'icon'        => 'brush'
				],
				[
					'id'          => 'admin_nav_style',
					'title'       => __("Admin Navigation Menu Style", "escrowtics"),
					'callback'    => 'selectField',
					'page'        => 'escrowtics_admin_appearance',
					'section'     => 'escrot_admin_appearance_settings',
					'placeholder' => "",
					'description' => __("Choose desired admin navigation menu style", "escrowtics"),
					'divclasses'  => 'col-md-4 card shadow-lg p-3',
					'icon'        => 'bars'
				],
				[
					'id'          => 'fold_wp_menu',
					'title'       => __("Fold WP Menu while Using Plugin", "escrowtics"),
					'callback'    => 'checkboxField',
					'page'        => 'escrowtics_admin_appearance',
					'section'     => 'escrot_admin_appearance_settings',
					'placeholder' => "",
					'description' => __("Keep WordPress menu folded while using this plugin? You will still be able to expand & fold it manually.", "escrowtics"),
					'divclasses'  => 'col-md-6 card shadow-lg p-3',
					'icon'        => 'compress'
				],
				[
					'id'          =>  'hide_wp_menu',
					'title'       =>  __("Hide WordPress Menu", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_admin_appearance',
					'section'     =>  'escrot_admin_appearance_settings',
					'placeholder' =>  "",
					'description' =>  __("Hide WordPress menu while using this plugin? ⚠️ Core WordPress features will be unavailable until you turn it back on.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'minimize'
				],
				[
					'id'          =>  'hide_wp_footer',
					'title'       =>  __("Hide WordPress Footer", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_admin_appearance',
					'section'     =>  'escrot_admin_appearance_settings',
					'placeholder' =>  "",
					'description' =>  __("Hide WordPress footer while using this plugin? ⚠️ WordPress credits will not be visible until you turn it back on.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'minimize'
				],
				[
					'id'          =>  'hide_wp_admin_bar',
					'title'       =>  __("Hide WordPress Admin Bar", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_admin_appearance',
					'section'     =>  'escrot_admin_appearance_settings',
					'placeholder' =>  "",
					'description' =>  __("Hide the WordPress admin bar while using this plugin. ⚠️ Core WordPress features will be unavailable until you turn it back on.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'minimize'
				],
				[
					'id'          => 'fold_escrot_menu',
					'title'       => __("Fold Escrowtics Menu (Sidebar Menu)", "escrowtics"),
					'callback'    => 'checkboxField',
					'page'        => 'escrowtics_admin_appearance',
					'section'     => 'escrot_admin_appearance_settings',
					'placeholder' => "",
					'description' => __("Keep Escrowtics menu folded (show only icon menu bar with details on hover)? You will still be able to expand & fold it manually. Works only with vertical navigation (sidebar menu).", "escrowtics"),
					'divclasses'  => 'col-md-6 card shadow-lg p-3',
					'icon'        => 'compress'
				],
				// Frontend Styling
				[
					'id'          => 'interaction_mode_frontend',
					'title'       => __("Frontend Interaction Mode", "escrowtics"),
					'callback'    => 'selectField',
					'page'        => 'escrowtics_public_appearance',
					'section'     => 'escrot_public_appearance_settings',
					'placeholder' => "",
					'description' => __("Choose interaction mode for frontend users (dialogs/modals).", "escrowtics"),
					'divclasses'  => 'col-md-4 card shadow-lg p-3',
					'icon'        => 'sliders'
				],
				[
					'id'          => 'primary_color',
					'title'       => __("Primary Frontend Colour", "escrowtics"),
					'callback'    => 'colourField',
					'page'        => 'escrowtics_public_appearance',
					'section'     => 'escrot_public_appearance_settings',
					'placeholder' => __("Select colour", "escrowtics"),
					'description' => __("Choose a primary colour to match your brand or website", "escrowtics"),
					'divclasses'  => 'col-md-4 card shadow-lg p-3',
					'icon'        => 'palette'
				],
				[
					'id'          => 'secondary_color',
					'title'       => __("Secondary Frontend Colour", "escrowtics"),
					'callback'    => 'colourField',
					'page'        => 'escrowtics_public_appearance',
					'section'     => 'escrot_public_appearance_settings',
					'placeholder' => __("Select colour", "escrowtics"),
					'description' => __("Choose a secondary colour to match your brand or website", "escrowtics"),
					'divclasses'  => 'col-md-4 card shadow-lg p-3',
					'icon'        => 'palette'
				],
				[
					'id'          => 'custom_css',
					'title'       => __("Custom Css (frontend)", "escrowtics"),
					'callback'    => 'textareaField',
					'page'        => 'escrowtics_public_appearance',
					'section'     => 'escrot_public_appearance_settings',
					'placeholder' => __("Enter all your frontend custom css here", "escrowtics"),
					'description' => __("Add all custom CSS for frontend tracking results page", "escrowtics"),
					'divclasses'  => 'col-md-12 card shadow-lg p-3',
					'icon'        => 'code'
				],

				// Labels
				[
					'id'          => 'escrow_payer_label',
					'title'       => __('Payer', "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is 'Payer'", "escrowtics"),
					'description' => __("Enter text to replace escrow payer Label at frontend (e.g Buyer). Default is 'Payer'", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'money-bill'
				],
				[
					'id'          => 'escrow_earner_label',
					'title'       => __("Earner", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Earner", "escrowtics"),
					'description' => __("Enter text to replace escrow earner Label at frontend(e.g Seller). Default is Earner", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'hand-holding-usd'
				],
				[
					'id'          => 'escrow_detail_label',
					'title'       => __("Escrow Details", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Escrow Details", "escrowtics"),
					'description' => __("Enter text to replace escrow detail Label at frontend. Default is 'Escrow Details'", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-invoice-dollar'
				],
				[
					'id'          => 'escrow_table_label',
					'title'       => __("Escrow Table", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Escrow Table", "escrowtics"),
					'description' => __("Enter text to replace escrow table Label at frontend. Default label is Escrow Table", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'table'
				],
				[
					'id'          => 'earning_table_label',
					'title'       => __("Earnings Table", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Earnings Table", "escrowtics"),
					'description' => __("Enter text to replace earnings table Label at frontend. Default label is Earnings Table", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'table'
				],
				[
					'id'          => 'log_table_label',
					'title'       => __("Transaction Log", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Transaction Log", "escrowtics"),
					'description' => __("Enter text to replace transaction log table Label at frontend. Default label is Transaction Log", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'file-alt'
				],
				[
					'id'          => 'deposit_history_table_label',
					'title'       => __("Deposit History", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Deposit History", "escrowtics"),
					'description' => __("Enter text to replace deposit history table Label at frontend. Default label is Deposit History", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'arrow-circle-down'
				],
				[
					'id'          => 'withdraw_history_table_label',
					'title'       => __("Withdrawal History", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Withdrawal History", "escrowtics"),
					'description' => __("Enter text to replace withdrawal history table Label at frontend. Default label is Withdrawal History", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'arrow-circle-up'
				],
				[
					'id'          => 'escrow_list_label',
					'title'       => __("Escrow List", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is RECENT ESCROW COMMENTS", "escrowtics"),
					'description' => __("Enter text to replace escrow list metric Label at frontend. Default label is Escrow List", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'list'
				],
				[
					'id'          => 'earning_list_label',
					'title'       => __("Earning List", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is Earning List", "escrowtics"),
					'description' => __("Enter text to replace earning list metric Label at frontend. Default label is Earning List", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'list'
				],
				[
					'id'          => 'login_form_label',
					'title'       => __("User Login", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is User Login", "escrowtics"),
					'description' => __("Enter text to replace user login form Label at frontend. Default label is User Login", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'sign-in-alt'
				],
				[
					'id'          => 'signup_form_label',
					'title'       => __("User Signup", "escrowtics"),
					'callback'    => 'textField',
					'page'        => 'escrowtics_labels',
					'section'     => 'escrot_labels_settings',
					'placeholder' => __("Default label is User Signup", "escrowtics"),
					'description' => __("Enter text to replace user signup form Label at frontend. Default label is User Signup", "escrowtics"),
					'divclasses'  => 'col-md-6 p-3',
					'icon'        => 'user-plus'
				],
				
				// DB Backup Options
				[
					'id'          =>  'dbackup_log',
					'title'       =>  __("Enable Database Backup Log", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_dbbackup',
					'section'     =>  'escrot_dbbackup_settings',
					'placeholder' =>  "",
					'description' =>  __("Should a backup log file be viewable on the backup table?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'file-lines'
				],
				[
					'id'          =>  'auto_dbackup',
					'title'       =>  __("Enable Auto Database Backup", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_dbbackup',
					'section'     =>  'escrot_dbbackup_settings',
					'placeholder' =>  "",
					'description' =>  __("Should a backup be created automatically according to a defined schedule? If yes, please choose schedule below.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'rotate'
				],
				[
					'id'          =>  'auto_dbackup_freq',
					'title'       =>  __("Auto DB Backup Frequency", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_dbbackup',
					'section'     =>  'escrot_dbbackup_settings',
					'placeholder' =>  "",
					'description' =>  __("Choose the frequency of backups, how often do you want a backup to be created automatically?", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'calendar-days'
				],
				
				// Bitcoin Payment Options
				[
					'id'          =>  'enable_bitcoin_payment',
					'title'       =>  __("Bitcoin Payment (Via Blockomics API)", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_bitcoin_payment',
					'section'     =>  'escrot_bitcoin_payment_settings',
					'placeholder' =>  "",
					'description' =>  __("Want users to make deposits and withdrawals through bitcoin?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'btc fa-brands'
				],
				[
					'id'          =>  'blockonomics_api_key',
					'title'       =>  __("Blockomics API Key", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_bitcoin_payment',
					'section'     =>  'escrot_bitcoin_payment_settings',
					'placeholder' =>  "",
					'description' =>  __("Enter your Blockonomics API key. Required for bitcoin payment", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-4',
					'icon'        =>  'lock'
				],
				[
					'id'          =>  'escrot_blockonomics_enpoint_url',
					'title'       =>  __("Your Blockomics Endpoint URL", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_bitcoin_payment',
					'section'     =>  'escrot_bitcoin_payment_settings',
					'placeholder' =>  "",
					'description' =>  __("Blockomics URL. Use this to set up Bitcoin payment at https://blockomics.com/api", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'link'
				],
				
				// Paypal Payment Options
				[
					'id'          =>  'enable_paypal_payment',
					'title'       =>  __("Paypal Payment (Via Paypal API)", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_paypal_payment',
					'section'     =>  'escrot_paypal_payment_settings',
					'placeholder' =>  "",
					'description' =>  __("Want users to make deposits and withdrawals through PayPal?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'paypal'
				],
				[
					'id'          =>  'paypal_email',
					'title'       =>  __("Paypal Email", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_paypal_payment',
					'section'     =>  'escrot_paypal_payment_settings',
					'placeholder' =>  "",
					'description' =>  __("Enter your PayPal email", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'envelope'
				],
				
				// Invoice
				[
					'id'          =>  'enable_invoice_logo',
					'title'       =>  __("Show Company Logo On Invoices", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_invoice',
					'section'     =>  'escrot_invoice_settings',
					'placeholder' =>  "",
					'description' =>  __("Choose whether to display your company on invoice receipts", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'image'
				],
				
				// Commissions Options
				[
					'id'          =>  'commission_fees',
					'title'       =>  __("Commission Fee Option", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_commissions',
					'section'     =>  'escrot_commissions_settings',
					'placeholder' =>  "",
					'description' =>  __("Decides the commissions payment mode you prefer, flat amount or percentage?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'percent'
				],
				[
					'id'          =>  'commission_payer',
					'title'       =>  __("Who Pays Commissions?", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_commissions',
					'section'     =>  'escrot_commissions_settings',
					'placeholder' =>  "",
					'description' =>  __("Decides who pays commission & escrow creation fees for an escrow order, the Escrow Payer, Earner or both?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'user-group'
				],
				[
					'id'          =>  'commission_amount',
					'title'       =>  __("Flat Commission Fee ({escrot_currency})", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_commissions',
					'section'     =>  'escrot_commissions_settings',
					'placeholder' =>  __("Example: {escrot_currency}5.00", "escrowtics"),
					'description' =>  __("The fixed amount you want as commission for an escrow order", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3 collapse',
					'icon'        =>  'money-bill'
				],
				[
					'id'          =>  'commission_percentage',
					'title'       =>  __("Commission Percentage ({escrot_currency})", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_commissions',
					'section'     =>  'escrot_commissions_settings',
					'placeholder' =>  __("Example: 2%", "escrowtics"),
					'description' =>  __("The percentage of the total escrow amount you want as commission for an escrow order", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3 collapse',
					'icon'        =>  'percent'
				],
				
				// Commission Threshold
				[
					'id'          =>  'enable_min_commission',
					'title'       =>  __("Enable Minimum Commission Amount?", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_commissions_threshold',
					'section'     =>  'escrot_commissions_threshold_settings',
					'placeholder' =>  "",
					'description' =>  __("Allows you to set a minimum commission amount that must be charged per transaction. Revert to this amount if percentage calculated (on the sum of commissions, commission tax and escrow fees) is inferior to it. If transaction amount is less than the minimum amount, escrow order will not be placed", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'hand-holding-dollar'
				],
				[
					'id'          =>  'enable_max_commission',
					'title'       =>  __("Enable Maximum Commission Amount?", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_commissions_threshold',
					'section'     =>  'escrot_commissions_threshold_settings',
					'placeholder' =>  "",
					'description' =>  __("Allows you to set a maximum commission amount that must be charged per transaction. Revert to this amount if percentage calculated (on the sum of commissions, commission tax and escrow fees)  is greater than it.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'hand-holding-dollar'
				],
				[
					'id'          =>  'min_commission_amount',
					'title'       =>  __("Minimum Commission Amount ({escrot_currency})", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_commissions_threshold',
					'section'     =>  'escrot_commissions_threshold_settings',
					'placeholder' =>  "",
					'description' =>  __("A minimum commission amount that must be charged per transaction. Revert to this amount if percentage calculated is inferior to it. If transaction amount is less than the minimum amount, escrow order will not be placed", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'hand-holding-dollar'
				],
				[
					'id'          =>  'max_commission_amount',
					'title'       =>  __("Maximum Commission Amount ({escrot_currency})", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_commissions_threshold',
					'section'     =>  'escrot_commissions_threshold_settings',
					'placeholder' =>  "",
					'description' =>  __("A cap on the maximum commission amount that can be charged per transaction. Revert to this amount if percentage calculated exceeds it.", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'hand-holding-dollar'
				],

				// Commission Tax
				[
					'id'          =>  'commission_tax_fees',
					'title'       =>  __("Commission Tax Fee Option", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_commissions_tax',
					'section'     =>  'escrot_commissions_tax_settings',
					'placeholder' =>  "",
					'description' =>  __("Decides the commissions tax payment type you prefer, flat amount or percentage?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'hand-holding-dollar'
				],
				[
					'id'          =>  'commission_tax_description',
					'title'       =>  __("Describe the Tax to add on the Commission", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_commissions_tax',
					'section'     =>  'escrot_commissions_tax_settings',
					'placeholder' =>  "",
					'description' =>  __("Describe what tax you will add on the commission, e.g., VAT, GST..etc", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'file-invoice-dollar'
				],
				[
					'id'          =>  'commission_tax_amount',
					'title'       =>  __("Fixed Tax Amount ({escrot_currency})", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_commissions_tax',
					'section'     =>  'escrot_commissions_tax_settings',
					'placeholder' =>  __("Example: 2.00", "escrowtics"),
					'description' =>  __("Taxable amount to add on commission charged", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3 collapse',
					'icon'        =>  'money-bill-wave'
				],
				[
					'id'          =>  'commission_tax_percentage',
					'title'       =>  __("Tax Percentage", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_commissions_tax',
					'section'     =>  'escrot_commissions_tax_settings',
					'placeholder' =>  __("Example: 0.2%", "escrowtics"),
					'description' =>  __("Taxable percentage of the transaction amount to add on commission charged", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3 collapse',
					'icon'        =>  'percent'
				],

				// Disputes
				[
					'id'          =>  'dispute_time',
					'title'       =>  __("Dispute Triggers and Conditions", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_disputes',
					'section'     =>  'escrot_disputes_settings',
					'placeholder' =>  "",
					'description' =>  __("Allow disputes at all times or only after a certain time period has elapsed since the transaction started.", "escrowtics"),
					'divclasses'  =>  'col-md-4 card shadow-lg p-3',
					'icon'        =>  'hourglass-half'
				],
				[
					'id'          =>  'dispute_initiator',
					'title'       =>  __("Dispute Initiator", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_disputes',
					'section'     =>  'escrot_disputes_settings',
					'placeholder' =>  "",
					'description' =>  __("Define who can initiate a dispute (e.g., payer, earner, both).", "escrowtics"),
					'divclasses'  =>  'col-md-4 card shadow-lg p-3',
					'icon'        =>  'user-shield'
				],
				[
					'id'          =>  'dispute_fees',
					'title'       =>  __("Dispute Fees", "escrowtics"),
					'callback'    =>  'selectField',
					'page'        =>  'escrowtics_disputes',
					'section'     =>  'escrot_disputes_settings',
					'placeholder' =>  "",
					'description' =>  __("Charge a fee to resolve disputes ?", "escrowtics"),
					'divclasses'  =>  'col-md-4 card shadow-lg p-3 dispute_fees',
					'icon'        =>  'gavel'
				],
				[
					'id'          =>  'dispute_fee_amount',
					'title'       =>  __("Dispute Fee Fixed Amount ({escrot_currency})", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_disputes',
					'section'     =>  'escrot_disputes_settings',
					'placeholder' =>  __("e.g. 5.00", "escrowtics"),
					'description' =>  __("Fixed fee for initiating a dispute.", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3 collapse',
					'icon'        =>  'money-check-dollar'
				],
				[
					'id'          =>  'dispute_fee_percentage',
					'title'       =>  __("Dispute Fee Percentage", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_disputes',
					'section'     =>  'escrot_disputes_settings',
					'placeholder' =>  __("e.g. 1", "escrowtics"),
					'description' =>  __("percentage of the escrow amount for dispute resolution.", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3 collapse',
					'icon'        =>  'percent'
				],
				[
					'id'          =>  'dispute_reasons',
					'title'       =>  __("Reasons for Dispute", "escrowtics"),
					'callback'    =>  'textareaField',
					'page'        =>  'escrowtics_disputes',
					'section'     =>  'escrot_disputes_settings',
					'placeholder' =>  __("Enter the reasons as a comma-separated list", "escrowtics"),
					'description' =>  __("Define the main reasons users may initiate a dispute...", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'list'
				],
				[
					'id'          =>  'dispute_resolutions',
					'title'       =>  __("Dispute Resolution Options", "escrowtics"),
					'callback'    =>  'textareaField',
					'page'        =>  'escrowtics_disputes',
					'section'     =>  'escrot_disputes_settings',
					'placeholder' =>  __("Enter the resolution outcomes as a comma-separated list", "escrowtics"),
					'description' =>  __("Configure the list of available resolution options...", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'scale-balanced'
				], 

				// Dispute file upload
				[
					'id'          =>  'enable_dispute_evidence',
					'title'       =>  __("Evidence Upload", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_disputes_file',
					'section'     =>  'escrot_disputes_file_settings',
					'placeholder' =>  "",
					'description' =>  __("Allow users to upload supporting documents...", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'upload'
				],
				[
					'id'          =>  'dispute_evidence_file_size',
					'title'       =>  __("Evidence Upload File limit(MB)", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_disputes_file',
					'section'     =>  'escrot_disputes_file_settings',
					'placeholder' =>  __("Enter Limit in MB", "escrowtics"),
					'description' =>  __("Set a limit on evidence upload file size", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'file-archive'
				],
				[
					'id'          =>  'dispute_evidence_file_types',
					'title'       =>  __("Evidence Upload File Types", "escrowtics"),
					'callback'    =>  'multSelectField',
					'page'        =>  'escrowtics_disputes_file',
					'section'     =>  'escrot_disputes_file_settings',
					'placeholder' =>  "",
					'description' =>  __("Set a limit on evidence upload file types.", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'file-circle-check'
				],

				// Advanced Options
				[
					'id'          =>  'enable_rest_api',
					'title'       =>  __("Share Data via REST API?", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_advanced',
					'section'     =>  'escrot_advanced_settings',
					'placeholder' =>  "",
					'description' =>  __("Allow REST API Endpoint requests", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'cloud-arrow-up'
				],
				[
					'id'          =>  'enable_rest_api_key',
					'title'       =>  __("Require API Key for REST API Access?", "escrowtics"),
					'callback'    =>  'checkboxField',
					'page'        =>  'escrowtics_advanced',
					'section'     =>  'escrot_advanced_settings',
					'placeholder' =>  "",
					'description' =>  __("Want to authenticate REST API Endpoint data request with a key?", "escrowtics"),
					'divclasses'  =>  'col-md-6 card shadow-lg p-3',
					'icon'        =>  'key'
				],
				[
					'id'          =>  'rest_api_key',
					'title'       =>  __("REST API key for Escrowtics", "escrowtics"),
					'callback'    =>  'textField',
					'page'        =>  'escrowtics_advanced',
					'section'     =>  'escrot_advanced_settings',
					'placeholder' =>  "",
					'description' =>  __("Create API key for REST API endpoint authentication.", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'key'
				],
				[
					'id'          =>  'rest_api_endpoint_urls',
					'title'       =>  __("REST API Endpoint URLs", "escrowtics"),
					'callback'    =>  'textareaField',
					'page'        =>  'escrowtics_advanced',
					'section'     =>  'escrot_advanced_settings',
					'placeholder' =>  "",
					'description' =>  __("REST API custom Endpoint URLs.", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'link'
				],
				[
					'id'          =>  'rest_api_data',
					'title'       =>  __("Select Data Type to Share Via REST API", "escrowtics"),
					'callback'    =>  'multSelectField',
					'page'        =>  'escrowtics_advanced',
					'section'     =>  'escrot_advanced_settings',
					'placeholder' =>  "",
					'description' =>  __("Choose specific shelter data to share via your REST API Endpoint.", "escrowtics"),
					'divclasses'  =>  'col-md-12 card shadow-lg p-3',
					'icon'        =>  'database'
				]

			];
	 }

	 
	public function sections() {	
		
		//Setting Sections
		return [
			[
				'id'    => 'escrot_general_settings',
				'title' => __('General Settings', 'escrowtics'),
				'page'  => 'escrowtics_general'
			],
			[
				'id'    => 'escrot_admin_appearance_settings',
				'title' => __('Admin Appearance Settings', 'escrowtics'),
				'page'  => 'escrowtics_admin_appearance'
			],
			[
				'id'    => 'escrot_public_appearance_settings',
				'title' => __('Frontend Appearance Settings', 'escrowtics'),
				'page'  => 'escrowtics_public_appearance'
			],
			[
				'id'    => 'escrot_backend_escrow_settings',
				'title' => __('Escrow Settings', 'escrowtics'),
				'page'  => 'escrowtics_backend_escrow'
			],
			[
				'id'    => 'escrot_email_settings',
				'title' => __('Email Notification Settings', 'escrowtics'),
				'page'  => 'escrowtics_email'
			],
			[
				'id'    => 'escrot_dbbackup_settings',
				'title' => __('Database Backup', 'escrowtics'),
				'page'  => 'escrowtics_dbbackup'
			],
			[
				'id'    => 'escrot_bitcoin_payment_settings',
				'title' => __('Bitcoin Payment', 'escrowtics'),
				'page'  => 'escrowtics_bitcoin_payment'
			],
			[
				'id'    => 'escrot_paypal_payment_settings',
				'title' => __('Paypal Payment', 'escrowtics'),
				'page'  => 'escrowtics_paypal_payment'
			],
			[
				'id'    => 'escrot_commissions_settings',
				'title' => __('General Commissions Settings', 'escrowtics'),
				'page'  => 'escrowtics_commissions'
			],
			[
				'id'    => 'escrot_disputes_settings',
				'title' => __('Disputes', 'escrowtics'),
				'page'  => 'escrowtics_disputes'
			], 
			[
				'id'    => 'escrot_advanced_settings',
				'title' => __('Advanced', 'escrowtics'),
				'page'  => 'escrowtics_advanced'
			],
			// Section Groups
			[
				'id'    => 'escrot_smtp_settings',
				'title' => __('Custom SMTP Setup', 'escrowtics'),
				'page'  => 'escrowtics_smtp'
			],
			[
				'id'    => 'escrot_company_logo_settings',
				'title' => __('Company Logo', 'escrowtics'),
				'page'  => 'escrowtics_company_logo'
			],
			[
				'id'    => 'escrot_user_escrow_email_settings',
				'title' => __('Front User Email Settings', 'escrowtics'),
				'page'  => 'escrowtics_user_escrow_email'
			],
			[
				'id'    => 'escrot_admin_escrow_email_settings',
				'title' => __('Admin Email Settings', 'escrowtics'),
				'page'  => 'escrowtics_admin_escrow_email'
			],
			[
				'id'    => 'escrot_labels_settings',
				'title' => __('Custom Labels (Change all default labels at the frontend)', 'escrowtics'),
				'page'  => 'escrowtics_labels'
			],
			[
				'id'    => 'escrot_ref_id_settings',
				'title' => __('Reference ID/Number Options', 'escrowtics'),
				'page'  => 'escrowtics_ref_id'
			],
			[
				'id'    => 'escrot_escrow_fees_settings',
				'title' => __('Escrow Fees & Charges', 'escrowtics'),
				'page'  => 'escrowtics_escrow_fees'
			],
			[
				'id'    => 'escrot_commissions_tax_settings',
				'title' => __('Tax and Additional Charges', 'escrowtics'),
				'page'  => 'escrowtics_commissions_tax'
			],
			[
				'id'    => 'escrot_commissions_threshold_settings',
				'title' => __('Commissions Threshold Settings', 'escrowtics'),
				'page'  => 'escrowtics_commissions_threshold'
			],
			[
				'id'    => 'escrot_disputes_file_settings',
				'title' => __('Dispute Evidence File Upload', 'escrowtics'),
				'page'  => 'escrowtics_disputes_file'
			],
			[
				'id'    => 'escrot_invoice_settings',
				'title' => __('Invoice Settings', 'escrowtics'),
				'page'  => 'escrowtics_invoice'
			]
		];

    }
	
	
}
