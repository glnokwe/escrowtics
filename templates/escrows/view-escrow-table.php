<?php
/**
 * Escrow Milestone Table.
 * Lists escrow milestones for two unique users.
 *
 * @since 1.0.0
 */
 
 
 use Escrowtics\Api\DataTable\DataTableSkeleton;

defined('ABSPATH') || exit;


$table_id = 'escrot-escrow-meta-table';

$js_data = [
   'table-id' => 'escrot-escrow-meta-table',
   'ajax-action' => 'escrot_view_escrows_datatable',
   'escrow-id' => $escrow_id?? '',
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
            'icon' => 'fas fa-check',
            'label' => __('Apply', 'escrowtics')
        ],
        'escrot-option2' => [
            'class' => 'btn btn-danger escrot-tbl-action-btn escrot-mult-delete-btn',
            'icon' => 'fas fa-trash',
            'label' => __('Delete', 'escrowtics'),
            'delete_action' => 'escrot_del_escrow_metas',
            'selected_class' => 'escrot-selected'
        ],
    ],
];

$headers = [
    ['data-orderable' => 'false', 'content' => '<input type="checkbox" id="escrot-select-all">'],
    ['content' => __('No.', 'escrowtics')],
    ['content' => __('Amount (Payable)', 'escrowtics')],
    ['content' => __('Title', 'escrowtics')],
    ['content' => __('Status', 'escrowtics')],
    ['content' => __('Date', 'escrowtics')],
    ['content' => __('Action', 'escrowtics')],
];

// Render DataTable
$data_table = new DataTableSkeleton($table_id, $headers, $actions, $js_data, $escrow_meta_count);
echo $data_table->render();