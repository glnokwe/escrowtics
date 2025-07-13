<?php
/**
 * User DataTable Class
 * Handles the server-side processing and rendering of the DataTable for user data.
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

namespace Escrowtics\Api\DataTable;

use Escrowtics\Api\DataTable\SSP;

defined('ABSPATH') || exit;


class UsersDataTable {
    /**
     * Fetches user data for DataTable.
     *
     * Handles server-side processing of user data and formats it for DataTable.
     * @return void Outputs JSON response for DataTable.
     */
    public static function usersTableData() {
        global $wpdb;

        // Table primary key
        $primaryKey = 'ID';

        // Table name
        $table = $wpdb->prefix . "escrowtics_users";

        // Columns to retrieve and send back to DataTables
        $columns = [
            [
                'db' => 'ID',
                'dt' => 0,
                'formatter' => function ($d, $row) {
                    return [
                        'check_box' => '<input type="checkbox" class="escrot-checkbox" data-escrot-row-id="' . esc_attr($d) . '">',
                        'row_id' => esc_attr($d),
                    ];
                },
            ],
            [
                'db' => 'ID',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    static $rowIndex = 0; // Static variable to maintain row index
                    return ++$rowIndex; // Increment and return index
                },
            ],
            [
                'db' => 'user_image',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    return [
                        'user_img' => escrot_image($d, 30, 'rounded'),
                    ];
                },
            ],
            ['db' => 'user_login', 'dt' => 3],
            [
                'db' => 'user_login',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    return [
                        'escrow_count' => self::getUserEscrowsCount($d),
                    ];
                },
            ],
            [
                'db' => 'user_login',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return [
                        'earnings_count' => self::getUserEarningsCount($d),
                    ];
                },
            ],
            ['db' => 'balance', 'dt' => 6],
            [
                'db' => 'user_registered',
                'dt' => 7,
                'formatter' => function ($d, $row) {
                    return date_i18n('jS M Y', strtotime($d));
                },
            ],
            [
                'db' => 'ID',
                'dt' => 8,
                'formatter' => function ($d, $row) {
                    return [
                        'actions' => self::userTableAction($d),
                    ];
                },
            ],
        ];

        // Use the SSP class for server-side processing
        $response = SSP::getEscrotUsers($_POST, $columns);

        // Send JSON response
        wp_send_json($response);
    }

    /**
     * Generates action buttons for a user row.
     *
     * @param int $user_id The user ID.
     * @return string HTML string for the action buttons.
     */
    public static function userTableAction($user_id) {
        ob_start();
        ?>
        <center>
            <a href="admin.php?page=escrowtics-user-profile&user_id=<?= esc_attr($user_id); ?>" id="<?= esc_attr($user_id); ?>" 
               class="btn btn-info btn-icon-text escrot-btn-sm" 
               title="<?php esc_attr_e('View User', 'escrowtics'); ?>">
                <i class="fas fa-user"></i>
            </a>
            <a href="#" id="escrotDropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <button class="btn btn-flat escrot-btn-sm escrot-btn-primary">
                    <i class="fas fa-ellipsis-vertical"></i>
                </button>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="escrotDropdownUser">
				<a href="#" id="<?= $user_id; ?>" class="dropdown-item escrot-user-edit-btn escrot-rounded" 
				data-toggle="<?= ESCROT_INTERACTION_MODE === 'modal' ? 'modal' : 'collapse'; ?>" 
				data-target="<?=ESCROT_INTERACTION_MODE  === 'modal' ? '#escrot-edit-user-modal' : '#escrot-edit-user-form-dialog'; ?>">
                     <i class="text-info fas fa-user-pen"></i> &nbsp; <?php esc_html_e('Quick Edit', 'escrowtics'); ?>
                </a>
					
                <a href="#" id="<?= esc_attr($user_id); ?>" 
                   class="dropdown-item escrot-delete-user-btn escrot-rounded">
                    <i class="text-danger fas fa-trash"></i> &nbsp; <?php esc_html_e('Delete', 'escrowtics'); ?>
                </a>
            </div>
        </center>
        <?php  return ob_get_clean();
    }
	

    /**
     * Gets the total number of escrows associated with a user as the payer.
     *
     * @param string $user_login The user_login of the payer.
     * @return int The total count of escrows.
     */
    public static function getUserEscrowsCount($user_login) {
        global $wpdb;
        $table = $wpdb->prefix . "escrowtics_escrows";
        $sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table} WHERE payer = %s", sanitize_text_field($user_login));
        return (int) $wpdb->get_var($sql);
    }

    /**
     * Retrieves all escrows where a user is listed as the earner.
     *
     * @param string $user_login The user_login of the earner.
     * @return array An array of escrow records where the user is the earner.
     */
    public static function getUserEarningsCount($user_login) {
        global $wpdb;
        $table = $wpdb->prefix . "escrowtics_escrows";
        $sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table} WHERE earner = %s", sanitize_text_field($user_login));
        return (int) $wpdb->get_var($sql);
    }



}
