<?php


defined('ABSPATH') || exit;

$dispute_url = $routes['view_dispute'];

$title = $action=="my_disputes"? __('My Disputes', 'escrowtics') : __('Disputes Against Me', 'escrowtics');

$before_tbl = '';

$before_tbl .= '
    <div class="escrot-content">    
        <div>
            <center>
                <h3 class="text-dark text-center">
                    ' . $title . '
                    <a type="button" class="btn btn-sm btn-outline-secondary btn-round float-right" ';

						if (defined('ESCROT_INTERACTION_MODE') && ESCROT_INTERACTION_MODE === 'modal') {
							$before_tbl .= 'data-toggle="modal" data-target="#escrot-add-dispute-modal"';
						} else {
							$before_tbl .= 'data-toggle="collapse" data-target="#escrot-add-dispute-form-dialog"';
						}

						$before_tbl .= '> <i class="fas fa-plus"></i> ' . esc_html__('Open New Dispute', 'escrowtics') . '
                    </a>
                </h3>
            </center>
        </div>
        <br>
        <div class="card shadow-lg p-3">
            <div class="table-responsive escrot-sa-users-tbl" id="escrot-dispute-table-wrapper">';

				// Echo the formatted HTML table prefix header.
				echo wp_kses_post($before_tbl);

				// Include the disputes table.
				include ESCROT_PLUGIN_PATH . 'templates/disputes/disputes-table.php';
     echo '</div>
    </div>
</div>';
