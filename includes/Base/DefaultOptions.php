<?php


/**
 * Default Option Class
 * Defines all default option values
 *
 * Since     1.0.0.
 * @package  Escrowtics
 */
 
 
namespace Escrowtics\Base;

defined('ABSPATH') || exit;


class DefaultOptions {
	
    public static function all() {
		
		$email_footer = "<p>Best regards,<br>".get_bloginfo('name')."</p>";

		$default_options = [
		
			// General Settings
			'access_role' => 'editor',
			'currency' => 'USD',
			'timezone' => 'UTC',
			'company_address' => '',
			'company_phone' => '',
			'company_logo' => '',
			'logo_width' => '156',
			'logo_height' => '36',
			
			// Escrow Options
			'escrow_form_style' => 'normal',
			
			// Reference ID
			'refid_length' => '12',
			'refid_xter_type' => '0123456789',
			
			// Escrow Fees
			'escrow_fees' => 'percentage',
			'escrow_fee_description' => 'Escrow Creation Fee',
			'escrow_fee_amount' => '1.00',
			'escrow_fee_percentage' => '1%',
			
			// Email Settings
			'company_email' => get_option('admin_email'),
			'user_new_escrow_email' => false,
			'user_new_milestone_email' => false,
			'admin_new_escrow_email' => true,
			'admin_new_milestone_email' => true,
			'notify_admin_by_email' => false,
			'smtp_protocol' => false,
			'smtp_host' => '',
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_port' => '',
			
			// User Emails
			'user_new_escrow_email_subject' => 'Your escrow has been successfully created.',
			'user_new_milestone_email_subject' => 'A new milestone has been added to your escrow.',
			'user_new_escrow_email_body' => '<p>Hello,</p><p>Thank you for creating an escrow with us. Your escrow has been successfully created and is now active.</p>',
			'user_new_milestone_email_body' => '<p>Hello,</p><p>A new milestone has been successfully added to your escrow. Please review the milestone details in your dashboard.</p>',
			'user_new_escrow_email_footer' => $email_footer,
			'user_new_milestone_email_footer' => $email_footer,
			
			// Admin Emails
			'admin_new_escrow_email_subject' => 'New Escrow Created',
			'admin_new_milestone_email_subject' => 'New Milestone Notification',
			'admin_new_escrow_email_body' => '<p>Hello Admin,</p><p>A new escrow has been created on the platform. Please review the escrow details in your admin panel.</p>',
			'admin_new_milestone_email_body' => '<p>Hello Admin,</p><p>A new milestone has been added to an existing escrow. Please review the milestone details in your admin panel.</p>',
			'admin_new_escrow_email_footer' => $email_footer,
			'admin_new_milestone_email_footer' => $email_footer,
			
			// Admin Styling
			'interaction_mode_admin' => 'page',
			'theme_class' => 'light-edition',
			'admin_nav_style' => 'top-menu',
			'fold_wp_menu' => false,
			'fold_escrot_menu' => false,
			
			// Frontend Styling
			'interaction_mode_frontend' => 'modal',
			'primary_color' => '#044fff',
			'secondary_color' => '#2d9fb4',
			'custom_css' => '',
			
			// Labels
			'escrow_payer_label' => 'Payer',
			'escrow_earner_label' => 'Earner',
			'escrow_detail_label' => 'Escrow Details',
			'escrow_table_label' => 'Escrow Table',
			'earning_table_label' => 'Earnings Table',
			'log_table_label' => 'Transaction Log',
			'deposit_history_table_label' => 'Deposit History',
			'withdraw_history_table_label' => 'Withdrawal History',
			'escrow_list_label' => 'Escrow List',
			'earning_list_label' => 'Earning List',
			'login_form_label' => 'User Login',
			'signup_form_label' => 'User Signup',
			
			// DB Backup Options
			'dbackup_log' => true,
			'auto_dbackup' => false,
			'auto_dbackup_freq' => 'weekly',
			
			// Bitcoin Payment Options
			'enable_bitcoin_payment' => false,
			'blockonomics_api_key' => '',
			'escrot_blockonomics_enpoint_url' => '',
			
			// Paypal Payment Options
			'enable_paypal_payment' => false,
			'paypal_email' => '',
			
			// Invoice
			'enable_invoice_logo' => true,
			
			// Commissions Options
			'commission_fees' => 'percentage',
			'commission_payer' => 'earner',
			'commission_amount' => '10',
			'commission_percentage' => '1',
			
			// Commission Threshold
			'enable_min_commission' => false,
			'enable_max_commission' => false,
			'min_commission_amount' => '1',
			'max_commission_amount' => '100',
			
			// Commission Tax
			'commission_tax_fees' => 'no_fee',
			'commission_tax_description' => 'VAT',
			'commission_tax_amount' => '2',
			'commission_tax_percentage' => '0.2',
			
			// Disputes
			'dispute_time' => 'any-time',
			'dispute_initiator' => 'both',
			'dispute_fees' => 'no-fee',
			'dispute_fee_amount' => '1.00',
			'dispute_fee_percentage' => '1',
			'dispute_reasons' => 'Non-Delivery of Goods/Services, Incomplete Delivery, Quality Issues, Payment Issues, Fraudulent Activity, Miscommunication, Unapproved Changes, Delivery Delay, Contract Breach, Technical Issues, Cancellation Disputes, Return/Refund Requests, Unauthorized Transactions, Violation of Local Laws, Escrow Fees Disputes',
			'dispute_resolutions' => 'Full Refund, Partial Refund, Rework/Redelivery, Extended Deadline, Revised Payment Terms, Replacement, Cancellation of Escrow, Split Amount, Third-Party Arbitration, No Resolution, Mutual Agreement, Conditional Refund, Escrow Hold, Admin Decision',
			
			// Dispute file upload
			'enable_dispute_evidence' => false,
			'dispute_evidence_file_size' => '',
			'dispute_evidence_file_types' => [],
			
			// Advanced Options
			'enable_rest_api' => true,
			'enable_rest_api_key' => true,
			'rest_api_key' => '',
			'rest_api_endpoint_urls' => '',
			'rest_api_data' => []
		];
		
		
		return $default_options;
		
	}
	
	
	
	public static function get($key) {

		return self::all()[$key] ?? null;
		
	}
	

}	