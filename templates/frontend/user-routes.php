<?php
/**
 * Escrowtics Frontend Routes
 * Maps predefined endpoints to the current URL.
 * Generates routes for frontend navigation.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */
 
 defined('ABSPATH') || exit;

// Initialize an empty array to hold route definitions
$routes = [];

// Define a list of frontend endpoints
$endpoints = [
    'dashboard', 
    'add_escrow', 
    'escrow_list', 
    'earning_list', 
    'view_escrow', 
    'transaction_log', 
    'deposit_history', 
    'withdraw_history', 
    'user_profile', 
	'user_dashboard',
    'deposit_payment_options', 
    'withdraw_payment_options', 
    'bitcoin_deposit_invoice',
	'paypal_deposit_invoice',
    'paypal_withdraw_invoice',	
	'manual_deposit_invoice',
    'bitcoin_withdraw_invoice', 
    'my_disputes', 
    'disputes_against_me',  
    'view_dispute'
];

// Get the full current URL
$current_url = esc_url(escrot_current_url());

// Parse the current URL into components
$parsed_url = wp_parse_url($current_url);

// Parse query parameters from the current URL
$current_query_args = [];
if (isset($parsed_url['query'])) {
    wp_parse_str($parsed_url['query'], $current_query_args);
}

// Get the base URL without query parameters
$base_url = strtok($current_url, '?');

// Build routes by adding/updating each endpoint as a query argument
foreach ($endpoints as $endpoint) {
    // Add or update the 'endpoint' parameter
    $updated_query_args = array_merge($current_query_args, ['endpoint' => $endpoint]);

    // Build the full URL with the updated query parameters
    $routes[$endpoint] = add_query_arg($updated_query_args, $base_url);
}

