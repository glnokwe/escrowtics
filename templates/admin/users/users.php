<?php

/**
 * Admin Template for Escrow Users
 * Display all frontend users
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */

defined('ABSPATH') || exit;


// Define dialogs for user management
$dialogs = [
    [
        'id' => 'escrot-add-user-form-dialog',
        'data_id' => '',
        'header' => '',
        'title' => __("Add User", "escrowtics"),
        'callback' => 'add-user-form.php',
        'type' => 'add-form'
    ],
    [
        'id' => 'escrot-edit-user-form-dialog',
        'data_id' => '',
        'header' => '',
        'title' => __("Edit User Account", "escrowtics") . ' [<span class="small" id="CrtEditUserID"></span>]',
        'callback' => 'edit-user-form.php',
        'type' => 'edit-form'
    ]
];


?>

<div class="d-sm-flex align-items-center justify-content-between mb-4" id="escrot-admin-area-title">

    <!-- Add User Button -->
    <button type="button" class="btn btn-icon-text shadow-lg escrot-btn-white" 
        <?php if (ESCROT_INTERACTION_MODE == "modal") { ?>
            data-toggle="modal" data-target="#escrot-add-user-modal" 
        <?php } else { ?>
            data-toggle="collapse" data-target="#escrot-add-user-form-dialog" 
        <?php } ?>>
        <i class="fas fa-plus"></i> <?= __("Add User", "escrowtics"); ?>
    </button>

    <!-- Desktop Header -->
    <div class="card-header d-none d-md-block">
        <h3>
            <i class="fas fa-user-group tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("Users", "escrowtics"); ?></span>
        </h3>
    </div>

    <!-- Export Button -->
    <button id="escrot-export-to-excel" data-action="escrot_export_user_excel" class="btn m-1 float-right shadow-lg escrot-btn-white">
        <i class="fa fa-download"></i> <?= __("Export To Excel", "escrowtics"); ?>
    </button>

    <!-- Mobile Header -->
    <div class="card-header d-block d-md-none text-center">
        <h3>
            <i class="fas fa-user-group tbl-icon"></i>
            <span class="escrot-tbl-header"><?= __("Users", "escrowtics"); ?></span>
        </h3>
    </div>

</div>

<?php escrot_callapsable_dialogs($dialogs); // Render collapsible dialogs ?>

<div class="card mb-3 p-5">
    <div class="card-body">
        <!-- User Table -->
        <div id="escrot-user-table-wrapper">
            <?php include_once ESCROT_PLUGIN_PATH . "templates/admin/users/users-table.php"; ?>
        </div>
    </div>
</div>
