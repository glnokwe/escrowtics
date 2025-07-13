<?php
/**
 * Logs & Notification functions
 * Defines & add Transaction Logs & Notifications
 
 * @Since  1.0.0.
 * @package  Escrowtics
 */

// Common function to process logs and notifications
function escrot_process_log_and_notify($log_data, $notification_data) {
    foreach ($log_data as $log) {
        do_action('escrot_log_transaction', $log);
    }
    foreach ($notification_data as $notification) {
        do_action('escrot_notify', $notification);
    }
}

// Common function to process notifications
function escrot_process_notify($notification_data) {
    foreach ($notification_data as $notification) {
        do_action('escrot_notify', $notification);
    }
}

// New Escrow
function escrot_log_notify_new_escrow($ref_id, $payer, $earner, $amount, $bal, $user_id, $subject_id, $escrow_ref) {
    $log = [
        "admin" => [
            "ref_id" => $ref_id,
            "user_id" => 0,
            "subject" => __("New Escrow", "escrowtics"),
            "details" => $payer . ' ' . __("Created Escrow for", "escrowtics") . ' ' . $earner,
            "amount" => $amount,
            "balance" => $bal
        ],
        "user" => [
            "ref_id" => $ref_id,
            "user_id" => $user_id,
            "subject" => __("New Escrow", "escrowtics"),
            "details" => __("Escrow created for", "escrowtics") . ' ' . $earner,
            "amount" => $amount,
            "balance" => $bal
        ]
    ];

    $notification = [
        "admin" => [
            "subject_id" => $subject_id,
            "user_id" => 0,
            "subject" => __("New Escrow Created, ID: ", "escrowtics") . $subject_id,
            "message" => __("New Escrow with Ref#", "escrowtics") . " <strong>" . $escrow_ref . "</strong> " . __("was Added by", "escrowtics") . " <strong>" . $payer . "</strong>",
            "status" => 0
        ],
        "user" => [
            "subject_id" => $subject_id,
            "user_id" => $user_id,
            "subject" => __("New Escrow Created, ID: ", "escrowtics") . $subject_id,
            "message" => __("New Escrow with Ref#", "escrowtics") . " <strong>" . $escrow_ref . "</strong> " . __("was Added by", "escrowtics") . " <strong>" . $payer . "</strong>",
            "status" => 0
        ]
    ];

    escrot_process_log_and_notify($log, $notification);
}

// New Escrow Milestone
function escrot_log_notify_new_milestone($ref_id, $payer, $earner, $amount, $bal, $user_id, $subject_id, $escrow_ref) {
    $log = [
        "admin" => [
            "ref_id" => $ref_id,
            "user_id" => 0,
            "subject" => __("New Milestone", "escrowtics"),
            "details" => $payer . ' ' . __("Created Escrow Amount for", "escrowtics") . ' ' . $earner,
            "amount" => $amount,
            "balance" => $bal
        ],
        "user" => [
            "ref_id" => $ref_id,
            "user_id" => $user_id,
            "subject" => __("New Milestone", "escrowtics"),
            "details" => __("Escrow Amount created for", "escrowtics") . ' ' . $earner,
            "amount" => $amount,
            "balance" => $bal
        ]
    ];

    $notification = [
        "admin" => [
            "subject_id" => $subject_id,
            "user_id" => 0,
            "subject" => __("New Escrow Milestone Created, ID: ", "escrowtics") . $subject_id,
            "message" => __("New Milestone for Escrow with Ref# ", "escrowtics") . " <strong>" . $escrow_ref . "</strong>" . __("was Added by", "escrowtics") . " <strong>" . $payer . "</strong>",
            "status" => 0
        ],
        "user" => [
            "subject_id" => $subject_id,
            "user_id" => $user_id,
            "subject" => __("New Escrow Milestone Created, ID: ", "escrowtics") . $subject_id,
            "message" => __("New Milestone for Escrow with Ref#", "escrowtics") . " <strong>" . $escrow_ref . "</strong>" . __("was Added by", "escrowtics") . " <strong>Admin</strong>",
            "status" => 0
        ]
    ];

    escrot_process_log_and_notify($log, $notification);
}

