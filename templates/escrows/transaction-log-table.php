<?php
/**
* Transaction Log Table.
* Escrow Transaction log.
* 
* @since      1.0.0
*/


use Escrowtics\Api\DataTable\DataTableSkeleton;

defined('ABSPATH') || exit;


$table_id = 'escrot-log-table';

$js_data = [
   'table-id'    => 'escrot-log-table',
   'ajax-action' => 'escrot_log_datatable',
   'front-hidden-col' => '[0, 6]',
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
            'icon' => 'fas fa-check',
            'label' => __('Apply', 'escrowtics')
        ],
        'escrot-option2' => [
            'class' => 'btn btn-danger escrot-tbl-action-btn escrot-mult-delete-btn',
            'icon' => 'fas fa-trash',
            'label' => __('Delete', 'escrowtics'),
            'delete_action' => 'escrot_del_logs',
            'selected_class' => 'escrot-selected'
        ],
    ],
];

$headers = [
    ['data-orderable' => 'false', 'content' => '<input type="checkbox" id="escrot-select-all">'],
    ['content' => __('No.', 'escrowtics')],
    ['content' => __('Transaction ID', 'escrowtics')],
	['content' => __('Amount', 'escrowtics')],
    ['content' => __('Details', 'escrowtics')],
    ['content' => __('Date', 'escrowtics')],
    ['content' => __('Action', 'escrowtics')],
];

$data_count = $log_count;

// Render DataTable
$data_table = new DataTableSkeleton($table_id, $headers, $actions, $js_data, $data_count);
echo $data_table->render();
