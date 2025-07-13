<?php
/**
 * Disputes DataTable Class
 * Handles the server-side processing and rendering of the DataTable for dispute data.
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

namespace Escrowtics\Api\DataTable;

use Escrowtics\Api\DataTable\SSP;

defined('ABSPATH') || exit;


class DisputeDataTable {
    /**
     * Fetches dispute data for DataTable.
     *
     * Handles server-side processing of dispute data and formats it for DataTable.
     * @return void Outputs JSON response for DataTable.
     */
    public static function disputeTableData() {
        global $wpdb;

        // Table primary key
        $primaryKey = 'dispute_id';

        // Table name
        $table = $wpdb->prefix . "escrowtics_disputes";

        // Columns to retrieve and send back to DataTables
        $columns = [
            [
                'db' => 'dispute_id',
                'dt' => 0,
                'formatter' => function ($d, $row) {
                    return [
                        'check_box' => '<input type="checkbox" class="escrot-checkbox" data-escrot-row-id="' . esc_attr($d) . '">',
                        'row_id' => esc_attr($d),
                    ];
                },
            ],
            [
                'db' => 'accused_role',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    static $rowIndex = 0; // Static variable to maintain row index
                    return ++$rowIndex; // Increment and return index
                },
            ],
            ['db' => 'ref_id', 'dt' => 2],
			[
                'db' => escrot_is_front_user()? 'accused' : 'complainant',
                'dt' => 3,
                'formatter' => function ($d, $row) {
					if(escrot_is_front_user()) {
						return isset($_GET['endpoint']) && $_GET['endpoint'] === "my_disputes"? $row['complainant'] : $d; //
					} else {
						return ucwords($d) . " vs " . ucwords($row['accused']) . " (".$row['accused_role'].")";//dispute parties admin
					}
                },
            ],
			['db' => 'reason', 'dt' => 4],
            [
                'db' => 'priority',
                'dt' => 5,
                'formatter' => function ($d, $row) {
					 if ($row['status'] == 0) {
						$bg = ($d === "High") ? 'danger' :
							  (($d === "Medium") ? 'warning' : 'success');
					} else {
						$bg = 'gray';
					}
                    return "<span class='pt-1 pb-1 pr-4 pl-4 text-light bg-" . $bg . "'>" . $d . "</span>";
                },
            ],
            [
                'db' => 'status',
                'dt' => 6,
                'formatter' => function ($d, $row) {
					$status = $d == 0 ? 'Open' : 'Resolved'; 
					$toggle = ESCROT_INTERACTION_MODE == "modal"? 'modal' : 'collapse';
				    $target = ESCROT_INTERACTION_MODE == "modal"? 'escrot-dispute-status-modal' : 'escrot-dispute-status-dialog';
					$edit_btn = "<a href='#' class='escrot-back-only text-success escrot-update-dispute-status' title='".__('Edit    
					              Status', 'escrowtics')."' id='". $row['dispute_id']."' data-toggle='".$toggle."' data-target='#".$target."'> <i class='fas fa-pen'></i>
								</a>";
                    return $status.$edit_btn;
                },
            ],
            [
                'db' => 'last_updated',
                'dt' => 7,
                'formatter' => function ($d, $row) {
                    return date_i18n('jS M Y', strtotime($d));
                },
            ],
            [
                'db' => 'dispute_id',
                'dt' => 8,
                'formatter' => function ($d, $row) {
                    return  self::disputeTableAction($d);
				},	
            ],
			['db' => 'complainant', 'dt' => 9],
			['db' => 'accused','dt' => 10],
        ];

        
        // Filtering logic
        $where = "1=1"; // Default condition

         // Filter user data for front-end users
        if (escrot_is_front_user()) {
			$user = wp_get_current_user();
            $username = $user->user_login;
			
			if(isset($_GET['endpoint']) && $_GET['endpoint'] === "my_disputes"){
				$where = $wpdb->prepare("complainant = %s", sanitize_text_field($username));
			} 
			if(isset($_GET['endpoint']) && $_GET['endpoint'] === "disputes_against_me"){
				$where = $wpdb->prepare("accused = %s", sanitize_text_field($username));
			}
        } 

        // Use the SSP class with the WHERE clause
        $response = SSP::complex($_POST, $table, $primaryKey, $columns, $where);

        // Send JSON response
        wp_send_json($response);
    }

    /**
     * Generates action buttons for a dispute row.
     *
     * @param int $dispute_id The dispute ID.
     * @return string HTML string for the action buttons.
     */
    public static function disputeTableAction($dispute_id) {
		
		
        ob_start();
        ?>
		<center>
			<?php if (escrot_is_front_user()) : ?>
			    <?php 
				$dispute_url = isset($_POST['extraData'][0]['dispute_url']) ? esc_url($_POST['extraData'][0]['dispute_url']) : '';
				$dispute_url = !empty($dispute_url)? add_query_arg(['dispute_id' => $dispute_id], $dispute_url) : '#';
				?>
				<a href="<?= $dispute_url; ?>" class="btn  escrot-btn-secondary btn-icon-text escrot-btn-sm"> 
					<i class='fas fa-eye'></i> &nbsp;<?= __('View', 'escrowtics'); ?>
				</a>
			<?php else : ?>
				<a href="admin.php?page=escrowtics-view-dispute&dispute_id=<?= $dispute_id; ?>" class="btn escrot-btn-behance btn-icon-text escrot-btn-sm" title="<?= __('View Dispute', 'escrowtics'); ?>" >
					<i class="fas fa-eye"></i> &nbsp; <?=__('View', 'escrowtics'); ?>
				</a>
				<a href='#' id="<?= $dispute_id; ?>" class='btn btn-danger btn-icon-text escrot-btn-sm escrot-delete-dispute-btn' 
				title='Delete Dispute'> <i class='fas fa-trash'></i>
				</a>
		    <?php endif; ?>
	    </center>
        <?php  return ob_get_clean();
    }
	

    


}
