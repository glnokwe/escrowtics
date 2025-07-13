<?php
/**
* Payment Invoices Table.
* List all available invoices.
* 
* @since      1.0.0
*/

use Escrowtics\Api\DataTable\DataTableSkeleton;

defined('ABSPATH') || exit;

$table_id = 'escrot-invoice-table';

$js_data = [
   'table-id' => $table_id,
   'ajax-action' => 'escrot_invoice_datatable',
   'front-hidden-col' => '[0, 3, 4]',
   'invoice-url' => $invoice_url?? '',
   'invoice-type' => $invoice_type?? '',
   'order-col'   => 7
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
            'class' => 'btn btn-danger escrot-tbl-action-btn escrot-mult-delete-btn',
            'icon' => 'trash',
            'label' => __('Delete', 'escrowtics'),
            'delete_action' => 'escrot_del_invoices',
            'selected_class' => 'escrot-selected'
        ],
    ],
];

$headers = [
    ['data-orderable' => 'false', 'content' => '<input type="checkbox" id="escrot-select-all">'],
    ['content' => __('No.', 'escrowtics')],
    ['content' => __('Invoice ID', 'escrowtics')],
	['content' => __('User', 'escrowtics')],
	['content' => __('Amount', 'escrowtics')],
    ['content' => __('Payment Method', 'escrowtics')],
    ['content' => __('Status', 'escrowtics')],
    ['content' => __('Created Date', 'escrowtics')],
    ['content' => __('Action', 'escrowtics')]
];


// Render DataTable
$data_table = new DataTableSkeleton($table_id, $headers, $actions, $js_data, $data_count);
echo $data_table->render();
 

