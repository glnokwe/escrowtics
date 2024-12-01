<?php
/**
 * Logs & Notification functions
 * Defines & add Transaction Logs & Notifications
 * Since  1.0.0.
 * 
 * @package  Escrowtics
 */

//New Escrow 
function  escrot_log_notify_new_escrow($ref_id, $payer, $earner, $amount, $bal, $user_id, $subject_id, $escrow_ref) {
	$log  = [
			"admin" =>   [
							"ref_id" => $ref_id, 
							"user_id" => 0, 
							"subject" => "New Escrow",
							"details" => $payer.' '.__("Created Escrow for", "escrowtics").' '.$earner,
							"amount" => $amount,
							"balance" => $bal
						],
		   "user"   =>  [
							"ref_id" => $ref_id, 
							"user_id" => $user_id, 
							"subject" => "New Escrow",
							"details" => __("Escrow created for", "escrowtics").' '.$earner,
							"amount" => $amount,
							"balance" => $bal
						]
			]; 
	$notification = [
		    "admin" =>   [
							"subject_id" => $subject_id, 
							"user_id" => 0, 
							"subject" =>__("New Escrow Created, ID: ", "escrowtics").$subject_id,
							"message" => __("New Escrow with Ref#", "escrowtics")." <strong>".$escrow_ref.    
							"</strong> ".__("was Added by ", "escrowtics")." <strong>".$payer."</strong>",
							"status" => 0
						],
		    "user" =>    [
							"subject_id" => $subject_id, 
							"user_id" => $user_id, 
							"subject" =>__("New Escrow Created, ID: ", "escrowtics").$subject_id,
							"message" => __("New Escrow with Ref#", "escrowtics")." <strong>".$escrow_ref.    
							"</strong> ".__("was Added by ", "escrowtics")." <strong>".$payer."</strong>",
							"status" => 0
						]
	   ];	
	   foreach($log as $log){ do_action('escrot_log_transaction', $log); }
	   foreach($notification as $notification){ do_action('escrot_notify', $notification); }
}


//New Escrow Milestone
function  escrot_log_notify_new_milestone($ref_id, $payer, $earner, $amount, $bal, $user_id, $subject_id, $escrow_ref) {
	$log = [
			"admin" =>   [
							"ref_id" => $ref_id, 
							"user_id" => 0, 
							"subject" => "New Milestone",
							"details" => $payer.' '.__("Created Escrow Amount for", "escrowtics").' '.$earner,
							"amount" => $amount,
							"balance" => $bal
						],
		   "user"   =>  [
							"ref_id" => $ref_id,
							"user_id" => $user_id, 
							"subject" => "New Milestone",
							"details" => __("Escrow Amount created for", "escrowtics").' '.$earner,
							"amount" => $amount,
							"balance" => $bal
						]
			];
			
	$notification = [
		   "admin" => [
							"subject_id" => $subject_id, 
							"user_id" => 0, 
							"subject" => __("New Escrow Milestone Created, ID: ", "escrowtics").$subject_id,
							"message" => __("New Milestone for Escrow with Ref# ", "escrowtics")." <strong>".$escrow_ref.    
							"</strong>".__("was Added by ", "escrowtics")." <strong> ".$payer."</strong> ", 
							"status" => 0
						],
		   "user" =>    [
							"subject_id" => $subject_id, 
							"user_id" => $user_id, 
							"subject" =>__("New Escrow Milestone Created, ID: ", "escrowtics").$subject_id,
							"message" => __("New Milestone for Escrow with Ref#", "escrowtics")." <strong>".$escrow_ref.    
							"</strong>".__("was Added by", "escrowtics")." <strong> Admin</strong>", 
							"status" => 0
						]
	   ];
	   foreach($log as $log){ do_action('escrot_log_transaction', $log); }
	   foreach($notification as $notification){ do_action('escrot_notify', $notification); }
}


