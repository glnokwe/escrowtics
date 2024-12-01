<?php
/**
 * Email Nofication Functions
 * Defines all nofication emails
 * @since      1.0.0
 * @package    Escrowtics
 */

$email_footer = '<div class="footer" style="margin-top: 30px;">
		            </div>
		            <div class="copyright" style="margin-top: 20px; padding: 5px; border-top: 1px solid #000;">
		            <p>'.__("This message is intended solely for the use of the individual or organization to whom it is addressed. It may contain privileged or confidential information. If you have received this message in error, please notify the originator immediately. If you are not the intended recipient, you should not use, copy, alter or disclose the contents of this message. All information or opinions 
                    expressed in this message and/or any attachments are those of the author and are not necessarily those of {site-title} or its 
                    affiliates", "escrowtics").' '.get_bloginfo('name').' '.__("accepts no responsibility for loss or damage arising from its use, including damage from virus", "escrowtics").'</p>
                    <p>© '.date('Y').' | <a href="'.get_home_url().'">'.get_bloginfo('name').'</a></p>
                    </div>';

//Escrow Notification Email
function escrot_new_escrow_email($ref_id, $status, $earner, $amount, $earner_email, $title, $details){
  
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
				'{company-address}'=> ESCROT_COMPANY_ADDRESS 							   
			);
			
			
	$emails  = [
		"admin" =>  [
						"to" => ESCROT_COMPANY_EMAIL, 
						"subject" => strtr(ESCROT_ADMIN_NEW_ESCROW_EMAIL_SUBJECT, $trans),
						"body" => strtr(ESCROT_ADMIN_NEW_ESCROW_EMAIL_BODY.' '.ESCROT_ADMIN_NEW_ESCROW_EMAIL_FOOTER, $trans),
						"is_on" => ESCROT_ADMIN_NEW_ESCROW_EMAIL
					],
	   "user"   =>  [
						"to" => $data['earner_email'], 
						"subject" => strtr(ESCROT_USER_NEW_ESCROW_EMAIL_SUBJECT, $trans),
						"body" => strtr(ESCROT_USER_NEW_ESCROW_EMAIL_BODY.' '.ESCROT_USER_NEW_ESCROW_EMAIL_FOOTER, $trans),
						"is_on" => ESCROT_USER_NEW_ESCROW_EMAIL
					]
		]; 
		
	$headers = array('Content-Type: text/html; charset=UTF-8');		
	foreach ($emails as $context => $email) {					   
		if($email["is_on"]) {
			wp_mail( $email["to"], $email["subject"], $email["body"], $headers );
		}
	}

}


//Milestone Notification Email
function escrot_new_milestone_email($ref_id, $status, $earner, $amount, $earner_email, $title, $deatils){
  
	$trans = array( 
				'{ref-id}'       => $ref_id,
				'{status}'       => $status, 
				'{earner}'       => $earner, 
				'{amount}'       => $amount,
				'{earner_email}' => $earner_email, 
				'{title}'        => $title, 
				'{deatils}'      => $deatils,
				'{current-year}' => date('Y'), 
				'{site-title}'   => get_bloginfo('name'),
				'{company-address}'=> ESCROT_COMPANY_ADDRESS 							   
			);
			
			
	$emails  = [
		"admin" =>  [
						"to" => ESCROT_COMPANY_EMAIL, 
						"subject" => strtr(ESCROT_ADMIN_NEW_MILESTONE_EMAIL_SUBJECT, $trans),
						"body" => strtr(ESCROT_ADMIN_NEW_MILESTONE_EMAIL_BODY.' '.ESCROT_ADMIN_NEW_MILESTONE_EMAIL_FOOTER, $trans),
						"is_on" => ESCROT_ADMIN_NEW_MILESTONE_EMAIL
					],
	   "user"   => [
						"to" => $earner_email, 
						"subject" => strtr(ESCROT_USER_NEW_MILESTONE_EMAIL_SUBJECT, $trans),
						"body" => strtr(ESCROT_USER_NEW_MILESTONE_EMAIL_BODY.' '.ESCROT_USER_NEW_MILESTONE_EMAIL_FOOTER, $trans),
						"is_on" => ESCROT_USER_NEW_MILESTONE_EMAIL
					]
		]; 
		
	$headers = array('Content-Type: text/html; charset=UTF-8');		
	foreach ($emails as $context => $email) {					   
		if($email["is_on"]) {
			wp_mail( $email["to"], $email["subject"], $email["body"], $headers );
		}
	}

}



