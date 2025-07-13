<?php
/**
 * Email Notification Functions
 * Defines all notification emails for Escrowtics
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

defined('ABSPATH') || exit;

/**
 * Generates a consistent email footer for all emails.
 *
 * @return string
 */
function escrot_get_email_footer() {
    $year = date('Y');
    $site_name = get_bloginfo('name');
    $home_url = get_home_url();

    return sprintf(
        '<div class="footer" style="margin-top: 30px;">
            <div class="copyright" style="margin-top: 20px; padding: 5px; border-top: 1px solid #000;">
                <p>%s</p>
                <p>© %s | <a href="%s">%s</a></p>
            </div>
        </div>',
        esc_html__(
            'This message is intended solely for the use of the individual or organization to whom it is addressed. It may contain privileged or confidential information. If you have received this message in error, please notify the originator immediately. If you are not the intended recipient, you should not use, copy, alter, or disclose the contents of this message. All information or opinions expressed in this message and/or any attachments are those of the author and are not necessarily those of',
            'escrowtics'
        ) . ' ' . esc_html($site_name),
        esc_html($year),
        esc_url($home_url),
        esc_html($site_name)
    );
}

/**
 * Sends an email notification.
 *
 * @param string $to Recipient email address.
 * @param string $subject Email subject.
 * @param string $body Email body.
 * @param bool   $is_enabled Flag to determine if the email should be sent.
 */
function escrot_send_email($to, $subject, $body, $is_enabled = true) {
    if ($is_enabled && !empty($to) && !empty($subject) && !empty($body)) {
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        wp_mail(sanitize_email($to), esc_html($subject), $body, $headers);
    }
}

/**
 * Processes email notifications for different contexts.
 *
 * @param array $emails Array containing email configurations for admin and user.
 * @param array $trans Placeholder replacements.
 */
function escrot_process_emails($emails, $trans) {
    foreach ($emails as $context => $email) {
        $subject = strtr($email['subject'], $trans);
        $body = strtr($email['body'] . escrot_get_email_footer(), $trans);
        escrot_send_email($email['to'], $subject, $body, $email['is_on']);
    }
}

/**
 * New Escrow Notification Email.
 */
function escrot_new_escrow_email($ref_id, $status, $earner, $amount, $earner_email, $title, $details) {
    $trans = array(
        '{ref-id}'       => $ref_id,
        '{status}'       => $status,
        '{earner}'       => $earner,
        '{amount}'       => $amount,
        '{earner_email}' => $earner_email,
        '{title}'        => $title,
        '{details}'      => $details,
        '{current-year}' => date('Y'),
        '{site-title}'   => get_bloginfo('name'),
        '{company-address}' => escrot_option('company_address'),
    );

    $emails = array(
        "admin" => array(
            "to"      => escrot_option('company_email'),
            "subject" => escrot_option('admin_new_escrow_email_subject'),
            "body"    => escrot_option('admin_new_escrow_email_body'),
            "is_on"   => escrot_option('admin_new_escrow_email'),
        ),
        "user" => array(
            "to"      => $earner_email,
            "subject" => escrot_option('user_new_escrow_email_subject'),
            "body"    => escrot_option('user_new_escrow_email_body'),
            "is_on"   => escrot_option('user_new_escrow_email'),
        ),
    );

    escrot_process_emails($emails, $trans);
}


/**
 * New Milestone Notification Email.
 */
function escrot_new_milestone_email($ref_id, $status, $earner, $amount, $earner_email, $title, $details) {
    $trans = array(
        '{ref-id}'       => $ref_id,
        '{status}'       => $status,
        '{earner}'       => $earner,
        '{amount}'       => $amount,
        '{earner_email}' => $earner_email,
        '{title}'        => $title,
        '{details}'      => $details,
        '{current-year}' => date('Y'),
        '{site-title}'   => get_bloginfo('name'),
        '{company-address}' => escrot_option('company_address'),
    );

    $emails = array(
        "admin" => array(
            "to"      => escrot_option('company_email'),
            "subject" => escrot_option('admin_new_milestone_email_subject'),
            "body"    => escrot_option('admin_new_milestone_email_body'),
            "is_on"   => escrot_option('admin_new_milestone_email'),
        ),
        "user" => array(
            "to"      => $earner_email,
            "subject" => escrot_option('user_new_milestone_email_subject'),
            "body"    => escrot_option('user_new_milestone_email_body'),
            "is_on"   => escrot_option('user_new_milestone_email'),
        ),
    );

    escrot_process_emails($emails, $trans);
}



