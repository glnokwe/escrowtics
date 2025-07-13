<?php
/**
 * Renders admin modals for the plugin dynamically.
 *
 * @package    Escrowtics
 * @since      1.0.0
 */

defined('ABSPATH') || exit;

// Define an array of modals with their configurations.
$modals = [
    [
        "id"                => "escrot-db-restore-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "escrot-modal-sm",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "sync",
        "title"             => __("Database Restore", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "db-restore-form.php",
    ],
    [
        "id"                => "escrot-sett-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "sett-modal",
        "modal-content-class" => "setContent",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "sliders",
        "title"             => __("Escrowtics Settings Panel", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "settings-form.php",
    ],
    [
        "id"                => "escrot-options-import-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "escrot-modal-sm",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "upload",
        "title"             => __("Import Options", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "options-import-form.php",
    ],
    [
        "id"                => "escrot-add-user-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Add User", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "add-user-form.php",
    ],
    [
        "id"                => "escrot-edit-user-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Edit User", "escrowtics") . ' [<span class="small" id="CrtEditUserID"></span>]',
        "modal-body-id"     => "",
        "callback"          => "edit-user-form.php",
    ],
    [
        "id"                => "escrot-add-escrow-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Add Escrow", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "add-escrow-form.php",
    ],
    [
        "id"                => "escrot-milestone-form-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Add Escrow Milestone", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "add-milestone-form.php",
    ],
    [
        "id"                => "escrot-add-dispute-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Add Dispute", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "add-dispute-form.php",
    ],
    [
        "id"                => "escrot-escrow-search-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Escrow Search Results", "escrowtics"),
        "modal-body-id"     => "escrot-escrow-search-results-modal-body",
        "callback"          => "",
    ],
    [
        "id"                => "escrot-view-milestone-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "escrot-modal-sm",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Escrow Milestone Details", "escrowtics"),
        "modal-body-id"     => "escrot-view-milestone-modal-body",
        "callback"          => "",
    ],
    [
        "id"                => "escrot-invoice-status-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "escrot-modal-sm",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Update Invoice Status", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "update-invoice-status-form.php",
    ],
	[
        "id"                => "escrot-view-invoice-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Transaction Invoice", "escrowtics"),
        "modal-body-id"     => "escrot-view-invoice-modal-body",
        "callback"          => "",
    ],
    [
        "id"                => "escrot-dispute-status-modal",
        "modal-static"      => false,
        "modal-dialog-class" => "",
        "modal-content-class" => "escrot-modal-sm",
        "header-status"     => false,
        "header"            => "",
        "modal-title-class" => "",
        "type"              => "",
        "icon"              => "",
        "title"             => __("Update Dispute Status", "escrowtics"),
        "modal-body-id"     => "",
        "callback"          => "update-dispute-status-form.php",
    ],
];

// Loop through each modal configuration and render the HTML dynamically.
foreach ($modals as $modal) { ?>
    <div class="modal fade"
        <?= $modal["modal-static"] ? 'data-backdrop="static"' : 'style="z-index: 1045;"'; ?>
        id="<?= esc_attr($modal["id"]); ?>">

        <div class="modal-dialog <?= esc_attr($modal["modal-dialog-class"]); ?>">
            <div class="modal-content <?= esc_attr($modal["modal-content-class"]); ?>">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title text-dark <?= esc_attr($modal["modal-title-class"]); ?>">
                        <?php
                        if ($modal["header-status"]) {
                            // Include the header template if header-status is true.
                            include_once ESCROT_PLUGIN_PATH . "templates/admin/template-parts/" . esc_attr($modal["header"]);
                        } else { ?>
                            <i class="fa fa-<?= esc_attr($modal["icon"]); ?> sett-icon"></i>
                            &nbsp;<?= $modal["title"]; ?>
                        <?php } ?>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'escrowtics'); ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" id="<?= esc_attr($modal["modal-body-id"]); ?>">
                    <?php
                    // Include the callback template if defined.
                    if (!empty($modal["callback"])) {
                        include_once ESCROT_PLUGIN_PATH . "templates/forms/" . esc_attr($modal["callback"]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
