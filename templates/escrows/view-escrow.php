<?php

/**
 * Template for Escrow Milestones
 * Displays escrow milestones for a particular escrow.
 * 
 * @Since    1.0.0
 * @package  Escrowtics
 */

use Escrowtics\Database\EscrowDBManager;

defined('ABSPATH') || exit;

if (!isset($_GET['escrow_id']) || empty($_GET['escrow_id'])) {
    exit();
}

$escrow_id = sanitize_text_field($_GET['escrow_id']);

$escrow = new EscrowDBManager();

// Fetch required data
$data = $escrow->getEscrowById($escrow_id);

$meta_data = $escrow->fetchEscrowMetaById($escrow_id);
$escrow_meta_count = $escrow->getEscrowMetaCount($escrow_id);
$escrow_count = $escrow->escrowExists($escrow_id);

// Define dialogs
$dialogs = [
    [
        'id'       => 'escrot-milestone-form-dialog',
        'data_id'  => '',
        'header'   => '',
        'title'    => __("Add Milestone", "escrowtics"),
        'callback' => 'add-milestone-form.php',
        'type'     => 'add-form'
    ],
    [
        'id'       => 'escrot-view-milestone-dialog',
        'data_id'  => 'escrot-milestone-details',
        'header'   => '',
        'title'    => __("Escrow Milestone Details", "escrowtics"),
        'callback' => '',
        'type'     => 'data'
    ],
    [
        'id'       => 'escrot-add-dispute-form-dialog',
        'data_id'  => '',
        'header'   => '',
        'title'    => __("Add Dispute", "escrowtics"),
        'callback' => 'add-dispute-form.php',
        'type'     => 'add-form'
    ]
];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4" data-escrow-id="<?= esc_attr($escrow_id); ?>" id="escrot-admin-area-title">

    <!-- Create Milestone Button -->
    <button type="button" class="btn btn-icon-text shadow-lg escrot-btn-white addEscrow"
        <?php if (ESCROT_INTERACTION_MODE === "modal") { ?>
            data-toggle="modal" data-target="#escrot-milestone-form-modal"
        <?php } else { ?>
            data-toggle="collapse" data-target="#escrot-milestone-form-dialog"
        <?php } ?>>
        <i class="fas fa-plus"></i> <?= __("Create Milestone", "escrowtics"); ?>
    </button>

    <!-- Header for Desktop -->
    <div class="card-header d-none d-md-block text-center">
        <h4>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header">
                <?php 
                echo sprintf(
                    __("Escrow History For %s & %s (Ref#: %s)", "escrowtics"), 
                    esc_html($data["payer"]), 
                    esc_html($data["earner"]), 
                    esc_html($data['ref_id'])
                ); 
                ?>
            </span>
        </h4>
    </div>

    <!-- Export Button -->
    <button id="escrot-export-to-excel" data-action="escrot_export_escrow_meta_excel" class="btn m-1 float-right shadow-lg escrot-btn-white">
        <i class="fa fa-download"></i> <?= __("Export Excel", "escrowtics"); ?>
    </button>

    <!-- Header for Mobile -->
    <div class="card-header d-block d-md-none text-center">
        <h3>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("Escrows", "escrowtics"); ?></span>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="<?= __("Reload Table", "escrowtics"); ?>" id="reloadTable">
                <i class="fas fa-sync-alt"></i>
            </button>
        </h3>
    </div>

</div>

<?php escrot_callapsable_dialogs($dialogs); // Render collapsible dialogs ?>

<div class="card mb-3 p-5">
    <div class="card-body">
        <div class="table-responsive" id="escrot-view-escrow-table-wrapper">
            <?php include ESCROT_PLUGIN_PATH . "templates/escrows/view-escrow-table.php"; ?>
        </div>
    </div>
</div>
