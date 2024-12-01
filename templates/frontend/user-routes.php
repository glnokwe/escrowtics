<?php

$routes = [];

$endpoints = ['dashboard', 'add_escrow', 'escrow_list', 'earning_list', 'view_transaction', 'transaction_log', 'deposit_history', 'withdraw_history', 'user_profile', 'deposit_payment_options', 'withdraw_payment_options', 'bitcoin_deposit_invoice', 'bitcoin_withdraw_invoice', 'support_tickets', 'view_ticket'];

$endpoint_url = explode("?", esc_url(escrot_current_url()))[0];

foreach($endpoints as $endpoint) {
	$routes[$endpoint] =  add_query_arg(['endpoint' => $endpoint],  $endpoint_url );
}