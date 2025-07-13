<?php
/**
 * Disputes Table.
 * Displays a list of available escrow disputes with actions for admin users.
 *
 * @since 1.0.0
 */
 
use Escrowtics\Api\DataTable\DataTableSkeleton;

defined('ABSPATH') || exit; 



$table_id = 'escrot-dispute-table';

$js_data = [
   'table-id' => 'escrot-dispute-table',
   'ajax-action' => 'escrot_dispute_datatable',
   'front-hidden-col' => 0,
   'dispute-url' => $dispute_url?? '',
   'order-col'   => 5
];

$actions = [
    'select_id' => 'escrot-list-actions',
    'options' => [
        'escrot-option1' => 'Select action',
        'escrot-option2' => 'Delete',
    ],
    'buttons' => [
        'escrot-option1' => [
            'class' => 'btn escrot-tbl-action-btn',
            'icon' => 'check',
            'label' => __('Apply', 'escrowtics')
        ],
        'escrot-option2' => [
            'class' => 'btn btn-danger escrot-tbl-action-btn escrot-dispute-mult-delete-btn',
            'icon' => 'trash',
            'label' => __('Delete', 'escrowtics'),
            'delete_action' => 'escrot_del_users',
            'selected_class' => 'escrot-selected'
        ],
    ],
];
$dispute_party = '';

if(!escrot_is_front_user()){
	$dispute_party = __('Parties', 'escrowtics');
} else {
	if(isset($_GET['endpoint']) && $_GET['endpoint'] === "my_disputes" ){
		$dispute_party = __('Accused', 'escrowtics');
	}

	if(isset($_GET['endpoint']) && $_GET['endpoint'] === "disputes_against_me" ){
		$dispute_party = __('Complainant', 'escrowtics');
	}
}

$headers = [
    ['data-orderable' => 'false', 'content' => '<input type="checkbox" id="escrot-select-all">'],
    ['content' => __('No.', 'escrowtics')],
    ['content' => __('Escrow Ref#', 'escrowtics')],
	['content' => $dispute_party,       ],
	['content' => __('Reason', 'escrowtics')],
	['content' => __('Priority', 'escrowtics')],
    ['content' => __('Status', 'escrowtics')],
    ['content' => __('Updated', 'escrowtics')],
    ['content' => __('Action', 'escrowtics')],
];


// Render DataTable
$data_table = new DataTableSkeleton($table_id, $headers, $actions, $js_data, $disputes_count);
echo $data_table->render();
 
