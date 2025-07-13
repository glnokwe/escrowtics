<?php 
/**
 * Admin Template for Disputes
 * Display all user disputes
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */

defined('ABSPATH') || exit; 


// Define dialogs
$dialogs = [
    [
        'id' => 'escrot-add-dispute-form-dialog',
        'data_id' => '',
        'header' => '',
        'title' => __("Add Dispute", "escrowtics"),
        'callback' => 'add-dispute-form.php',
        'type' => 'add-form'
    ],
    [
        'id' => 'escrot-dispute-status-dialog',
        'data_id' => '',
        'header' => '',
        'title' => __("Update Dispute Status", "escrowtics"),
        'callback' => 'update-dispute-status-form.php',
        'type' => ''
    ]
];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4" id="escrot-admin-area-title">
    <!-- Button to open the modal or collapse form to add a dispute -->
    <button type="button" class="btn btn-icon-text shadow-lg escrot-btn-white"
    <?php if (defined('ESCROT_INTERACTION_MODE') && ESCROT_INTERACTION_MODE === 'modal') { ?>
        data-toggle="modal" data-target="#escrot-add-dispute-modal"
    <?php } else { ?>
        data-toggle="collapse" data-target="#escrot-add-dispute-form-dialog"
    <?php } ?>>
        <i class="fas fa-plus"></i> <?= __("Add Dispute", "escrowtics"); ?>
    </button>

    <!-- Header section for pc -->
    <div class="card-header d-none d-md-block" style="text-align:center;">
        <h3>
            <i class="fas fa-people-arrows tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("Disputes", "escrowtics"); ?></span>&nbsp;
            <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="Reload Table" id="reloadTable">
                <i class="fas fa-sync-alt"></i>
            </button>
        </h3>
    </div>

    <!-- Export button to export disputes data as Excel -->
    <button id="escrot-export-to-excel" data-action="escrot_export_disputes_excel" class="btn m-1 float-right shadow-lg escrot-btn-white">
        <i class="fa fa-download"></i> <?= __("Export Excel", "escrowtics"); ?>
    </button>

    <!-- Mobile Header -->
    <div class="card-header d-block d-md-none" style="text-align:center;">
        <h3>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("Disputes", "escrowtics"); ?></span>&nbsp;&nbsp;
            <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;" title="Reload Table" id="reloadTable">
                <i class="fas fa-sync-alt"></i>
            </button>
        </h3>
    </div>
</div>

<?php escrot_callapsable_dialogs($dialogs); // Render collapsible dialogs ?>

<div class="card mb-3 p-5">
    <div class="card-body">
       
        <div class="table-responsive" id="escrot-dispute-table-wrapper">
            <?php
            // Include the disputes table template
            include ESCROT_PLUGIN_PATH . "templates/disputes/disputes-table.php";
            ?>
        </div>
    </div>
</div>
