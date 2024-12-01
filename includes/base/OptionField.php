<?php 
/**
 * Option Fields Class
 * Defines parameters for all option fields
 * Since  1.0.0.
 * @package  Escrowtics
 */
	
	namespace Escrowtics\base;
	
    class OptionField extends DefaultOptions {
		
	    public $options = array();
        public $sections = array();
		
	    public function __construct() {


            /* Setting Optionss */
			
			$this->options = array(
			
                //General Options
			    array(
                   "id" => "plugin_interaction_mode",
                   "title" => "Plugin Interaction Mode",
                   "section" => "escrot_general_settings",
                   "page" => "escrowtics-general",
                   "placeholder" => "",  "icon" => "code-compare",
                   "callback" => "selectField",
                   "divclasses" => "col-md-6 p-3 card shadow-lg setTogg",
                   "description" => "Choose the general plugin interraction mode. Options include, Normal flow (page to page) and Sleek Modal Popups, which allow interaction in he form of sleek popups to complete tasks. Default is page to page. Note: Modal popup for settings panel is not available on mobile devices"
                ),
			    array(
                   "id" => "access_role",
                   "title" => "Plugin Access Role",
                   "section" => "escrot_general_settings",
                   "page" => "escrowtics-general",
                   "placeholder" => "",  "icon" => "lock",
                   "callback" => "selectField",
                   "divclasses" => "col-md-6 p-3 card shadow-lg setTogg",
                   "description" => "Choose which other admin user role other than Administrators, has access to the plugin menu link and interface. NB: Administrators are granted access by default. Also, only administrators can alter plugin settings"
                ),
			    array(
                   "id" => "currency",
                   "title" => "Currency",
                   "section" => "escrot_general_settings",
                   "page" => "escrowtics-general",
                   "placeholder" => "",  "icon" => "euro",
                   "callback" => "selectField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Set a default currency for the plugin (default is USD)"
                ),
			    array(
                   "id" => "timezone",
                   "title" => "Timezone",
                   "section" => "escrot_general_settings",
                   "page" => "escrowtics-general",
                   "placeholder" => "",  "icon" => "clock",
                   "callback" => "selectField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Set a default timezone for the plugin (default is: UTC GMT+0:00)"
                ),
			    array(
                   "id" => "company_address",
                   "title" => "Company Address",
                   "section" => "escrot_general_settings",
                   "page" => "escrowtics-general",
                   "placeholder" => "Enter company address",  "icon" => "map-marker",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Enter the formal address of Your Company (used to Populate Email/invoice/waybill headers & footers)"
                ),
			    array(
                   "id" => "company_phone",
                   "title" => "Company Phone",
                   "section" => "escrot_general_settings",
                   "page" => "escrowtics-general",
                   "placeholder" => "Enter company phone",  "icon" => "phone",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Enter your Company's Office phone (used to Populate Email/invoice/waybill headers & footers)"
                ),
			    array(
                   "id" => "company_logo",
                   "title" => "Company Logo",
                   "section" => "escrot_general_settings",
                   "page" => "escrowtics-general",
                   "placeholder" => "",  "icon" => "image",
                   "callback" => "fileField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Upload your company logo (will be displayed on tracking results page, invoices and waybills). Desired size: 156 x 36px"
                ),
			    array(
                   "id" => "logo_width",
                   "title" => "Logo Width",
                   "section" => "escrot_company_logo_size",
                   "page" => "escrowtics-logo-size-settings",
                   "placeholder" => "Enter width in px",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Define a suitable Logo width (in pixels) for your logo"
                ),
			    array(
                   "id" => "logo_height",
                   "title" => "Logo Height",
                   "section" => "escrot_company_logo_size",
                   "page" => "escrowtics-logo-size-settings",
                   "placeholder" => "Enter height in px",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Define a suitable Logo height (in pixels) for your logo"
                ),
			   
			    //Escrow Options
				
				array(
                   "id" => "escrow_form_style",
                   "title" => "Order Form Style",
                   "section" => "escrot_backend_escrow_settings",
                   "page" => "escrowtics-backend-escrow",
                   "placeholder" => "",  "icon" => "circle-dollar-to-slot",
                   "callback" => "selectField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Select the escrow form style for adding and editing escrows, options include simple flow and tabs"
                ),
				//Reference ID
				 array(
                   "id" => "refid_length",
                   "title" => "Reference ID Length",
                   "section" => "escrot_ref_id_settings",
                   "page" => "escrowtics-ref-id",
                   "placeholder" => "enter a digit..e.g 12.",  "icon" => "pen-ruler",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3 refid_length",
                   "description" => "Enter desired autogenerated reference ID length (number of characters..e.g 14) this will be used to auto generate reference IDs for escrows. The default length is 12 digits. Note: Reference ID is a unique identifier escrows."
                ),
				array(
                   "id" => "refid_xter_type",
                   "title" => "Reference ID Character Type",
                   "section" => "escrot_ref_id_settings",
                   "page" => "escrowtics-ref-id",
                   "placeholder" => "enter a digit..e.g 12.",  "icon" => "arrow-up-a-z",
                   "callback" => "selectField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3 refid_xter_type",
                   "description" => "Select the desired character type for autogenerated reference id (e.g. numeric, alphanumeric..etc). This will be used to auto generate the reference IDs for escrows. Default is Numeric"
                ),
			    
			   //Email Options
			    array(
                   "id" => "company_email",
                   "title" => "Admin/Company Email",
                   "section" => "escrot_email_settings",
                   "page" => "escrowtics-emails",
                   "placeholder" => "Enter company email, default is WP admin email",  "icon" => "envelope",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter Your Company's Email Address (Used as Sender Email Address, Default is WP admin Email)"
                ),
			    array(
                   "id" => "user_new_escrow_email",
                   "title" => "Notify Users on Escrow Creation",
                   "section" => "escrot_email_settings",
                   "page" => "escrowtics-emails",
                   "placeholder" => "",  "icon" => "envelope-open-text",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Should users receive email notification when their escrows are generated?"
                ),
				array(
                   "id" => "user_new_milestone_email",
                   "title" => "Notify Users on Adding Escrow Milestone",
                   "section" => "escrot_email_settings",
                   "page" => "escrowtics-emails",
                   "placeholder" => "",  "icon" => "envelope-open-text",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Should users receive email notification when their escrow is modified/updated?"
                ),
				array(
                   "id" => "admin_new_escrow_email",
                   "title" => "Notify Admin on Escrow Creation",
                   "section" => "escrot_email_settings",
                   "page" => "escrowtics-emails",
                   "placeholder" => "",  "icon" => "envelope-open-text",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Should users receive email notification when their escrows are generated?"
                ),
				array(
                   "id" => "admin_new_milestone_email",
                   "title" => "Notify Admin on Adding Escrow Milestone",
                   "section" => "escrot_email_settings",
                   "page" => "escrowtics-emails",
                   "placeholder" => "",  "icon" => "envelope-open-text",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Should admin receive email notification an escrow is modified/updated?"
                ),
			    array(
                   "id" => "notify_admin_by_email",
                   "title" => "Send Admin Notifications as Email",
                   "section" => "escrot_email_settings",
                   "page" => "escrowtics-emails",
                   "placeholder" => "",  "icon" => "envelope-open-text",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Receive an email equivalent of admin notifications. These include, nofication of tracking attempts, user assignments, user responses..etc"
                ),
			    array(
                   "id" => "smtp_protocol",
                   "title" => "Send Emails Through Custom SMTP",
                   "section" => "escrot_email_settings",
                   "page" => "escrowtics-emails",
                   "placeholder" => "",  "icon" => "shield",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Check to send emails with custom SMTP instead of the default wordpress mail function. If so, please setup the custom SMTP below."
                ),
			    array(
                   "id" => "smtp_host",
                   "title" => "Smtp Host",
                    "section" => "escrot_smtp_details",
                   "page" => "escrowtics-smtp-settings",
                   "placeholder" => "Enter SMTP host address",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter Custom SMTP Host ( e.g. smtp.example.com )"
                ),
			    array(
                   "id" => "smtp_user",
                   "title" => "Smtp User",
                    "section" => "escrot_smtp_details",
                   "page" => "escrowtics-smtp-settings",
                   "placeholder" => "Enter SMTP username..e.g email@example.com",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter Username ( e.g email@example.com )"
                ),
			    array(
                   "id" => "smtp_pass",
                   "title" => "Smtp Password",
                    "section" => "escrot_smtp_details",
                   "page" => "escrowtics-smtp-settings",
                   "placeholder" => "Enter SMTP password",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter Email Account Password"
                ),
			    array(
                   "id" => "smtp_port",
                   "title" => "Smtp Port",
                   "section" => "escrot_smtp_details",
                   "page" => "escrowtics-smtp-settings",
                   "placeholder" => "Enter SMTP port..e.g 587",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter SMTP Port ( e.g 587)"
                ),
			    array(
                   "id" => "user_new_escrow_email_subject",
                   "title" => "Email Subject on Escrow Creation",
                   "section" => "escrot_user_escrow_email",
                   "page" => "escrowtics-user-escrow-email",
                   "placeholder" => "Enter email subject",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email subject to be used for email notification upon adding an escrow"
                ),
			    array(
                   "id" => "user_new_milestone_email_subject",
                   "title" => "Email Subject on Adding Escrow Milestone",
                   "section" => "escrot_user_escrow_email",
                   "page" => "escrowtics-user-escrow-email",
                   "placeholder" => "Enter email subject",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email subject to be used for email notification upon updating/modifying an escrow"
                ),
				 array(
                   "id" => "user_new_escrow_email_body",
                   "title" => "Email Body Upon Adding Escrow",
                   "section" => "escrot_user_escrow_email",
                   "page" => "escrowtics-user-escrow-email",
                   "placeholder" => "Enter email body..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email body to be used for email notification upon adding an escrow"
                ),
			    array(
                   "id" => "user_new_milestone_email_body",
                   "title" => "Email Body Upon Adding Escrow Milestone",
                   "section" => "escrot_user_escrow_email",
                   "page" => "escrowtics-user-escrow-email",
                   "placeholder" => "Enter email body..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email body to be used for email notification upon updating/modifying an escrow"
                ),
				 array(
                   "id" => "user_new_escrow_email_footer",
                   "title" => "Email Footer Upon Adding Escrow",
                   "section" => "escrot_user_escrow_email",
                   "page" => "escrowtics-user-escrow-email",
                   "placeholder" => "Enter email footer content..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter footer content to be used for email notification upon adding an escrow"
                ),
			    array(
                   "id" => "user_new_milestone_email_footer",
                   "title" => "Email Footer Upon Adding Escrow Milestone",
                   "section" => "escrot_user_escrow_email",
                   "page" => "escrowtics-user-escrow-email",
                   "placeholder" => "Enter email footer content..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter footer content to be used for email notification upon updating/modifying an escrow"
                ),
				array(
                   "id" => "admin_new_escrow_email_subject",
                   "title" => "Email Subject Upon Adding Escrow",
                   "section" => "escrot_admin_escrow_email",
                   "page" => "escrowtics-admin-escrow-email",
                   "placeholder" => "Enter email subject",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email subject to be used for admin email notification upon adding an escrow"
                ),
			    array(
                   "id" => "admin_new_milestone_email_subject",
                   "title" => "Email Subject Upon Adding Escrow Milestone",
                   "section" => "escrot_admin_escrow_email",
                   "page" => "escrowtics-admin-escrow-email",
                   "placeholder" => "Enter email subject",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email subject to be used for admin email notification upon updating/modifying an escrow"
                ),
				 array(
                   "id" => "admin_new_escrow_email_body",
                   "title" => "Email Body Upon Adding Escrow",
                   "section" => "escrot_admin_escrow_email",
                   "page" => "escrowtics-admin-escrow-email",
                   "placeholder" => "Enter email body..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email body to be used for admin email notification upon adding an escrow"
                ),
			    array(
                   "id" => "admin_new_milestone_email_body",
                   "title" => "Email Body Upon Adding Escrow Milestone",
                   "section" => "escrot_admin_escrow_email",
                   "page" => "escrowtics-admin-escrow-email",
                   "placeholder" => "Enter email body..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter email body to be used for admin email notification upon updating/modifying an escrow"
                ),
				 array(
                   "id" => "admin_new_escrow_email_footer",
                   "title" => "Email Footer Upon Adding Escrow",
                   "section" => "escrot_admin_escrow_email",
                   "page" => "escrowtics-admin-escrow-email",
                   "placeholder" => "Enter email footer content..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter footer content to be used for admin email notification upon adding an escrow"
                ),
			    array(
                   "id" => "admin_new_milestone_email_footer",
                   "title" => "Email Footer  Upon Adding Escrow Milestone",
                   "section" => "escrot_admin_escrow_email",
                   "page" => "escrowtics-admin-escrow-email",
                   "placeholder" => "Enter email footer content..",  "icon" => "",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter footer content to be used for admin email notification upon updating/modifying an escrow"
                ),
			    //Styling/Appearance Options
				array(
                   "id" => "theme_class",
                   "title" => "Admin Theme Colour Scheme",
                   "section" => "escrot_admin_appearance_settings",
                   "page" => "escrowtics-admin-appearance",
                   "placeholder" => "",  "icon" => "palette",
                   "callback" => "selectField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Choose between light and dark theme colour schemes"
                ),
				array(
                   "id" => "admin_nav_style",
                   "title" => "Admin Navigation Menu Style",
                   "section" => "escrot_admin_appearance_settings",
                   "page" => "escrowtics-admin-appearance",
                   "placeholder" => "",  "icon" => "palette",
                   "callback" => "selectField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Choose desired admin navigation menu style"
                ),
				array(
                   "id" => "fold_wp_menu",
                   "title" => "Fold WP Menu while Using Plugin",
                   "section" => "escrot_admin_appearance_settings",
                   "page" => "escrowtics-admin-appearance",
                   "placeholder" => "",  "icon" => "minimize",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Keep Wordpress menu folded while using this plugin?.. You will still be able to expand & fold it manually."
                ),
				array(
                   "id" => "fold_escrot_menu",
                   "title" => "Fold Escrowtics Menu (Sidebar Menu)",
                   "section" => "escrot_admin_appearance_settings",
                   "page" => "escrowtics-admin-appearance",
                   "placeholder" => "",  "icon" => "minimize",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Keep Escrowtics menu folded (show only icon menu bar with details on hover)?.. You will still be able to expand & fold it manually. Works only with vertical navigation (sidebar menu)."
                ),
				//Frontend Styling
			    array(
                   "id" => "primary_color",
                   "title" => "Primary Frontend Colour",
                   "section" => "escrot_public_appearance_settings",
                   "page" => "escrowtics-public-appearance",
                   "placeholder" => "Select colour",  "icon" => "code",
                   "callback" => "colourField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Choose a primary colour to match your brand or website"
                ),
				 array(
                   "id" => "secondary_color",
                   "title" => "Secondary Frontend Colour",
                   "section" => "escrot_public_appearance_settings",
                   "page" => "escrowtics-public-appearance",
                   "placeholder" => "Select colour",  "icon" => "code",
                   "callback" => "colourField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Choose a secondary colour to match your brand or website"
                ),
				array(
                   "id" => "custom_css",
                   "title" => "Custom Css (frontend)",
                   "section" => "escrot_public_appearance_settings",
                   "page" => "escrowtics-public-appearance",
                   "placeholder" => "enter all your frontend custom css here",  "icon" => "code",
                   "callback" => "textareaField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Add all custom CSS for frontend tracking results page"
                ),
			   //Labels
			    array(
                   "id" => "escrow_detail_label",
                   "title" => "Escrow Details",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is 'Escrow Details'",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace escrow detail Label at frontend. Default is 'Escrow Details'"
                ),
 			    array(
                   "id" => "escrow_table_label",
                   "title" => "Escrow Table",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is Escrow Table",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace escrow table Label at frontend. Default label is Escrow Table"
                ),
			    array(
                   "id" => "earning_table_label",
                   "title" => "Earnings Table",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is Earnings Table",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace earnings table Label at frontend. Default label is Earnings Table"
                ),
			    array(
                   "id" => "log_table_label",
                   "title" => "Transaction Log",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is Transaction Log",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace transaction log table Label at frontend. Default label is Transaction Log"
                ),
			    array(
                   "id" => "deposit_history_table_label",
                   "title" => "Deposit History",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is Deposit History",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace deposit history table Label at frontend. Default label is Deposit History"
                ),
			    array(
                   "id" => "withdraw_history_table_label",
                   "title" => "Withdrawal History",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is Withdrawal History",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace withdrawal history table Label at frontend. Default label is Withdrawal History"
                ),
			    array(
                   "id" => "escrow_list_label",
                   "title" => "Escrow List",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is RECENT ESCROW COMMENTS",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace escrow list metric Label at frontend. Default label is Escrow List"
                ),
			    array(
                   "id" => "earning_list_label",
                   "title" => "Earning List",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is Earning List",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace earning list metric Label at frontend. Default label is Earning List"
                ),
			    array(
                   "id" => "login_form_label",
                   "title" => "User Login",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is User Login",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace user login form Label at frontend. Default label is User Login"
                ),
			    array(
                   "id" => "signup_form_label",
                   "title" => "User Signup",
                   "section" => "escrot_label_settings",
                   "page" => "escrowtics-labels",
                   "placeholder" => "Default label is User Signup",  "icon" => "",
                   "callback" => "textField",
                   "divclasses" => "col-md-6 p-3",
                   "description" => "Enter text to replace user signup form Label at frontend. Default label is User Signup"
                ),
			    
			   //DB Backup Options
			    array(
                   "id" => "dbackup_log",
                   "title" => "Enable Database Backup Log",
                   "section" => "escrot_dbbackup_settings",
                   "page" => "escrowtics-db",
                   "placeholder" => "",  "icon" => "list",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Should a backup log file be viewable on the backup table?."
                ),
			    array(
                   "id" => "auto_dbackup",
                   "title" => "Enable Auto Database Backup",
                   "section" => "escrot_dbbackup_settings",
                   "page" => "escrowtics-db",
                   "placeholder" => "",  "icon" => "sync",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Should a backup be created automatically according a defined schedule? if yes, please choose schedule below."
                ),
			    array(
                   "id" => "auto_db_freq",
                   "title" => "Auto DB Backup Frequency",
                   "section" => "escrot_dbbackup_settings",
                   "page" => "escrowtics-db",
                   "placeholder" => "",  "icon" => "clock",
                   "callback" => "selectField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3 auto_db_freq",
                   "description" => "Choose the frequency of backups, how often do you want a backup to be created automatically? If feasible, use the widest interval possible to reduce server load."
                ),
			    //Payments
			    array(
                   "id" => "enable_bitcoin_payment",
                   "title" => "Bitcoin Payment (Via Blockomics API)",
                   "section" => "escrot_payment_settings",
                   "page" => "escrowtics-payment",
                   "placeholder" => "",  "icon" => "bitcoin-sign",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Want users to made deposits and withdrawals through bitcoin?"
                ),
			    array(
                   "id" => "enable_paypal_payment",
                   "title" => "Paypal Payment (Via Paypal API)",
                   "section" => "escrot_payment_settings",
                   "page" => "escrowtics-payment",
                   "placeholder" => "",  "icon" => "paypal",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Want users to made deposits and withdrawals through paypal?"
                ),
			    array(
                   "id" => "blockonomics_api_key",
                   "title" => "Blockomics API Key",
                   "section" => "escrot_payment_settings",
                   "page" => "escrowtics-payment",
                   "placeholder" => "",  "icon" => "key",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-4 blockonomics_api_key",
                   "description" => "Enter your Blockonomics API key. Required for bitcoin payment"
               ),
			   array(
                   "id" => "escrot_blockonomics_enpoint_url",
                   "title" => "Your Blockomics Enpoint URL",
                   "section" => "escrot_payment_settings",
                   "page" => "escrowtics-payment",
                   "placeholder" => "",  "icon" => "link",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Blockomics URL. Use this to setup bitcoin your payment at https://blockomics.com/api"
                ),
			    array(
                   "id" => "paypal_email",
                   "title" => "Paypal Email",
                   "section" => "escrot_payment_settings",
                   "page" => "escrowtics-payment",
                   "placeholder" => "",  "icon" => "envelope",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Enter your paypal email"
               ),
               //Advanced
			    array(
                   "id" => "enable_rest_api",
                   "title" => "Share Plugin Data via REST API?",
                   "section" => "escrot_advanced_settings",
                   "page" => "escrowtics-advanced",
                   "placeholder" => "",  "icon" => "share-nodes",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Want to send plugin REST API Enpoint data through HTTPS Request ?"
                ),
				array(
                   "id" => "enable_rest_api_key",
                   "title" => "Require API Key for REST API Access ?",
                   "section" => "escrot_advanced_settings",
                   "page" => "escrowtics-advanced",
                   "placeholder" => "",  "icon" => "key",
                   "callback" => "checkboxField",
                   "divclasses" => "col-md-6 card shadow-lg setTogg p-3",
                   "description" => "Want to authenticate REST API Enpoint data Request with a key ?"
                ),
			    array(
                   "id" => "rest_api_key",
                   "title" => "Your REST API key for Escrowtics",
                   "section" => "escrot_advanced_settings",
                   "page" => "escrowtics-advanced",
                   "placeholder" => "",  "icon" => "key",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Create API key for custom REST API endpoint authentication. Block unauthorized access to plugin REST API data"
                ), 
				array(
                   "id" => "rest_api_enpoint_url",
                   "title" => "Your REST API Enpoint URL",
                   "section" => "escrot_advanced_settings",
                   "page" => "escrowtics-advanced",
                   "placeholder" => "",  "icon" => "link",
                   "callback" => "textField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "REST API custom Endpoint url. Do not share to unauthorized users!!"
                ), 
                 array(
                   "id" => "rest_api_data",
                   "title" => "Select Custom Data to Send Via Rest API",
                   "section" => "escrot_advanced_settings",
                   "page" => "escrowtics-advanced",
                   "placeholder" => "",  "icon" => "list-check",
                   "callback" => "multSelectField",
                   "divclasses" => "col-md-12 card shadow-lg setTogg12 p-3",
                   "description" => "Choose specific data to share via your REST API Enpoint"
                )			
	

			
		   );	
		
		
		
		
			
		    /* Setting Sections */
			
		    $this->sections = array(
			
			    array(
				    'id' => 'escrot_general_settings',
				    'title' => 'General Setings',
				    'page' => 'escrowtics-general'
			    ),
				array(
				    'id' => 'escrot_admin_appearance_settings',
				    'title' => 'Admin Appearance Settings',
				    'page' => 'escrowtics-admin-appearance'
			    ),
				array(
				    'id' => 'escrot_public_appearance_settings',
				    'title' => 'Frontend Appearance Settings',
				    'page' => 'escrowtics-public-appearance'
			    ),
				array(
				    'id' => 'escrot_backend_escrow_settings',
				    'title' => 'Escrow Settings',
				    'page' => 'escrowtics-backend-escrow'
			    ),
				
				array(
				    'id' => 'escrot_email_settings',
				    'title' => 'Email Notification Settings',
				    'page' => 'escrowtics-emails'
			    ),
				array(
				    'id' => 'escrot_dbbackup_settings',
				    'title' => 'DB Backup Setings',
				    'page' => 'escrowtics-db'
			    ),
				array(
				    'id' => 'escrot_payment_settings',
				    'title' => 'Payment Settings',
				    'page' => 'escrowtics-payment'
			    ),
				array(
				    'id' => 'escrot_advanced_settings',
				    'title' => 'Advanced Setings',
				    'page' => 'escrowtics-advanced'
			    ),
				//Section Groups
				array(
				    'id' => 'escrot_smtp_details',
				    'title' => '',
				    'page' => 'escrowtics-smtp-settings'
			    ),
				array(
				    'id' => 'escrot_company_logo_size',
				    'title' => '',
				    'page' => 'escrowtics-logo-size-settings'
			    ),
				array(
				    'id' => 'escrot_user_escrow_email',
				    'title' => '',
				    'page' => 'escrowtics-user-escrow-email'
			    ),
				array(
				    'id' => 'escrot_admin_escrow_email',
				    'title' => '',
				    'page' => 'escrowtics-admin-escrow-email'
			    ),
				array(
				    'id' => 'escrot_label_settings',
				    'title' => '',
				    'page' => 'escrowtics-labels'
			    ),
				array(
				    'id' => 'escrot_ref_id_settings',
				    'title' => '',
				    'page' => 'escrowtics-ref-id'
			    )
				
				
		    );
			
			
			
			
	    }
		
		
    }