<?php 
 /**
 * The Users Table.
 * List all available Escrow Users.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */ 


use Escrowtics\Api\DataTable\DataTableSkeleton;

defined('ABSPATH') || exit;


$data_count = $this->getTotalUserCount();

$table_id = 'escrot-user-table';

$js_data = [
   'table-id' => 'escrot-user-table',
   'ajax-action' => 'escrot_users_datatable',
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
            'class' => 'btn btn-danger escrot-tbl-action-btn escrot-mult-delete-user-btn',
            'icon' => 'trash',
            'label' => __('Delete', 'escrowtics'),
            'delete_action' => 'escrot_del_users',
            'selected_class' => 'escrot-selected'
        ],
    ],
];

$headers = [
    ['data-orderable' => 'false', 'content' => '<input type="checkbox" id="escrot-select-all">'],
    ['content' => __('No.', 'escrowtics')],
    ['content' => __('Image', 'escrowtics')],
    ['content' => __('Username', 'escrowtics')],
	['content' => __('Escrows', 'escrowtics')],
	['content' => __('Earnings', 'escrowtics')],
    ['content' => __('Balance', 'escrowtics')],
    ['content' => __('Created', 'escrowtics')],
    ['content' => __('Action', 'escrowtics')],
];


// Render DataTable
$data_table = new DataTableSkeleton($table_id, $headers, $actions, $js_data, $data_count);
echo $data_table->render();
 

