<?php

/**
 * Admin Template for User Deposits
 * Display all user deposits
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */

defined('ABSPATH') || exit;

// Define dialogs
$dialogs = [
    [
        'id'       => 'escrot-invoice-status-dialog',
        'data_id'  => '',
        'header'   => '',
        'title'    => __("Update Deposit Invoice", "escrowtics"),
        'callback' => 'update-invoice-status-form.php',
        'type'     => ''
    ],
    [
        'id'       => 'escrot-view-invoice-dialog',
        'data_id'  => 'escrot-invoice-wrapper',
        'header'   => '',
        'title'    => __("Deposit Invoice", "escrowtics"),
        'callback' => '',
        'type'     => 'data'
    ]
];

// Render collapsible dialogs
escrot_callapsable_dialogs($dialogs);

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4" id="escrot-admin-area-title">

    <!-- Back Home Button -->
    <a class="btn btn-icon-text shadow-lg escrot-btn-white" href="admin.php?page=escrowtics-dashboard">
        <i class="fas fa-arrow-left"></i> <?= __("Back Home", "escrowtics"); ?>
    </a>

    <!-- Desktop Header -->
    <div class="card-header d-none d-md-block text-center">
        <h3>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("User Deposits", "escrowtics"); ?></span>
        </h3>
    </div>

    <!-- Export Button -->
    <button id="escrot-export-to-excel" data-action="escrot_export_deposits_excel" class="btn m-1 float-right shadow-lg escrot-btn-white">
        <i class="fa fa-download"></i> <?= __("Export Excel", "escrowtics"); ?>
    </button>

    <!-- Mobile Header -->
    <div class="card-header d-block d-md-none text-center">
        <h3>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("User Deposits", "escrowtics"); ?></span>
            &nbsp;
            <button type="button" class="btn btn-round btn-just-icon" style="background-color:transparent; box-shadow: none;"
                title="<?= esc_attr(__("Reload Table", "escrowtics")); ?>" id="reloadTable">
                <i class="fas fa-sync-alt"></i>
            </button>
        </h3>
    </div>

</div>

<div class="card mb-3 p-5">
    <div class="card-body">
        <div class="table-responsive" id="escrot-deposits-table-wrapper">
            <?php
            // Define variables for the included template
            $invoice_url = '';
            $invoice_type = 'deposit';

            // Include the invoices table template
            include ESCROT_PLUGIN_PATH . "templates/escrows/invoices-table.php";
            ?>
        </div>
    </div>
</div>