// Reject Payment
function escrot_log_notify_pay_rejected($ref_id, $earner, $escrow_title, $payer, $amount, $bal, $user_id, $subject_id) {
    $log = [
        "admin" => [
            "ref_id" => $ref_id,
            "user_id" => 0,
            "subject" => __("Payment Rejected", "escrowtics"),
            "details" => $earner . ' ' . __("Rejected Payment for", "escrowtics") . ' ' . $escrow_title . ' ' . __("made by", "escrowtics") . ' ' . $payer,
            "amount" => $amount,
            "balance" => $bal
        ],
        "user" => [
            "ref_id" => $ref_id,
            "user_id" => $user_id,
            "subject" => __("Payment Rejected", "escrowtics"),
            "details" => $escrow_title . ' ' . __("Rejected By", "escrowtics") . ' ' . $earner,
            "amount" => $amount,
            "balance" => $bal
        ]
    ];

    $notification = [
        "admin" => [
            "subject_id" => $subject_id,
            "user_id" => 0,
            "subject" => __("Escrow Payment Rejected, ID: ", "escrowtics") . $subject_id,
            "message" => "<strong>" . $earner . "</strong> " . __("Rejected Payment for", "escrowtics") . " " . $escrow_title . " " . __("made by", "escrowtics") . " <strong>" . $payer . "</strong>",
            "status" => 0
        ],
        "user" => [
            "subject_id" => $subject_id,
            "user_id" => $user_id,
            "subject" => __("Escrow Payment Rejected, ID: ", "escrowtics") . $subject_id,
            "message" => $escrow_title . " " . __("Rejected by", "escrowtics") . " <strong> " . $earner . "</strong>",
            "status" => 0
        ]
    ];

    escrot_process_log_and_notify($log, $notification);
}

// Release Payment
function escrot_log_notify_pay_released($ref_id, $payer, $escrow_title, $earner, $amount, $bal, $user_id, $subject_id) {
    $log = [
        "admin" => [
            "ref_id" => $ref_id,
            "user_id" => 0,
            "subject" => __("Payment Released", "escrowtics"),
            "details" => $payer . ' ' . __("Released Payment for", "escrowtics") . ' ' . $escrow_title . ' ' . __("to", "escrowtics") . ' ' . $earner,
            "amount" => $amount,
            "balance" => $bal
        ],
        "user" => [
            "ref_id" => $ref_id,
            "user_id" => $user_id,
            "subject" => __("Payment Released", "escrowtics"),
            "details" => __("Escrow Amount released from", "escrowtics") . ' ' . $payer,
            "amount" => $amount,
            "balance" => $bal
        ]
    ];

    $notification = [
        "admin" => [
            "subject_id" => $subject_id,
            "user_id" => 0,
            "subject" => __("Escrow Payment Released, ID: ", "escrowtics") . $subject_id,
            "message" => "<strong>" . $payer . "</strong> " . __(" Released Payment for ", "escrowtics") . " " . $escrow_title . " " . __("to", "escrowtics") . " <strong>" . $earner . "</strong>",
            "status" => 0
        ],
        "user" => [
            "subject_id" => $subject_id,
            "user_id" => $user_id,
            "subject" => __("Escrow Payment Released, ID: ", "escrowtics") . $subject_id,
            "message" => __("Escrow Amount released from ", "escrowtics") . " <strong> " . $payer . "</strong>",
            "status" => 0
        ]
    ];

    escrot_process_log_and_notify($log, $notification);
}

// User Deposit
function escrot_log_notify_user_deposit($ref_id, $username, $payment_method, $amount, $bal, $user_id, $subject_id) {
    $log = [
        "admin" => [
            "ref_id" => $ref_id,
            "user_id" => 0,
            "subject" => __("User Deposit", "escrowtics"),
            "details" => $username . ' ' .sprintf( __("Made a %s deposit of %s ", "escrowtics"), $payment_method, escrot_option('currency') . $amount ),
            "amount" => $amount,
            "balance" => $bal
        ],
        "user" => [
            "ref_id" => $ref_id,
            "user_id" => $user_id,
            "subject" => __("User Deposit", "escrowtics"),
            "details" => sprintf( __("You Deposited %s via %s", "escrowtics"), escrot_option('currency') . $amount, $payment_method ),
            "amount" => $amount,
            "balance" => $bal
        ]
    ];

    $notification = [
        "admin" => [
            "subject_id" => $subject_id,
            "user_id" => 0,
            "subject" => __("New User Deposit, ID: ", "escrowtics") . $subject_id,
            "message" => "<strong>" . $username . "</strong> " . sprintf( __(" Made a deposit of %s via %s", "escrowtics"), escrot_option('currency') . $amount, $payment_method ),
            "status" => 0
        ],
        "user" => [
            "subject_id" => $subject_id,
            "user_id" => $user_id,
            "subject" => __("Deposit Successful, ID: ", "escrowtics") . $subject_id,
            "message" => sprintf( __("You have successfully deposited %s via %s", "escrowtics"), escrot_option('currency') . $amount, $payment_method ),
            "status" => 0
        ]
    ];

    escrot_process_log_and_notify($log, $notification);
}

