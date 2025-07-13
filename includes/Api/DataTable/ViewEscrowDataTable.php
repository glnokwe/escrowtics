<?php
/**
 * View Escrow DataTable Class
 * Handles server-side processing for viewing escrow meta data in DataTable.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\DataTable;

use Escrowtics\Api\DataTable\SSP;

defined('ABSPATH') || exit;


class ViewEscrowDataTable {

    /**
     * Fetches escrow meta data for DataTable.
     *
     * Handles data retrieval, formatting, and response for DataTable.
     * @return void Outputs JSON response for DataTable.
     */
    public static function viewEscrowTableData() {
        global $wpdb;

        // Table primary key
        $primaryKey = 'meta_id';

        // Table name
        $table = $wpdb->prefix . "escrowtics_escrow_meta";

        // Columns to retrieve and send back to DataTable
        $columns = [
            [
                'db' => 'meta_id',
                'dt' => 0,
                'formatter' => function ($d, $row) {
                    return [
                        'check_box' => '<input type="checkbox" class="escrot-checkbox" data-escrot-row-id="' . esc_attr($d) . '">',
                        'row_id' => esc_attr($d),
                    ];
                },
            ],
            [
                'db' => 'meta_id',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    static $rowIndex = 0;
                    return ++$rowIndex;
                },
            ],
            [	
				'db' => 'amount', 
				'dt' => 2,
				 'formatter' => function ($d, $row) {
                    return $d . ' (' . $row['payable_amount'] . ')';
                },
			],
            ['db' => 'title', 'dt' => 3],
            [
                'db' => 'status',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    $btn_color = ($d === "Pending" ? 'warning' : ($d === "Paid" ? 'success' : 'danger'));
                    return "<button class='btn escrot-btn-sm btn-$btn_color'> $d </button>";
                },
            ],
            [
                'db' => 'creation_date',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return date_i18n('jS M Y', strtotime($d));
                },
            ],
            [
                'db' => 'meta_id',
                'dt' => 6,
                'formatter' => function ($d, $row) {
                    return [
                        'actions' => self::viewEscrowTableActions($d, $row['status']),
                    ];
                },
            ],
			//helper data
			['db' => 'payable_amount', 'dt' => 7],
        ];

        
		$where = "1=1";
		// Filter user data - admin
        if (isset($_POST['extraData'][0]['escrow_id'])) {
			$escrow_id = sanitize_text_field($_POST['extraData'][0]['escrow_id']);
			$where = $wpdb->prepare("escrow_id = %d", $escrow_id);
        } 

        // Use the SSP class with the WHERE clause
        $response = SSP::complex($_POST, $table, $primaryKey, $columns, $where);
		 
		// Send JSON response
        wp_send_json($response);
    }

    /**
     * Generates action buttons for an escrow meta row.
     *
     * @param int    $meta_id The meta ID.
     * @param string $status  The status of the escrow meta.
     * @return string HTML string for the action buttons.
     */
    public static function viewEscrowTableActions($meta_id, $status) {
		 $output = "";
        $output .= "<td><center>
                <a href='#' id='escrotDropdownOrders' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <button class='btn btn-flat escrot-btn-sm escrot-btn-primary'>
                        <i class='fas fa-ellipsis-vertical'></i>
                    </button>
                </a>
                <div class='dropdown-menu dropdown-menu-right' aria-labelledby='escrotDropdownOrders'>
                    <a href='#' id='" . esc_attr($meta_id) . "' class='dropdown-item escrot-rounded escrot-view-milestone-detail'";
						if (ESCROT_INTERACTION_MODE !== "modal") {
							$output .= " data-toggle='collapse' data-target='#escrot-view-milestone-dialog'";
						}
						$output .= ">
							<i class='text-info fas fa-eye'></i> &nbsp; " . esc_html__('View Details', 'escrowtics') . "
					</a>";

					if ($status === "Pending") {
						$output .= "
								<a href='#' title='" . esc_attr__('Release Payment', 'escrowtics') . "' id='" . esc_attr($meta_id) . "' class='dropdown-item escrot-rounded escrot-release-pay'>
									<i class='text-success fas fa-coins'></i> &nbsp; " . esc_html__('Release Payment', 'escrowtics') . "
								</a>
								<a href='#' title='" . esc_attr__('Reject Amount', 'escrowtics') . "' id='" . esc_attr($meta_id) . "' class='dropdown-item escrot-rounded escrot-reject-amount'>
									<i class='text-danger fas fa-coins'></i> &nbsp; " . esc_html__('Reject Amount', 'escrowtics') . "
								</a>";
					} 	
					if (!escrot_is_front_user()) {
						$output .= "
							<a href='#' id='" . esc_attr($meta_id) . "' class='dropdown-item escrot-rounded escrot-delete-btn' data-action='escrot_del_escrow_meta'>
								<i class='text-danger fas fa-trash'></i> &nbsp; " . esc_html__('Delete', 'escrowtics') . "
							</a>";
					}
			

        $output .= "</div></center></td>";
        return $output;
    }
}
