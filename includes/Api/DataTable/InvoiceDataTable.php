<?php
/**
 * Payment Invoices DataTable Class
 * Handles the server-side processing and rendering of the DataTable for invoice data.
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

namespace Escrowtics\Api\DataTable;

use Escrowtics\Api\DataTable\SSP;

defined('ABSPATH') || exit;


class InvoiceDataTable {
    /**
     * Fetches invoice data for DataTable.
     *
     * Handles server-side processing of invoice data and formats it for DataTable.
     * @return void Outputs JSON response for DataTable.
     */
    public static function invoiceTableData() {
        global $wpdb;

        // Table primary key
        $primaryKey = 'id';

        // Table name
        $table = $wpdb->prefix . "escrowtics_invoices";

        // Columns to retrieve and send back to DataTables
        $columns = [
            [
                'db' => 'id',
                'dt' => 0,
                'formatter' => function ($d, $row) {
                    return [
                        'check_box' => '<input type="checkbox" class="escrot-checkbox" data-escrot-row-id="' . esc_attr($d) . '">',
                        'row_id' => esc_attr($d),
                    ];
                },
            ],
            [
                'db' => 'id',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    static $rowIndex = 0; // Static variable to maintain row index
                    return ++$rowIndex; // Increment and return index
                },
            ],
            ['db' => 'code', 'dt' => 2],
            [	'db' => 'user_id', 
				'dt' => 3,
				'formatter' => function ($d, $row) {
                    return [
                        'username' => get_user_by('ID', $d)->user_login,
                    ];
                },
			],
			['db' => 'amount', 'dt' => 4], 
            ['db' => 'payment_method', 'dt' => 5],
            [	'db' => 'status', 
				'dt' => 6,
				'formatter' => function ($d, $row) {
					$status = "<span style='color: red'>".__('Expired', 'escrowtics')."</span>";
					if($d == 0 || $d == 1){
						$status = "<span style='color: orangered'>".__('Pending', 'escrowtics')."</span>";
					}elseif($d == 2){
						$status = "<span style='color: green'>".__('Paid', 'escrowtics')."</span>";
					} elseif($d == -1){
						$status = "<span style='color: red'>".__('Unpaid', 'escrowtics')."</span>";
					}elseif($d == -2){
						$status = "<span style='color: red'>".__('Partially Paid', 'escrowtics')."</span>";
					} 
                    return $status;
                },
			],
            [
                'db' => 'creation_date',
                'dt' => 7,
                'formatter' => function ($d, $row) {
                    return date_i18n('jS M Y', strtotime($d));
                },
            ],
            [
                'db' => 'id',
                'dt' => 8,
                'formatter' => function ($d, $row) {
                    return [
                        'actions' => self::invoiceTableAction($row['payment_method'], $d, $row['code'], $row['status']),
                    ];
                },
            ],
        ];
		
		
		// Filtering logic
        $where = "1=1"; 

		// Filte invoice type from POST data
		if (!empty($_POST['extraData'][0]['invoice'])) {
			$invoiceType = $_POST['extraData'][0]['invoice'];
			if (in_array($invoiceType, ['deposit', 'withdrawal'], true)) {
				$product = ($invoiceType === 'deposit') ? 'User Deposit' : 'User Withdrawal';

				// Build the WHERE clause based on the user context
				$where = escrot_is_front_user()
					? $wpdb->prepare("product = %s AND user_id = %d", $product, get_current_user_id())
					: $wpdb->prepare("product = %s", $product);
			}
		}

        // Use the SSP class for server-side processing
        $response = SSP::complex($_POST, $table, $primaryKey, $columns, $where);

        // Send JSON response
        wp_send_json($response);
    }
	
	
	

    /**
     * Generates action buttons for a user row.
     *
     * @param int $id The user ID.
     * @return string HTML string for the action buttons.
     */
    public static function invoiceTableAction($method, $id, $invoice_code, $status) {
		$view_invoice_ajax_action = '';

		if (!empty($_POST['extraData'][0]['invoice'])) {
			$invoiceType = $_POST['extraData'][0]['invoice'];
			$view_invoice_ajax_action = match ($invoiceType) {
				'deposit' => 'escrot_view_deposit_invoice',
				'withdrawal' => 'escrot_view_withdrawal_invoice',
				default => '',
			};
		}
		
        ob_start();
        ?>
        <center>
		    <?php if(escrot_is_front_user()): ?>
			    <?php
				$url = isset($_POST['extraData'][0]['invoice_url'])? $_POST['extraData'][0]['invoice_url'] : '';
				$invoice_url = $method === 'Bitcoin'
											? $url['bitcoin']
											: ( $method === 'Paypal'
												? $url['paypal']
												: $url['manual']
											  );
				$invoice_url = !empty($invoice_url)? add_query_arg(['code' => $invoice_code],  $invoice_url ) : '#';
				?>
				<a title="<?= __('View Payment Invoice', 'escrowtics'); ?>" href="<?= esc_url($invoice_url); ?>" class="btn escrot-btn-secondary btn-icon-text escrot-btn-sm"> 
					<i class="fa-solid fa-file-invoice"></i> &nbsp;<?= __('Invoice', 'escrowtics'); ?>
				</a>
			<?php else : ?>
			   	
				<a href='#' id='escrot-dropdown-invoices' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <button class='btn btn-flat escrot-btn-sm escrot-btn-primary'><i class='fas fa-ellipsis-vertical'></i></button></a>
				
				<div class='dropdown-menu dropdown-menu-right' aria-labelledby='escrot-dropdown-invoices'>
				    <?php if ($status == 2): ?>
						<a title="<?= __('View Invoice', 'escrowtics'); ?>" href="#" class="dropdown-item escrot-rounded escrot-view-invoice-btn"
							<?= ESCROT_INTERACTION_MODE === "modal"? 'data-toggle="modal" data-target="#escrot-view-invoice-modal"' : 'data-toggle="collapse" data-target="#escrot-view-invoice-dialog"'; ?> id="<?= $invoice_code; ?>" 
							data-view-invoice-ajax-action="<?= $view_invoice_ajax_action ?>"
						><i class="text-success fa-solid fa-file-invoice"></i> &nbsp;<?= __('Invoice', 'escrowtics'); ?>
						</a>
				    <?php else: ?>	
						<a href="#" id="<?= $invoice_code ?>" class="dropdown-item escrot-rounded escrot-update-invoice-btn" 
							<?= ESCROT_INTERACTION_MODE === "modal"? 'data-toggle="modal" data-target="#escrot-invoice-status-modal"' : 'data-toggle="collapse" data-target="#escrot-invoice-status-dialog"'; ?> >
							
							<i class='text-info fas fa-edit'></i>  &nbsp;<?= __('Update Status', 'escrowtics'); ?>
						</a>
					<?php endif; ?>	
					<a href="#" id="<?= esc_attr($id); ?>" class="dropdown-item escrot-rounded escrot-delete-btn" data-action="escrot_del_invoice">
						<i class="text-danger fas fa-trash"></i>  &nbsp;<?php esc_html_e('Delete', 'escrowtics'); ?>
					</a>
				</div>
		    <?php endif; ?>
		</center>
        <?php  return ob_get_clean();
    }
	

   
}
