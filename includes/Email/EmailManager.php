<?php

/**
 * Mailer class
 * Defines and hook email actions of the plugin.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */
	
	namespace Escrowtics\Email;
	
	defined('ABSPATH') || exit;
 
 
    class EmailManager {
 
 
 	    public function register() {
		
            //Register hooks 
	       add_action('phpmailer_init', array($this, 'phpMailerConfig' )); 
		
	    }
		
		//Configure PHPMailer custom SMTP 
        public function phpMailerConfig($mail){
			
          if(!ESCROT_SMTP_PROTOCOL){ return; }
		  
          $mail->IsSMTP();
          $mail->SMTPAuth = true;
          $mail->Host = ESCROT_SMTP_HOST;
          $mail->Port = ESCROT_SMTP_PORT;
	      $mail->Username = ESCROT_SMTP_USER;
	      $mail->Password = ESCROT_SMTP_PASS;
	      $mail->SMTPSecure = 'tls';
	      $mail->From = escrot_option('company_email');
          $mail->FromName = get_bloginfo('name');
	  
        }
	
	
   }	 