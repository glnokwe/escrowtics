<?php

defined('ABSPATH') || exit;

if(!isset($_GET['escrow_id']) && !isset($_GET['earn_id'])) { exit; }

// Get the escrow ID or earn ID from the request
$escrow_id = isset($_GET['escrow_id']) ? sanitize_text_field($_GET['escrow_id']) : 
              (isset($_GET['earn_id']) ? sanitize_text_field($_GET['earn_id']) : '');

// Check if escrow exist			  
if( !escrot_escrow_exist('escrow_id', $escrow_id) ) { echo __('Escrow not found. It may have been deleted', 'escrowtics'); exit; };			  

// Fetch data and metadata
$data = escrot_get_escrow_data($escrow_id);
$meta_data = $user->fetchEscrowMetaById($escrow_id);
$escrow_meta_count = $user->getEscrowMetaCount($escrow_id);

// Determine the table title & dispute option	
$open_dispute = false;
if (isset($_GET['escrow_id'])){
	$tbl_title = sprintf(__('Escrow History For %s', 'escrowtics'), ucwords($data['earner']));
	$accused = $data['earner'];
	if(	escrot_option('dispute_initiator') === 'payer' || escrot_option('dispute_initiator') === 'both' ){
		$open_dispute = true;
	}
} else{
	$tbl_title = sprintf(__('Escrow History by %s', 'escrowtics'), ucwords($data['payer']));
	$accused = $data['payer'];
	if(	escrot_option('dispute_initiator') === 'earner' || escrot_option('dispute_initiator') === 'both' ){
		$open_dispute = true;
	}
} 	

// Build the "Add Milestone" button
$add_milestone_button = sprintf(
    '<a type="button" class="btn btn-sm btn-outline-secondary btn-round float-left" %s>
        <i class="fas fa-plus"></i> %s
    </a>',
    ESCROT_INTERACTION_MODE === 'modal' 
        ? 'data-toggle="modal" data-target="#escrot-milestone-form-modal"' 
        : 'data-toggle="collapse" data-target="#escrot-milestone-form-dialog"',
    __('Add Milestone', 'escrowtics')
);

// Build the "Open Dispute" button
$open_dispute_button = sprintf(
    '<a type="button" data-escrot-accused="%s" id="%s" class="escrot-add-dispute-btn btn btn-sm btn-outline-secondary btn-round float-right" %s>
        <i class="fas fa-people-arrows"></i> %s
    </a>',
	$accused,
	$data['ref_id'],
    ESCROT_INTERACTION_MODE === 'modal' 
        ? 'data-toggle="modal" data-target="#escrot-add-dispute-modal"' 
        : 'data-toggle="collapse" data-target="#escrot-add-dispute-form-dialog"',
    __('Open Dispute', 'escrowtics')
);
  

// Render the content before the table
$before_table = '
<div class="escrot-content">    
    <div>
        <center>
            <h3 class="text-dark">' . esc_html($tbl_title) . '</h3>
        </center>
        ' . $add_milestone_button . ($open_dispute? $open_dispute_button : '') . '
    </div>
    <br><br>
    <div class="card shadow-lg p-3">
        <div class="table-responsive escrot-sa-users-tbl" id="escrot-view-escrow-table-wrapper">
';

// Output the content
echo $before_table;

// Include the escrow table template
include ESCROT_PLUGIN_PATH . 'templates/escrows/view-escrow-table.php';

// Close the divs
echo '</div></div></div>';
