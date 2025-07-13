<?php

/**
 * Admin Template for Escrows transactions
 * Displays all escrows
 * 
 * @Since    1.0.0
 * @package  Escrowtics
 */

defined('ABSPATH') || exit;

// Define dialog configurations
$dialogs = [
    [
        'id'       => 'escrot-add-escrow-form-dialog',
        'data_id'  => '',
        'header'   => '',
        'title'    => __("Add Escrow", "escrowtics"),
        'callback' => 'add-escrow-form.php',
        'type'     => 'add-form'
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

<div class="d-sm-flex align-items-center justify-content-between mb-4" id="escrot-admin-area-title">

    <!-- Add Escrow Button -->
    <button type="button" class="btn btn-icon-text shadow-lg escrot-btn-white addEscrow"
        <?php if (defined('ESCROT_INTERACTION_MODE') && ESCROT_INTERACTION_MODE === "modal") { ?>
            data-toggle="modal" data-target="#escrot-add-escrow-modal"
        <?php } else { ?>
            data-toggle="collapse" data-target="#escrot-add-escrow-form-dialog"
        <?php } ?>>
        <i class="fas fa-plus"></i> <?= __("Add Escrow", "escrowtics"); ?>
    </button>

    <!-- Desktop Header -->
    <div class="card-header d-none d-md-block text-center">
        <h3>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("Escrows", "escrowtics"); ?></span>
            <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" 
                title="<?= esc_attr(__("Reload Table", "escrowtics")); ?>" id="reloadTable">
                <i class="text-dark fas fa-rotate-right"></i>
            </button>
        </h3>
    </div>

    <!-- Export Button -->
    <button id="escrot-export-to-excel" data-action="escrot_export_escrows_excel" class="btn m-1 float-right shadow-lg escrot-btn-white">
        <i class="fa fa-download"></i> <?= __("Export Excel", "escrowtics"); ?>
    </button>

    <!-- Mobile Header -->
    <div class="card-header d-block d-md-none text-center">
        <h3>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("Escrows", "escrowtics"); ?></span>
            <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" 
                title="<?= esc_attr(__("Reload Table", "escrowtics")); ?>" id="reloadTable">
                <i class="fas fa-rotate-right"></i>
            </button>
        </h3>
    </div>

</div>

<?php escrot_callapsable_dialogs($dialogs); // Render collapsible dialogs ?>

<div class="card p-5 mb-3">
    <div class="card-body">
        <div class="table-responsive" id="escrot-escrow-table-wrapper">
            <?php include ESCROT_PLUGIN_PATH . "templates/escrows/escrows-table.php"; ?>
        </div>
    </div>
</div>
