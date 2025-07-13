<?php

/**
* Database Static Helper functions
* Plugin-wide Specific database helper functionalities
*
* @since      1.0.0
* @package    Escrowtics
*/

defined('ABSPATH') || exit;

//Get User Data
function escrot_get_user_data($user_id) {
		$user_id = absint($user_id); // Ensure the user ID is an integer.
		$user = get_userdata($user_id);

		if (!$user) {
			return null; // User does not exist.
		}

		// Retrieve user data.
		$user_data = [
			'ID'              => $user->ID,
			'user_login'      => $user->user_login,
			'user_email'      => $user->user_email,
			'first_name'      => $user->first_name,
			'last_name'       => $user->last_name,
			'user_registered' => $user->user_registered,
			'display_name'    => $user->display_name
			
		];

		// Retrieve all user meta.
		$user_meta = get_user_meta($user_id);

		// Flatten meta (to handle single and multiple values properly).
		foreach ($user_meta as $key => $value) {
			$user_meta[$key] = maybe_unserialize($value[0]);
		}

		// Combine user data and meta into one array.
		$combined_data = array_merge($user_data, $user_meta);

		return $combined_data;
}


//Get Sinle User Data
function escrot_single_user_meta($username, $meta_key) {
	$user = get_user_by('login', $username);
	if (!$user) { return; }
	return get_user_meta($user->ID, $meta_key, true)?? "";
}


//Check if Dispute Exist
function escrot_dispute_exist($dispute_id) {
	global $wpdb;
    $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}escrowtics_disputes WHERE dispute_id = %d";
    $rowCount = $wpdb->get_var($wpdb->prepare($sql, $dispute_id));
    if($rowCount == 1){
	   return true;
    } else {
	  return false; 
    }
}


//Get Escrow Data from id
function escrot_get_escrow_data($id) {
	global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}escrowtics_escrows WHERE escrow_id = %d";
    $row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
    return $row[0];
}


//Get Escrow Data from Ref_id
function escrot_get_escrow_by_ref($ref_id) {
	global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}escrowtics_escrows WHERE ref_id = %d";
    $row = $wpdb->get_results($wpdb->prepare($sql, $ref_id), ARRAY_A);
    return $row[0];
}

//Check if Escrow Exist
function escrot_escrow_exist($col, $val) {
	global $wpdb;
    $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}escrowtics_escrows WHERE {$col} = %d";
    $rowCount = $wpdb->get_var($wpdb->prepare($sql, $val));
    if($rowCount == 1){
	   return true;
    } else {
	  return false; 
    }
}


//Get current users list
function escrot_users(){
	$users = get_users(['role' => 'escrowtics_user']);
	$data = [];
	foreach ( $users as $user ) {
		$data[$user->user_login] = $user->user_login;
	}
	return $data;
}

//Get current wordpress pages list
function escrot_wp_pages(){
	 $pages = get_pages(); 
	 $data = [];
	foreach ( $pages as $page ) {
		$data[$page->ID] = $page->post_title;
	}
	return $data;
}


/**
 * Retrieves invoice data by its code & payment method.
 *
 * @param string $code Invoice code.
 * @param string $payment_method Payment Method.
 * @return array Invoice data.
 */
function escrot_get_invoice_data($code, $payment_method) {
	global $wpdb;
	$sql = "SELECT * FROM {$wpdb->prefix}escrowtics_invoices WHERE code = %s AND payment_method = %s";
	return $wpdb->get_row($wpdb->prepare($sql, [$code, $payment_method]), ARRAY_A);
}

