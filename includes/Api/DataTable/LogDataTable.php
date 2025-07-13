<?php
/**
 * Log DataTable Class
 * Handles server-side processing for transaction logs in DataTable.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\DataTable;

use Escrowtics\Api\DataTable\SSP;

defined('ABSPATH') || exit;


class LogDataTable {

    /**
     * Fetches log data for DataTable.
     *
     * Handles user-specific filtering and data formatting.
     * @return void Outputs JSON response for DataTable.
     */
    public static function logTableData() {
        global $wpdb;

        // Table primary key
        $primaryKey = 'log_id';

        // Table name
        $table = $wpdb->prefix . "escrowtics_transactions_log";

        // Columns to retrieve and send back to DataTable
        $columns = [
            [
                'db' => 'log_id',
                'dt' => 0,
                'formatter' => function ($d, $row) {
                    return [
                        'check_box' => '<input type="checkbox" class="escrot-checkbox" data-escrot-row-id="' . esc_attr($d) . '">',
                        'row_id' => esc_attr($d),
                    ];
                },
            ],
            [
                'db' => 'log_id',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    static $rowIndex = 0;
                    return ++$rowIndex;
                },
            ],
            ['db' => 'ref_id', 'dt' => 2],
            ['db' => 'amount', 'dt' => 3],
            ['db' => 'details', 'dt' => 4],
            [
                'db' => 'creation_date',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return date_i18n('jS M Y', strtotime($d));
                },
            ],
            [
                'db' => 'log_id',
                'dt' => 6,
                'formatter' => function ($d, $row) {
                    return [
                        'actions' => self::logTableActions($d),
                    ];
                },
            ],
        ];

        // Filtering logic
        $where = "1=1"; // Default condition
        if (escrot_is_front_user()) {
            $user_id = get_current_user_id(); // Assuming user ID is used for filtering
            $where = $wpdb->prepare("user_id = %d", $user_id);
        }

        // Use the SSP class with the WHERE clause
        $response = SSP::complex($_POST, $table, $primaryKey, $columns, $where);

        // Send JSON response
        wp_send_json($response);
    }
	

    /**
     * Generates action buttons for a log row.
     *
     * @param int $log_id The log ID.
     * @return string HTML string for the action buttons.
     */
    public static function logTableActions($log_id) {
        if (escrot_is_front_user()) {
            return ''; // No actions for front-end users
        }

        ob_start();
        ?>
        <td>
            <center>
                <a href="#" id="escrot-log-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <button class="btn btn-flat escrot-btn-sm escrot-btn-primary">
                        <i class="fas fa-ellipsis-vertical"></i>
                    </button>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="escrot-log-dropdown">
                    <a href="#" 
                       id="<?= esc_attr($log_id); ?>" 
                       class="dropdown-item escrot-rounded escrot-delete-btn" 
                       data-action="escrot_del_log">
                        <i class="text-danger fas fa-trash"></i> &nbsp; <?php esc_html_e('Delete', 'escrowtics'); ?>
                    </a>
                </div>
            </center>
        </td>
        <?php
        return ob_get_clean();
    }
	
	
}