// Payment Rejection Email
function escrot_pay_rejected_email($ref_id, $earner, $escrow_title, $payer, $amount, $payer_email) {
    $footer = escrot_get_email_footer();

    $admin_body = sprintf(
        '%s %s %s %s %s: %s.',
        esc_html($earner),
        esc_html__('rejected payment for', 'escrowtics'),
        esc_html($escrow_title),
        esc_html__('made by', 'escrowtics'),
        esc_html($payer),
        esc_html($amount)
    ) . $footer;

    $user_body = sprintf(
        '%s %s %s: %s.',
        esc_html($escrow_title),
        esc_html__('was rejected by', 'escrowtics'),
        esc_html($earner),
        esc_html($amount)
    ) . $footer;

    escrot_send_email(escrot_option('company_email'), __('Escrow Payment Rejected', 'escrowtics') . " ({$ref_id})", $admin_body);
    escrot_send_email($payer_email, __('Escrow Payment Rejected', 'escrowtics') . " ({$ref_id})", $user_body);
}

// Payment Released Email
function escrot_pay_released_email($ref_id, $payer, $escrow_title, $earner, $amount, $earner_email) {
    $footer = escrot_get_email_footer();

    $admin_body = sprintf(
        '%s %s %s %s %s: %s.',
        esc_html($payer),
        esc_html__('released payment for', 'escrowtics'),
        esc_html($escrow_title),
        esc_html__('to', 'escrowtics'),
        esc_html($earner),
        esc_html($amount)
    ) . $footer;

    $user_body = sprintf(
        '%s %s %s: %s.',
        esc_html__('Escrow amount released by', 'escrowtics'),
        esc_html($payer),
        esc_html__('Released amount', 'escrowtics'),
        esc_html($amount)
    ) . $footer;

    escrot_send_email(escrot_option('company_email'), __('Escrow Payment Released', 'escrowtics') . " ({$ref_id})", $admin_body);
    escrot_send_email($earner_email, __('Escrow Payment Released', 'escrowtics') . " ({$ref_id})", $user_body);
}

// Deposit Notification Email
function escrot_user_deposit_email($ref_id, $username, $amount, $user_email) {
    $footer = escrot_get_email_footer();

    $admin_body = sprintf(
        '%s %s %s.',
        esc_html($username),
        esc_html__('made a deposit of', 'escrowtics'),
        esc_html($amount)
    ) . $footer;

    $user_body = sprintf(
        '%s %s.',
        esc_html__('You deposited ', 'escrowtics'),
        esc_html($amount)
    ) . $footer;

    escrot_send_email(escrot_option('company_email'), __('User Deposit', 'escrowtics') . " ({$ref_id})", $admin_body);
    escrot_send_email($user_email, __('User Deposit', 'escrowtics') . " ({$ref_id})", $user_body);
}

// User Withdrawal Notification Email
function escrot_user_withdrawal_email($ref_id, $username, $amount, $user_email) {
    $footer = escrot_get_email_footer();

    $admin_body = sprintf(
        '%s %s %s.',
        esc_html($username),
        esc_html__('made a withdrawal of ', 'escrowtics'),
        esc_html($amount)
    ) . $footer;

    $user_body = sprintf(
        '%s %s.',
        esc_html__('You made a withdrawal of ', 'escrowtics'),
        esc_html($amount)
    ) . $footer;

    escrot_send_email(escrot_option('company_email'), __('User Withdrawal', 'escrowtics') . " ({$ref_id})", $admin_body);
    escrot_send_email($user_email, __('User Withdrawal', 'escrowtics') . " ({$ref_id})", $user_body);
}


//New User Notification Email
function escrot_new_user_email($username){
	
	$footer = escrot_get_email_footer();

    $admin_body = sprintf(
        '%s %s %s.',
        esc_html__("New User with username ", "escrowtics"),
        '<strong>'.$username.'</strong>',
		esc_html__(" created an account.", "escrowtics"),
    ) . $footer;
  
	escrot_send_email(escrot_option('company_email'), __("New User Signup", "escrowtics")." - ".get_bloginfo('name'), $admin_body);

}	