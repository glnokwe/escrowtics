<?php
/**
 * Earnings DataTable Class
 * Handles the server-side processing and rendering of 
 * the DataTable for escrow earnings data.
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

namespace Escrowtics\Api\DataTable;

use Escrowtics\Api\DataTable\SSP;

defined('ABSPATH') || exit;


class EarningsDataTable {
	
    /**
     * Fetches escrow earnings data for DataTable.
	 *
     * Handles server-side processing of earnings data and formats it for DataTable.
     * @return void Outputs JSON response for DataTable.
     */
    public static function earningsTableData() {
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
                        'check_box' => '<input type="checkbox" class="escrot-checkbox" data-escrot-row-id="'. esc_attr($d) .'">',
                        'row_id' => esc_attr($d),
                    ];
                },
            ],
            [
                'db' => 'escrow_id',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    static $rowIndex = 0; // Static variable to maintain row index
                    return ++$rowIndex; // Increment and return index
                },
            ],
            ['db' => 'ref_id', 'dt' => 2],
            ['db' => 'payer', 'dt' => 3],
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
                        'actions' => self::earningsTableAction($d, $row['ref_id']),
                    ];
                },
            ],
        ];

        // Default WHERE condition
        $where = "1=1";
		

        // Filter user data for front-end users
        if (escrot_is_front_user()) {
            $user = wp_get_current_user();
            $username = $user->user_login;
            $where = $wpdb->prepare("earner = %s", sanitize_text_field($username));
        }
		
		// Filter user data - admin
        if (isset($_POST['extraData'][0]['user_id'])) {
			$user_id = sanitize_text_field($_POST['extraData'][0]['user_id']);
            $user = get_user_by('ID', sanitize_text_field($user_id));
            if ($user) {
                $username = $user->user_login;
                $where = $wpdb->prepare("earner = %s", sanitize_text_field($username));
            }
        } 

        // Use the SSP class with the WHERE clause
        $response = SSP::complex($_POST, $table, $primaryKey, $columns, $where);

        // Send JSON response
        wp_send_json($response);
    }

    /**
     * Generates action buttons for an earnings row.
     *
     * @param int    $escrow_id The escrow ID.
     * @param string $ref_id    The reference ID for the escrow.
     * @return string HTML string for the action buttons.
     */
    public static function earningsTableAction($escrow_id, $ref_id) {
        ob_start();

        include ESCROT_PLUGIN_PATH . "templates/frontend/user-routes.php";

        ?>
        <center>
            <?php if (escrot_is_front_user()) : ?>
                <?php
                $earn_url = isset($_POST['extraData'][0]['earn_url']) ? esc_url($_POST['extraData'][0]['earn_url']) : '';
                $earn_url = add_query_arg(['earn_id' => $escrow_id], $earn_url);
                ?>
                <a href="<?= $earn_url; ?>" class="btn escrot-btn-secondary btn-icon-text escrot-btn-sm">
                    <i class="fas fa-eye"></i> &nbsp;<?php esc_html_e('View', 'escrowtics'); ?>
                </a>
                <?php if (in_array(escrot_option('dispute_initiator'), ['earner', 'both'], true)) : ?>
                    <a href="#" id="<?= esc_attr($ref_id); ?>" class="escrot-add-dispute-btn btn btn-info btn-icon-text escrot-btn-sm"
                       <?= (ESCROT_INTERACTION_MODE === "modal") ? 'data-toggle="modal" data-target="#escrot-add-dispute-modal"' : 'data-toggle="collapse" data-target="#escrot-add-dispute-form-dialog"'; ?>>
                        <i class="fas fa-people-arrows"></i> &nbsp;<?php esc_html_e('Open Dispute', 'escrowtics'); ?>
                    </a>
                <?php endif; ?>
            <?php else : ?>
                <a href="admin.php?page=escrowtics-view-escrow&escrow_id=<?= esc_attr($escrow_id); ?>" class="btn escrot-btn-behance btn-icon-text escrot-btn-sm">
                    <i class="fas fa-eye"></i> &nbsp;<?php esc_html_e('View', 'escrowtics'); ?>
                </a>
                <a href="#" id="<?= esc_attr($escrow_id); ?>" class="btn btn-danger btn-icon-text escrot-btn-sm escrot-delete-btn" data-action="escrot_del_escrow">
                    <i class="fas fa-trash"></i> &nbsp;<?php esc_html_e('Delete', 'escrowtics'); ?>
                </a>
            <?php endif; ?>
        </center>
        <?php

        return ob_get_clean();
    }
}
