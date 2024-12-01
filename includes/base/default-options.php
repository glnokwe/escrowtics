<?php 
/**
 * Default Options
 * Defines all default options
 * @package  Escrowtics
 * Since  1.0.0.
 */
    
	
    $email_footer = '<div class="footer" style="margin-top: 30px;">
		            </div>
		            <div class="copyright" style="margin-top: 20px; padding: 5px; border-top: 1px solid #000;">
		            <p>This message is intended solely for the use of the individual or organization to whom it is addressed. It may contain privileged or confidential information. If you have received this message in error, please notify the originator immediately. If you are not the intended recipient, you should not use, copy, alter or disclose the contents of this message. All information or opinions 
                    expressed in this message and/or any attachments are those of the author and are not necessarily those of {site-title} or its 
                    affiliates. {site-title} accepts no responsibility for loss or damage arising from its use, including damage from virus.</p>
                    <p>© {current-year} | <a href="'.get_home_url().'">{site-title}</a> | {company-address}</p>
                    </div>';
					
					
	/* Default Setting Optionss */		
	$default_options = array(
						//General
		                'plugin_interaction_mode' => 'page',
                        'access_role' => 'administrator',
                        'currency' => 'USD',
                        'timezone' => 'Europe/London',
                        'company_address' => '',
                        'company_phone' => '',
                        'company_logo' => '',
                        'logo_width' => '',
                        'logo_height' => '',
						//Escrow
                        'show_pending_escrows' => false,
						'escrow_form_style' => 'normal',
						'refid_length' => '',
                        'refid_xter_type' => '',
						//email
                        'company_email' => '',
                        'user_new_escrow_email' => false,
                        'user_new_milestone_email' => false,
                        'admin_new_escrow_email' => false,
                        'admin_new_milestone_email' => false,
                        'notify_admin_by_email' => false,
                        'smtp_protocol' => false,
                        'smtp_host' => '',
                        'smtp_user' => '',
                        'smtp_pass' => '',
                        'smtp_port' => '',
                        'user_new_escrow_email_subject' => '{site-title} - New Escrow Notification #{ref-id}',
                        'user_new_milestone_email_subject' => '{site-title} - New Escrow Milestone Notification #{ref-id}',
                        'user_new_escrow_email_body' => preg_replace('/^\s+/m', '', trim('<p>Hello  {username} ! </p>
															<p>New Escrow created by '.ucwords("{payer}").', status is: {status}. Please find attached the transaction details.</p>
															<p><b>
															 Ref ID: {ref-id}
															 Payer: </b>{payer}<br><br><b>
															 Amount: </b>{amount}<br><br><b>
															 Title: </b>{title}<br><br><b>
															 Details: </b> {deatils}
                                                         </p>')),
                        'user_new_milestone_email_body' => preg_replace('/^\s+/m', '', trim('<p>Hello  {username} ! </p>
															<p>New Escrow Milestone amount created for you by '.ucwords("{payer}").', status is: {status}. Please find attached the transaction details.</p>
															<p><b>
															 Ref ID: {ref-id}
															 Payer: </b>{payer}<br><br><b>
															 Amount: </b>{amount}<br><br><b>
															 Title: </b>{title}<br><br><b>
															 Details: </b> {deatils}
                                                         </p>')),
                        'user_new_escrow_email_footer' => preg_replace('/^\s+/m', '', trim($email_footer)),
                        'user_new_milestone_email_footer' => preg_replace('/^\s+/m', '', trim($email_footer)),
                        'admin_new_escrow_email_subject' => '{site-title} - New Escrow Notification #{ref-id}',
                        'admin_new_milestone_email_subject' => '{site-title} - New Escrow Milestone Notification #{ref-id}',
                        'admin_new_escrow_email_body' =>  preg_replace('/^\s+/m', '', trim('<p>Hello  {username} ! </p>
															<p>{payer} created New Escrow for {earner}, status is: {status}. Please find attached the transaction details.</p>
															<p><b>
															 Ref ID: {ref-id}
															 Earner: </b>{earner}<br><br><b>
															 Amount: </b>{amount}<br><br><b>
															 Title: </b>{title}<br><br><b>
															 Details: </b> {deatils}
                                                         </p>')),
                        'admin_new_milestone_email_body' =>  preg_replace('/^\s+/m', '', trim('<p>Hello  {username} ! </p>
																<p>{payer} created New Escrow Milestone for {earner}, status is: {status}. Please find attached the transaction details.</p>
																<p><b>
																 Ref ID: {ref-id}
																 Earner: </b>{earner}<br><br><b>
																 Amount: </b>{amount}<br><br><b>
																 Title: </b>{title}<br><br><b>
																 Details: </b> {deatils}
                                                         </p>')),
                        'admin_new_escrow_email_footer' => preg_replace('/^\s+/m', '', trim($email_footer)),
                        'admin_new_milestone_email_footer' => preg_replace('/^\s+/m', '', trim($email_footer)),
						//Styling
						'theme_class' => 'light-edition',
                        'admin_nav_style' => 'top-menu',
						'fold_wp_menu' => false,
						'fold_escrot_menu' => false,
                        'custom_css' => '',
						'primary_color' => '#3a32e0',
						'secondary_color' => '#8080ff',
                        'escrow_detail_label' => '',
                        'escrow_table_label' => '',
                        'earning_table_label' => '',
                        'log_table_label' => '',
                        'deposit_history_table_label' => '',
                        'withdraw_history_table_label' => '',
                        'escrow_list_label' => '',
                        'earning_list_label' => '',
                        'login_form_label' => '',
                        'signup_form_label' => '',
						//DB Backup
                        'dbackup_log' => true,
                        'auto_dbackup' => false,
                        'auto_db_freq' => ''
                    );