<?php

/**
 * Mailer class
 * Defines and hook email actions of the plugin.
 * @since      1.0.0
 * @package    Escrowtics
 */
	
	namespace Escrowtics\email;
	
	defined('ABSPATH') or die();
 
 
    class EmailManager {
 
 
 	    public function register() {
		
            //Register hooks 
	        if(ESCROT_SMTP_PROTOCOL){ add_action('phpmailer_init', array($this, 'phpMailerConfig' )); }
		
	    }
		
		//Configure PHPMailer custom SMTP 
        public function phpMailerConfig($mail){
          
          $mail->IsSMTP();
          $mail->SMTPAuth = true;
          $mail->Host = ESCROT_SMTP_HOST;
          $mail->Port = ESCROT_SMTP_PORT;
	      $mail->Username = ESCROT_SMTP_USER;
	      $mail->Password = ESCROT_SMTP_PASS;
	      $mail->SMTPSecure = 'tls';
	      $mail->From = ESCROT_COMPANY_EMAIL;
          $mail->FromName = get_bloginfo('name');
	  
        }
	
	
   }	 