//Reject payment
function  escrot_log_notify_pay_rejected($ref_id, $earner, $escrow_title, $payer, $amount, $bal, $user_id, $subject_id) {
	$log = [
		"admin" =>   [
						"ref_id" => $ref_id, 
						"user_id" => 0, 
						"subject" => "Payment Rejected",
						"details" => $earner.' '.__("Rejected Payment for", "escrowtics").' '.$escrow_title.' '.__("made by", "escrowtics").' '.$payer,
						"amount" => $amount,
						"balance" => $bal
					],
		"user"   => [
						"ref_id" => $ref_id,
						"user_id" => $user_id, 
						"subject" => "Payment Rejected",
						"details" => $escrow_title.' '.__("Rejected By", "escrowtics").' '.$earner,
						"amount" => $amount,
						"balance" => $bal
					]	
	];
	
	$notification = [
	   "admin" =>   [
						"subject_id" => $subject_id, 
						"user_id" => 0, 
						"subject" => __("Escrow Payment Rejected, ID: ", "escrowtics").$subject_id,
						"message" => "<strong>".$earner."</strong> ".__("Rejected Payment for", "escrowtics")." ".$escrow_title." ".__("made by", "escrowtics")." <strong>".$payer."</strong>",    
						"status" => 0
					],
	   "user" =>    [
						"subject_id" => $subject_id, 
						"user_id" => $user_id, 
						"subject" =>__("Escrow Payment Rejected, ID: ", "escrowtics").$subject_id,
						"message" => $escrow_title." ".__("Rejected by", "escrowtics")." <strong> ".$earner."</strong>",  
						"status" => 0
					]
	];
	foreach($log as $log){ do_action('escrot_log_transaction', $log); }
	foreach($notification as $notification){ do_action('escrot_notify', $notification); }
}


//Release payment	
function  escrot_log_notify_pay_released($ref_id, $payer, $escrow_title, $earner, $amount, $bal, $user_id, $subject_id) {
	$log = [
	   "admin" =>   [
						"ref_id" => $ref_id, 
						"user_id" => 0, 
						"subject" => "Payment Released",
						"details" => $payer.' '.__("Released Payment for", "escrowtics").' '.$escrow_title.' '.__("to", "escrowtics").' '.$earner,
						"amount" => $amount,
						"balance" => $bal
					],
		"user"   => [
						"ref_id" => $ref_id,
						"user_id" => $user_id, 
						"subject" => "Payment Released",
						"details" => __("Escrow Amount released from", "escrowtics").' '.$payer,
						"amount" => $amount,
						"balance" => $bal
					]
	];
	
	$notification = [
	   "admin" => [
						"subject_id" => $subject_id, 
						"user_id" => 0, 
						"subject" => __("Escrow Payment Released, ID: ", "escrowtics").$subject_id,
						"message" => "<strong>".$payer."</strong> ".__(" Released Payment for ", "escrowtics")." ".$escrow_title." ".__("to", "escrowtics")." <strong>".$earner."</strong>",    
						"status" => 0
					],
	   "user" =>    [
						"subject_id" => $subject_id, 
						"user_id" => $user_id, 
						"subject" =>__("Escrow Payment Released, ID: ", "escrowtics").$subject_id,
						"message" => __("Escrow Amount released from ", "escrowtics")." <strong> ".$payer."</strong>",  
						"status" => 0
					]
   ];
   foreach($log as $log){ do_action('escrot_log_transaction', $log); }
   foreach($notification as $notification){ do_action('escrot_notify', $notification); }
}

