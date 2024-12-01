<?php

/**
 * Default Options Manager for Escrowtics Plugin.
 * Generates and outputs default options as an associative array.
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\base;

defined('ABSPATH') || exit;

class DefaultOptions {

    /**
     * Get the default options as an associative array.
     *
     * @return array The default options.
     */
    public static function getDefaults() {
        return [
            // General Settings
            'plugin_interaction_mode'       => 'default',
            'access_role'                   => 'administrator',
            'currency'                      => 'USD',
            'timezone'                      => '',
            'company_logo'                  => '',
            'logo_width'                    => '',
            'logo_height'                   => '',
            'company_address'               => '',
            'company_phone'                 => '',

            // Escrows
            'escrow_form_style'             => 'default',
            'refid_length'                  => 12,
            'refid_xter_type'               => '0123456789',

            // Database Backup
            'dbackup_log'                   => false,
            'auto_dbackup'                  => false,
            'auto_db_freq'                  => 'weekly',

            // Email Settings (Generated dynamically using methods)
            'company_email'                 => get_option('admin_email'),
            'user_new_escrow_email'         => false,
            'user_new_milestone_email'      => false,
            'admin_new_escrow_email'        => false,
            'admin_new_milestone_email'     => false,
            'user_new_escrow_email_subject' => self::defaultUserNewEscrowEmailSubject(),
            'user_new_escrow_email_body'    => self::defaultUserNewEscrowEmailBody(),
            'user_new_escrow_email_footer'  => self::defaultUserNewEscrowEmailFooter(),
            'user_new_milestone_email_subject' => self::defaultUserNewMilestoneEmailSubject(),
            'user_new_milestone_email_body'    => self::defaultUserNewMilestoneEmailBody(),
            'user_new_milestone_email_footer'  => self::defaultUserNewMilestoneEmailFooter(),
            'admin_new_escrow_email_subject'   => self::defaultAdminNewEscrowEmailSubject(),
            'admin_new_escrow_email_body'      => self::defaultAdminNewEscrowEmailBody(),
            'admin_new_escrow_email_footer'    => self::defaultAdminNewEscrowEmailFooter(),
            'admin_new_milestone_email_subject' => self::defaultAdminNewMilestoneEmailSubject(),
            'admin_new_milestone_email_body'    => self::defaultAdminNewMilestoneEmailBody(),
            'admin_new_milestone_email_footer'  => self::defaultAdminNewMilestoneEmailFooter(),
            'smtp_protocol'                  => false,
            'smtp_host'                      => '',
            'smtp_user'                      => '',
            'smtp_pass'                      => '',
            'smtp_port'                      => '',

            // Admin Styling
            'theme_class'                   => 'dark-edition',
            'admin_nav_style'               => 'sidebar',
            'fold_wp_menu'                  => false,
            'fold_escrot_menu'              => false,

            // Frontend Styling
            'primary_color'                => '#ffffff',
            'secondary_color'              => '#000000',
            'custom_css'                    => '',
            'escrow_detail_label'           => 'ESCROW DETAILS',
            'withdraw_history_table_label'  => 'Withdrawal History',
            'escrow_table_label'            => 'Escrow List',
            'earning_table_label'           => 'Earning List',
            'log_table_label'               => 'Transaction Log',
            'earning_list_label'            => 'Earning List',
            'escrow_list_label'             => 'Escrow List',
            'login_form_label'              => 'User Login',
            'signup_form_label'             => 'User Registration',
            'deposit_history_table_label'   => 'Deposit History',

            // Payment Settings
            'enable_bitcoin_payment'        => false,
            'blockonomics_api_key'          => '',
            'blockonomics_endpoint_url'     => '',
            'enable_paypal_payment'         => false,
            'paypal_email'                  => '',

            // Advanced Settings
            'enable_rest_api'               => false,
            'enable_rest_api_key'           => false,
            'rest_api_key'                  => '',
            'rest_api_enpoint_url'          => '',
            'rest_api_data'                 => []
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