//Payment Rejection Notification Email
function escrot_pay_rejected_email($ref_id, $earner, $escrow_title, $payer, $amount, $payer_email){
  
	$emails  = [
		"admin" =>  [
						"to" => ESCROT_COMPANY_EMAIL, 
						"subject" => __("Escrow Payment Rejected", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => $earner.' '.__("Rejected Payment for", "escrowtics").' '.$escrow_title.' '.__("made by", "escrowtics").' '.$payer."<br>".__("Rejected Amount", "escrowtics").": ".$amount.$email_footer,
						"is_on" => true
					],
	   "user"   =>  [
						"to" => $payer_email, 
						"subject" => __("Escrow Payment Rejected", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => $escrow_title.' '.__("Rejected By", "escrowtics").' '.$earner.'<br>'.__("Rejected Amount", "escrowtics").': '.$amount.$email_footer,
						"is_on" => true
					]
		]; 
		
	$headers = array('Content-Type: text/html; charset=UTF-8');		
	foreach ($emails as $context => $email) {					   
		if($email["is_on"]) {
			wp_mail( $email["to"], $email["subject"], $email["body"], $headers );
		}
	}

}



//Payment Release Notification Email
function escrot_pay_released_email($ref_id, $payer, $escrow_title, $earner, $amount, $earner_email){
  
	$emails  = [
		"admin" =>  [
						"to" => ESCROT_COMPANY_EMAIL, 
						"subject" => __("Escrow Payment Released", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => $payer.' '.__("Released Payment for", "escrowtics").' '.$escrow_title.' '.__("to", "escrowtics").' '.$earner."<br>".__("Released Amount", "escrowtics").": ".$amount.$email_footer,
						"is_on" => true
					],
	   "user"   =>  [
						"to" => $earner_email, 
						"subject" => __("Escrow Payment Released", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => __("Escrow Amount released from", "escrowtics").' '.$payer.'<br>'.__("Released Amount", "escrowtics").': '.$amount.$email_footer,
						"is_on" => true
					]
		]; 
		
	$headers = array('Content-Type: text/html; charset=UTF-8');		
	foreach ($emails as $context => $email) {					   
		if($email["is_on"]) {
			wp_mail( $email["to"], $email["subject"], $email["body"], $headers );
		}
	}

}



//User Deposit Notification Email
function escrot_user_deposit_email($ref_id, $username, $amount, $user_email){
  
	$emails  = [
		"admin" =>  [
						"to" => ESCROT_COMPANY_EMAIL, 
						"subject" => __("User Deposit", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => $username.' '.__("Made a deposit of", "escrowtics").' '.ESCROT_CURRENCY.$amount.$email_footer,
						"is_on" => true
					],
	   "user"   =>  [
						"to" => $user_email, 
						"subject" => __("User Deposit", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => __("You Deposited", "escrowtics").' '.ESCROT_CURRENCY.$amount.$email_footer,
						"is_on" => true
					]
		]; 
		
	$headers = array('Content-Type: text/html; charset=UTF-8');		
	foreach ($emails as $context => $email) {					   
		if($email["is_on"]) {
			wp_mail( $email["to"], $email["subject"], $email["body"], $headers );
		}
	}

}
	


//User Withdrawal Notification Email
function escrot_user_withdrawal_email($ref_id, $username, $amount, $user_email){
  
	$emails  = [
		"admin" =>  [
						"to" => ESCROT_COMPANY_EMAIL, 
						"subject" => __("User Withdrawal", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => $username.' '.__("Made a withdrawal of", "escrowtics").' '.ESCROT_CURRENCY.$amount.$email_footer,
						"is_on" => true
					],
	   "user"   =>  [
						"to" => $user_email, 
						"subject" => __("User Withdrawal", "escrowtics")."(".$ref_id.") - ".get_bloginfo('name'),
						"body" => __("You Made a Withdrawal of", "escrowtics").' '.ESCROT_CURRENCY.$amount.$email_footer,
						"is_on" => true
					]
		]; 
		
	$headers = array('Content-Type: text/html; charset=UTF-8');		
	foreach ($emails as $context => $email) {					   
		if($email["is_on"]) {
			wp_mail( $email["to"], $email["subject"], $email["body"], $headers );
		}
	}

}


//New User Notification Email
function escrot_new_user_email($username){
  
	$emails  = [
		"admin" =>  [
						"to" => ESCROT_COMPANY_EMAIL, 
						"subject" => __("New User Signup", "escrowtics")." - ".get_bloginfo('name'),
						"body" => __("New User with username", "escrowtics")." <strong>".$username."</strong> ".__("created an account.", "escrowtics").$email_footer,
						"is_on" => true
					]
		]; 
		
	$headers = array('Content-Type: text/html; charset=UTF-8');		
	foreach ($emails as $context => $email) {					   
		if($email["is_on"]) {
			wp_mail( $email["to"], $email["subject"], $email["body"], $headers );
		}
	}

}	