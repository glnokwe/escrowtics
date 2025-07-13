<?php 
 /**
 * Escrow Search Results.
 * Show table formated results for escrow search.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */ 
 
use Escrowtics\Api\DataTable\DataTableSkeleton;

defined('ABSPATH') || exit;


$table_id = 'escrot-escrow-search-table';

$js_data = [
   'table-id'    => 'escrot-escrow-search-table',
   'ajax-action' => 'escrot_escrow_search_datatable',
   'front-hidden-col' => 0,
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
            'class' => 'btn btn-danger escrot-tbl-action-btn escrot-search-mult-delete-btn',
            'icon' => 'trash',
            'label' => __('Delete', 'escrowtics'),
            'delete_action' => 'escrot_del_escrows',
            'selected_class' => 'escrot-selected2'
        ],
    ],
];

$headers = [
    ['data-orderable' => 'false', 'content' => '<input type="checkbox" id="escrot-select-all3">'],
    ['content' => __('No.', 'escrowtics')],
    ['content' => __('Reference ID', 'escrowtics')],
    ['content' => __('Payer', 'escrowtics')],
    ['content' => __('Earner', 'escrowtics')],
    ['content' => __('Created Date', 'escrowtics')],
    ['content' => __('Action', 'escrowtics')],
];


// Render DataTable
$data_table = new DataTableSkeleton($table_id, $headers, $actions, $js_data, $data_count);
echo $data_table->render();
 
		