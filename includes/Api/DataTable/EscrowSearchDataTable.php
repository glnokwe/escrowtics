<?php
/**
 * Escrow Search DataTable Class
 * Handles server-side processing for escrow search results in DataTable.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\DataTable;

use Escrowtics\Api\DataTable\SSP;

defined('ABSPATH') || exit;


class EscrowSearchDataTable {

    /**
     * Fetches escrow search data for DataTable.
     *
     * Handles search term processing, filtering, and data formatting.
     * @return void Outputs JSON response for DataTable.
     */
    public static function escrowsSearchTableData() {
        global $wpdb;

        // Table primary key
        $primaryKey = 'escrow_id';

        // Table name
        $table = $wpdb->prefix . "escrowtics_escrows";

        // Columns to retrieve and send back to DataTables
        $columns = [
            [
                'db' => 'escrow_id',
                'dt' => 0,
                'formatter' => function ($d, $row) {
                    return [
                        'check_box' => '<input type="checkbox" class="escrot-checkbox2" data-escrot-row-id="'. esc_attr($d) .'">',
                        'row_id' => esc_attr($d),
                    ];
                },
            ],
            [
                'db' => 'escrow_id',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    static $rowIndex = 0;
                    return ++$rowIndex;
                },
            ],
            ['db' => 'ref_id', 'dt' => 2],
            ['db' => 'payer',  'dt' => 3],
            ['db' => 'earner', 'dt' => 4],
            [
                'db' => 'creation_date',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return date_i18n('jS M Y', strtotime($d));
                },
            ],
            [
                'db' => 'escrow_id',
                'dt' => 6,
                'formatter' => function ($d, $row) {
                    return [
                        'actions' => self::escrowSearchTableAction($d),
                    ];
                },
            ],
        ];

        // Retrieve and sanitize the search term
        $search_text = isset($_POST['extraData'][0]['search']) ? sanitize_text_field($_POST['extraData'][0]['search']) : '';
        $search_like = '%' . $wpdb->esc_like($search_text) . '%';

        // Build the WHERE clause for filtering
        $where = $wpdb->prepare("(earner LIKE %s OR payer LIKE %s OR ref_id LIKE %s)", $search_like, $search_like);

        // Fetch data using the SSP class with the WHERE clause
        $response = SSP::complex($_POST, $table, $primaryKey, $columns, $where);

        // Highlight search terms in relevant columns
        if (!empty($response['data']) && is_array($response['data'])) {
            foreach ($response['data'] as &$row) {
                foreach ([2, 3, 4] as $columnIndex) { // Columns to highlight
                    if (!empty($row[$columnIndex])) {
                        $row[$columnIndex] = str_ireplace(
                            $search_text,
                            '<b>' . esc_html($search_text) . '</b>',
                            esc_html($row[$columnIndex])
                        );
                    }
                }
            }
        }

        // Add a custom message for when no records are found
        $response['no_records_message'] = sprintf(
            __('No records found for search phrase <b>%s</b>', 'escrowtics'),
            esc_html($search_text)
        );

        // Send JSON response
        wp_send_json($response);
    }
	

    /**
     * Generates action buttons for an escrow row.
     *
     * @param int $escrow_id The escrow ID.
     * @return string HTML string for the action buttons.
     */
    public static function escrowSearchTableAction($escrow_id) {
        ob_start();
        ?>
        <center>
            <a href="admin.php?page=escrowtics-view-escrow&escrow_id=<?= esc_attr($escrow_id); ?>" 
               class="btn escrot-btn-behance btn-icon-text escrot-btn-sm">
                <i class="fas fa-eye"></i> &nbsp;<?php esc_html_e('View', 'escrowtics'); ?>
            </a>
            <a href="#" 
               id="<?= esc_attr($escrow_id); ?>" 
               class="btn btn-danger btn-icon-text escrot-btn-sm escrot-delete-btn" 
               data-action="escrot_del_escrow">
                <i class="fas fa-trash"></i> &nbsp;<?php esc_html_e('Delete', 'escrowtics'); ?>
            </a>
        </center>
        <?php
        return ob_get_clean();
    }
	
	
}
