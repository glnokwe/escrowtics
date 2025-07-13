<?php

/**
 * Admin Template for Settings Panel
 * Display admin settings page.
 * 
 * @Since   1.0.0 
 * @package Escrowtics
 */

defined('ABSPATH') || exit;

// Define dialogs
$dialogs = [
    [
        'id' => 'DisplayOptionsImportForm',
        'data_id' => '',
        'header' => '',
        'title' => __('Import Options', 'escrowtics'),
        'callback' => 'options-import-form.php',
        'type' => 'restore-form',
    ],
    [
        'id' => 'escrot-db-restore-form-dialog',
        'data_id' => '',
        'header' => '',
        'title' => __('Restore Database Backup', 'escrowtics'),
        'callback' => 'db-restore-form.php',
        'type' => 'restore-form',
    ],
    [
        'id' => 'escrot-search-results-dialog',
        'data_id' => 'escrot-escrow-search-results-dialog-wrap',
        'header' => '',
        'title' => __('Escrow Search Results', 'escrowtics'),
        'callback' => '',
        'type' => 'data',
    ],
];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <!-- Import Settings Button -->
    <button id="impSett" type="button" class="escrot-btn-sm pr-4 pl-4 pt-3 pb-3 btn btn-icon-text shadow-lg escrot-btn-white"
        <?php if (ESCROT_INTERACTION_MODE === "modal") { ?>
            data-toggle="modal" data-target="#doptions-import"
        <?php } else { ?>
            data-toggle="collapse" data-target="#DisplayOptionsImportForm"
        <?php } ?>>
        <i class="fas fa-upload"></i> <?= esc_html__("Import Settings", "escrowtics"); ?>
    </button>

    <!-- Desktop Header -->
    <div class="card-header d-none d-md-block" style="text-align:center;">
        <h3>
            <i class="fa fa-screwdriver-wrench tbl-icon"></i>
            <span class="escrot-tbl-header"><?= esc_html__("Escrowtics Settings", "escrowtics"); ?></span>
        </h3>
    </div>

    <!-- Export Settings Button -->
    <button id="escrot-export-settings" class="escrot-btn-sm pr-4 pl-4 pt-3 pb-3 btn m-1 float-right shadow-lg escrot-btn-white">
        <i class="fa fa-download"></i> <?= esc_html__("Export Settings", "escrowtics"); ?>
    </button>

    <!-- Mobile Header -->
    <div class="card-header d-block d-md-none" style="text-align:center;">
        <h3>
            <i class="fas fa-filter-circle-dollar tbl-icon"></i>
            <span class="escrot-tbl-header"><?= esc_html__("Settings", "escrowtics"); ?></span>
        </h3>
    </div>
</div>

<?php escrot_callapsable_dialogs($dialogs); // Render collapsible dialogs ?>

<!-- Settings Form -->
<div class="card mb-3 p-5 escrot-admin-forms">
    <div class="card-body" style="padding:30px 7%;">
        <?php include_once ESCROT_PLUGIN_PATH . "templates/forms/settings-form.php"; ?>
    </div>
</div>
