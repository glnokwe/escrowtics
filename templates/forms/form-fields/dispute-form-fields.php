<?php
/**
 * Dispute Form Fields Configuration.
 * This code generates form fields for dispute creation and management.
 *
 * @since   1.0.0
 * @package Escrowtics
 */
 
defined('ABSPATH') || exit; 

// Define form fields and attributes
$fields = [
    // Ajax Action Field for dispute submission
    'Ajax Action' => [
        'id'            => 'EscrotDisputeAjaxAction',
        'name'          => 'action',
        'type'          => 'hidden',
        'placeholder'   => '',
        'div-class'     => 'col-md-12',
        'callback'      => 'escrot_insert_dispute',
        'display'       => false,
        'help-info'     => '',
        'required'      => false
    ],

    // Nonce for security verification during AJAX requests
    'Ajax Nonce' => [
        'id'            => 'EscrotDisputeAjaxNonce',
        'name'          => 'nonce',
        'type'          => 'hidden',
        'placeholder'   => '',
        'div-class'     => 'col-md-12',
        'callback'      => wp_create_nonce('escrot_dispute_nonce'),
        'display'       => false,
        'help-info'     => '',
        'required'      => false
    ],

    // Dispute ID field (hidden)
    __('Dispute ID', 'escrowtics') => [
        'id'            => 'EscrotDisputeID',
        'name'          => 'dispute_id',
        'type'          => 'hidden',
        'placeholder'   => '',
        'div-class'     => 'col-md-12',
        'callback'      => '',
        'display'       => false,
        'help-info'     => '',
        'required'      => false
    ],
	
    // Reason for dispute (dropdown)
    __('Reason for Dispute', 'escrowtics') => [
        'id'            => 'EscrotDisputeSubject',
        'name'          => 'reason',
        'type'          => 'select',
        'placeholder'   => '',
        'div-class'     => 'col-md-6',
        'callback'      => explode(',', escrot_option('dispute_reasons')),
        'display'       => true,
        'help-info'     => '',
        'required'      => true
    ],

    // Escrow Ref ID (text)
    __('Escrow Ref ID', 'escrowtics') => [
        'id'            => 'EscrotDisputeEscrowRefID',
        'name'          => 'escrow_ref',
        'type'          => 'number',
        'placeholder'   => '',
        'div-class'     => 'col-md-6',
        'callback'      => '',
        'display'       => true,
        'help-info'     => __('Dispute will be added for the most recent escrow milestone which is still open', 'escrowtics'),
        'required'      => true
    ],
	
    // Complainant User (dropdown)
    __('Complaining User', 'escrowtics') => [
        'id'            => 'EscrotDisputeComplainant',
        'name'          => 'complainant',
        'type'          => 'select',
        'placeholder'   => '',
        'div-class'     => 'col-md-4',
        'callback'      => ['' => '-- Select --', 'payer' => __('Payer', 'escrowtics'), 'earner' => __('Earner', 'escrowtics')],
        'display'       => !escrot_is_front_user(),
        'help-info'     => __('Who is making the complaint, Escrow Payer or Earner?', 'escrowtics'),
        'required'      => true
    ],

    // Priority (dropdown)
    __('Priority', 'escrowtics') => [
        'id'            => 'EscrotDisputePriority',
        'name'          => 'priority',
        'type'          => 'select',
        'placeholder'   => '',
        'div-class'     => escrot_is_front_user() ? 'col-md-6' : 'col-md-4',
        'callback'      => [__('Low', 'escrowtics'), __('Medium', 'escrowtics'), __('High', 'escrowtics')],
        'display'       => true,
        'help-info'     => '',
        'required'      => true
    ],

    // Resolution Requested (dropdown)
    __('Resolution Requested', 'escrowtics') => [
        'id'            => 'EscrotDisputeResolution',
        'name'          => 'resolution_requested',
        'type'          => 'select',
        'placeholder'   => '',
        'div-class'     => escrot_is_front_user() ? 'col-md-6' : 'col-md-4',
        'callback'      => explode(',', escrot_option('dispute_resolutions')),
        'display'       => true,
        'help-info'     => '',
        'required'      => false
    ],

    // Issue Description (textarea)
    __('Describe the Issue', 'escrowtics') => [
        'id'            => 'EscrotDisputeMessage',
        'name'          => 'message',
        'type'          => 'textarea',
        'placeholder'   => '',
        'div-class'     => 'col-md-12',
        'callback'      => '',
        'display'       => true,
        'help-info'     => '',
        'required'      => true
    ],

    // Attachment (image upload)
    __('File Attachment', 'escrowtics') => [
        'id'            => 'EscrotDisputeAttachment',
        'name'          => 'attachment',
        'type'          => 'file',
        'placeholder'   => 'escrot-preview-chat-attach', // use to store a class in this case 
        'div-class'     => 'col-md-12',
        'callback'      => 'escrot-chat-attachment', // use to store a class in this case 
        'display'       => escrot_is_front_user() ? escrot_option('enable_dispute_evidence') : true,
        'help-info'     => '',
        'required'      => false
    ]
];


// Update the AJAX action callback if the form type is "edit"
if ($form_type === "edit") {
    $fields['Ajax Action']['callback'] = 'escrot_update_dispute'; // Update action for edit form
}

// Include the form fields manager template
include ESCROT_PLUGIN_PATH . "templates/forms/form-fields/form-fields-manager.php";