//User Deposit   
function  escrot_log_notify_user_deposit($ref_id, $username, $amount, $bal, $user_id, $subject_id) {	   
	$log = [
	   "admin" =>   [
						"ref_id" => $ref_id, 
						"user_id" => 0, 
						"subject" => "User Deposit",
						"details" => $username.' '.__("Made a deposit of", "escrowtics").' '.ESCROT_CURRENCY.$amount,
						"amount" => $amount,
						"balance" => $bal
					],
		"user"   => [
						"ref_id" => $ref_id,
						"user_id" => $user_id, 
						"subject" => "User Deposit",
						"details" => __("You Deposited", "escrowtics").' '.ESCROT_CURRENCY.$amount,
						"amount" => $amount,
						"balance" => $bal
					]
	];
	
	$notification = [
	   "admin" => [
						"subject_id" => $subject_id, 
						"user_id" => 0, 
						"subject" => __("New User Deposit, ID: ", "escrowtics").$subject_id,
						"message" => "<strong>".$username."</strong> ".__(" Made a deposit of ", "escrowtics")." <strong>".ESCROT_CURRENCY.$amount."</strong>",    
						"status" => 0
					],
	   "user" =>    [
						"subject_id" => $subject_id, 
						"user_id" => $user_id, 
						"subject" =>__("Deposit Notification, ID: ", "escrowtics").$subject_id,
						"message" => __("You Deposited ", "escrowtics")." <strong> ".ESCROT_CURRENCY.$amount."</strong>",  
						"status" => 0
					]
	];
    foreach($log as $log){ do_action('escrot_log_transaction', $log); }
	foreach($notification as $notification){ do_action('escrot_notify', $notification); }	
}	 

//User Withdrawal
function  escrot_log_notify_user_withdrawal($ref_id, $username, $amount, $bal, $user_id, $subject_id) {	   
   $log = [
	   "admin" =>   [
						"ref_id" => $ref_id, 
						"user_id" => 0, 
						"subject" => "User Withdrawal",
						"details" => $username.' '.__("Made a withdrawal of", "escrowtics").' '.$amount,
						"amount" => $amount,
						"balance" => $bal
		],
		"user"   => [
						"ref_id" => $ref_id,
						"user_id" => $user_id, 
						"subject" => "User Withdrawal",
						"details" => __("You Made a Withdrawal of", "escrowtics").' '.$amount,
						"amount" => $amount,
						"balance" => $bal
					]
	];
	$notification = [
	   "admin" => [
						"subject_id" => $subject_id, 
						"user_id" => 0, 
						"subject" => __("New User Withdrawal, ID: ", "escrowtics").$subject_id,
						"message" => "<strong>".$username."</strong> ".__("Made a withdrawal of", "escrowtics")." <strong>".ESCROT_CURRENCY.$amount."</strong>",    
						"status" => 0
					],
	   "user" =>    [
						"subject_id" => $subject_id, 
						"user_id" => $user_id, 
						"subject" =>__("Withdrawal Notification, ID: ", "escrowtics").$subject_id,
						"message" => __("You Made a Withdrawal of ", "escrowtics")." <strong>".ESCROT_CURRENCY.$amount."</strong>",  
						"status" => 0
					]
   ];
	foreach($log as $log){ do_action('escrot_log_transaction', $log); }
	foreach($notification as $notification){ do_action('escrot_notify', $notification); }
}


//New Support Ticket
function  escrot_notify_new_ticket($ticket_id, $ref_id, $username, $user_id) {  
	$notification = [
	   "admin" => [
						"subject_id" => $ticket_id, 
						"user_id" => 0, 
						"subject" => __("New Support Ticket Opened, ID: ", "escrowtics").' #'.$ref_id,
						"message" => __("New Support Ticket Opened by", "escrowtics")." <strong>".$username."</strong> ".__("created an account.", "escrowtics"),  
						"status" => 0
					],
		 "user" => [
						"subject_id" => $ticket_id, 
						"user_id" => $user_id, 
						"subject" => __("New Support Ticket Opened, ID: ", "escrowtics").' #'.$ref_id,
						"message" => __("New Support Ticket Opened for you by Admin", "escrowtics"),  
						"status" => 0
					]			
	];
	foreach($notification as $notification){ do_action('escrot_notify', $notification); }
}


//New User
function  escrot_notify_new_user($subject_id, $username) {  
	$notification = [
	   "admin" => [
						"subject_id" => $subject_id, 
						"user_id" => 0, 
						"subject" => __("New User Signup, ID: ", "escrowtics").$subject_id,
						"message" => __("New User with username", "escrowtics")." <strong>".$username."</strong> ".__("created an account.", "escrowtics"),  
						"status" => 0
					]
	];
	foreach($notification as $notification){ do_action('escrot_notify', $notification); }
}    		