// User Withdrawal
function escrot_log_notify_user_withdrawal($ref_id, $username, $amount, $bal, $user_id, $subject_id) {
    $log = [
        "admin" => [
            "ref_id" => $ref_id,
            "user_id" => 0,
            "subject" => __("User Withdrawal", "escrowtics"),
            "details" => $username . ' ' . __("Requested a withdrawal of", "escrowtics") . ' ' . escrot_option('currency') . $amount,
            "amount" => $amount,
            "balance" => $bal
        ],
        "user" => [
            "ref_id" => $ref_id,
            "user_id" => $user_id,
            "subject" => __("Withdrawal Request", "escrowtics"),
            "details" => __("You Requested a withdrawal of", "escrowtics") . ' ' . escrot_option('currency') . $amount,
            "amount" => $amount,
            "balance" => $bal
        ]
    ];

    $notification = [
        "admin" => [
            "subject_id" => $subject_id,
            "user_id" => 0,
            "subject" => __("New Withdrawal Request, ID: ", "escrowtics") . $subject_id,
            "message" => "<strong>" . $username . "</strong> " . __(" Requested a withdrawal of ", "escrowtics") . escrot_option('currency') . $amount,
            "status" => 0
        ],
        "user" => [
            "subject_id" => $subject_id,
            "user_id" => $user_id,
            "subject" => __("Withdrawal Request Received, ID: ", "escrowtics") . $subject_id,
            "message" => __("Your withdrawal request of ", "escrowtics") . escrot_option('currency') . $amount . __(" has been received.", "escrowtics"),
            "status" => 0
        ]
    ];

    escrot_process_log_and_notify($log, $notification);
}


//New Dispute
function  escrot_notify_new_dispute($dispute_id, $ref_id, $complainant, $accused,  $accused_id, $complainant_id) {  

    if(escrot_is_front_user()){
		$notification = [
		   "admin" => [
				"subject_id" => $dispute_id, 
				"user_id" => 0, 
				"subject" => __("New Dispute Opened, ID: ", "escrowtics").' #'.$ref_id,
				"message" => __("New Dispute Opened by", "escrowtics")." <strong>".$complainant."</strong>".__("against", "escrowtics")."  <strong>".$accused."</strong>",  
				"status" => 0
			],
			"accused" => [
				"subject_id" => $dispute_id, 
				"user_id" => $accused_id, 
				"subject" => __("New Dispute Opened, ID: ", "escrowtics").' #'.$ref_id,
				"message" => __("New Dispute Opened against you by", "escrowtics")." <strong>".$complainant."</strong>",  
				"status" => 0
			]			
		];
	} else {
		$notification = [
			"complainant" => [
				"subject_id" => $dispute_id, 
				"user_id" => $complainant_id, 
				"subject" => __("New Dispute Opened, ID: ", "escrowtics").' #'.$ref_id,
				"message" => __("New Dispute Opened by admin, for you against", "escrowtics")." <strong>".$accused."</strong>",  
				"status" => 0
						],
			"accused" =>   [
				"subject_id" => $dispute_id, 
				"user_id" => $accused_id, 
				"subject" => __("New Dispute Opened, ID: ", "escrowtics").' #'.$ref_id,
				"message" => __("New Dispute Opened against you by admin, Complainant: ", "escrowtics")." <strong>".$complainant."</strong>",  
				"status" => 0
			]				
		];
	}
	escrot_process_notify($notification);
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
	escrot_process_notify($notification);
}    		