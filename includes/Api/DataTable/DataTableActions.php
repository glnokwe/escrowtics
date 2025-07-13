<?php
/**
 * DataTable Actions Class
 *
 * Registers AJAX actions for handling various DataTables in the Escrowtics plugin.
 * Dynamically resolves and invokes the appropriate class methods for each action.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\DataTable;

defined('ABSPATH') || exit;


class DataTableActions {

    /**
     * List of actions with their corresponding handlers.
     * Key: Action name, Value: ['class' => ClassName, 'method' => MethodName]
     */
    private $actions = [
        'escrot_escrows_datatable'      => ['class' => 'EscrowDataTable', 'method' => 'escrowsTableData'],
        'escrot_earnings_datatable'     => ['class' => 'EarningsDataTable', 'method' => 'earningsTableData'],
        'escrot_view_escrows_datatable' => ['class' => 'ViewEscrowDataTable', 'method' => 'viewEscrowTableData'],
        'escrot_log_datatable'          => ['class' => 'LogDataTable', 'method' => 'logTableData'],
		'escrot_escrow_search_datatable'=> ['class' => 'EscrowSearchDataTable', 'method' => 'escrowsSearchTableData'],
		'escrot_users_datatable'        => ['class' => 'UsersDataTable', 'method' => 'usersTableData'],
		'escrot_invoice_datatable'      => ['class' => 'InvoiceDataTable', 'method' => 'invoiceTableData'],
		'escrot_dbbackup_datatable'     => ['class' => 'DBBackupDataTable', 'method' => 'dbBackupTableData'],
		'escrot_dispute_datatable'      => ['class' => 'DisputeDataTable', 'method' => 'disputeTableData']
    ];

    /**
     * Register hooks for all defined actions.
     */
    public function register() {
        foreach ($this->actions as $action => $handler) {
            add_action("wp_ajax_$action", [$this, 'handleAction']);
        }
    }

    /**
     * Handles AJAX actions dynamically by resolving the appropriate class and method.
     */
    public function handleAction() {
        $current_action = current_action();
        $action_key = str_replace('wp_ajax_', '', $current_action);

        if (isset($this->actions[$action_key])) {
            $handler = $this->actions[$action_key];
            $class = "Escrowtics\\Api\\DataTable\\{$handler['class']}";

            if (class_exists($class) && method_exists($class, $handler['method'])) {
                call_user_func([$class, $handler['method']]);
            } else {
                wp_send_json_error(['message' => __('Invalid Data Table configuration', 'escrowtics')], 400);
            }
        } else {
            wp_send_json_error(['message' => __('Invalid Data Table action', 'escrowtics')], 400);
        }
    }
}
