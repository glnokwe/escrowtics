<?php

/**
 * Frontend collapseable dialogs
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */
 
 defined('ABSPATH') || exit;


$dialogs = [
		
    ['id' => 'escrot-add-escrow-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Add Escrow", "escrowtics"),
	'callback' => 'add-escrow-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-view-milestone-dialog',
	'data_id' => 'escrot-milestone-details',
	'header' => '',
	'title' => __("Escrow Milestone Details", "escrowtics"),
	'callback' => '',
	'type' => 'data'
   ],
   
   ['id' => 'escrot-milestone-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Add Milestone", "escrowtics"),
	'callback' => 'add-milestone-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-bitcoin-deposit-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("User Deposit - Bitcoin", "escrowtics"),
	'callback' => 'bitcoin-deposit-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-bitcoin-withdraw-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("User Withdrawal - Bitcoin", "escrowtics"),
	'callback' => 'bitcoin-withdrawal-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-paypal-deposit-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Paypal Deposit", "escrowtics"),
	'callback' => 'paypal-deposit-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-paypal-withdraw-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Paypal Withdrawal", "escrowtics"),
	'callback' => 'paypal-withdraw-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-manual-deposit-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Manual Deposit", "escrowtics"),
	'callback' => 'manual-deposit-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-manual-withdraw-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Manual Withdrawal", "escrowtics"),
	'callback' => 'manual-withdraw-form.php',
	'type' => 'add-form'
   ],
   
   ['id' => 'escrot-add-dispute-form-dialog',
	'data_id' => '',
	'header' => '',
	'title' => __("Add Dispute", "escrowtics"),
	'callback' => 'add-dispute-form.php',
	'type' => 'add-form'
   ]
];

escrot_callapsable_dialogs($dialogs);