<?php

/**
 * Admin area template for the plugin.
 *
 * @since 1.0.0
 * @package    Escrowtics
 */

defined('ABSPATH') || exit;

// Include required template parts.
include_once ESCROT_PLUGIN_PATH . 'templates/admin/template-parts/header.php'; // Header
include_once ESCROT_PLUGIN_PATH . 'templates/admin/template-parts/sidebar.php'; // Sidebar

?>

<div class="main-panel escrot-main-panel">

    <?php 
    
    include_once ESCROT_PLUGIN_PATH . 'templates/admin/template-parts/navbar.php'; // Navbar

    if ( escrot_option('admin_nav_style') === 'no-menu' ) {
        echo '<div class="mt-5"></div>';// add top margin if no menu option is on
    }

    if ( escrot_option('admin_nav_style') === 'top-menu' && ! wp_is_mobile() ) {
        include_once ESCROT_PLUGIN_PATH . 'templates/admin/template-parts/top-nav-menu.php';
    }
    ?>

    <div class="content">
        <?= escrot_ajax_loader(); // AJAX loader ?>

         <div class="container-fluid">
            <?php
            // Plugin-wide dialogs
            $dialogs = [
                [
                    'id' => 'escrot-db-restore-form-dialog',
                    'data_id' => '',
                    'header' => '',
                    'title' => esc_html__("Restore Database Backup", "escrowtics"),
                    'callback' => 'db-restore-form.php',
                    'type' => 'restore-form'
                ],
                [
                    'id' => 'escrot-search-results-dialog',
                    'data_id' => 'escrot-escrow-search-results-dialog-wrap',
                    'header' => '',
                    'title' => esc_html__("Escrow Search Results", "escrowtics"),
                    'callback' => '',
                    'type' => 'data'
                ]
            ];
            escrot_callapsable_dialogs($dialogs);

            // Main content switch based on current page
            $current_page = sanitize_text_field($_GET['page'] ?? '');
            $content_map = [
                'escrowtics-dashboard' => 'templates/admin/dashboard/dashboard.php',
                'escrowtics-view-escrow' => 'templates/escrows/view-escrow.php',
                'escrowtics-view-dispute' => 'templates/disputes/view-dispute.php',
                'escrowtics-stats' => 'templates/admin/stats/stats.php',
                'escrowtics-settings' => 'templates/admin/template-parts/settings-panel.php',
            ];

            if (isset($content_map[$current_page])) {
                include_once ESCROT_PLUGIN_PATH . $content_map[$current_page];
            } elseif (isset($_GET['user_id'])) {
                echo '<div id="escrot-profile-container">' . escrot_loader(esc_html__('Loading..', 'escrowtics')) . '</div>';
            } else {
                echo '<div id="escrot-admin-container">' . escrot_loader(esc_html__('Loading..', 'escrowtics')) . '</div>';
            }
            ?>
        </div>
    </div>

    <?php 
    // Include footer and modals if required.
    include_once ESCROT_PLUGIN_PATH . 'templates/admin/template-parts/footer.php';
	
    if ( ESCROT_INTERACTION_MODE === 'modal' ) {
        include_once ESCROT_PLUGIN_PATH . 'templates/admin/template-parts/modals.php';
    }
    if ( isset( $IsStatsPage ) && $IsStatsPage ) {
        include_once ESCROT_PLUGIN_PATH . 'templates/admin/stats/charts.php';
    }
    ?>

</div>

</div><!-- End of bodyWrapper, opening tag in header -->


