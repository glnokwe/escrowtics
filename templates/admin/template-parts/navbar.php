<?php
/**
 * Admin Top Address bar
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */
 
 defined('ABSPATH') || exit;
?>
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <?php if (escrot_option('admin_nav_style') === 'sidebar') : ?>
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-just-icon bg-transparent btn-fab btn-round" title="<?php esc_attr_e('Toggle Menu', 'escrot'); ?>">
                        <i class="text-light fa fa-maximize escrot-nav-icon text_align-center visible-on-sidebar-regular"></i>
                        <i class="text-light fa fa-minimize escrot-nav-icon design_bullet-list-67 visible-on-sidebar-mini"></i>
                    </button>
                </div>
            <?php else : ?>
                <div class="p-2 pl-3 pr-3 mr-5 border rounded-pill border-primary d-none d-md-block">
                    <?php include ESCROT_PLUGIN_PATH."templates/admin/template-parts/escrot-admin-logo.php"; ?>
                </div>
            <?php endif; ?>

            <?php  include ESCROT_PLUGIN_PATH."templates/admin/template-parts/navbar-breadcrumps.php"; ?>

            <!-- Mobile Top Header -->
            <div class="justify-content-end mobile-top d-block d-lg-none">
                <a href="#" class="toggle-theme" title="<?php esc_attr_e('Toggle Light/Dark Mode', 'escrot'); ?>" id="<?= escrot_option('theme_class') === 'dark-edition' ? 'ToggleLightModeMbl' : 'ToggleDarkModeMbl'; ?>">
                    <?= escrot_option('theme_class') === 'dark-edition' ? escrot_light_svg() : '<i class="fa fa-moon escrot-nav-icon text-light fixed-plugin-button-nav"></i>'; ?>
                </a>
                <div class="escrot-view-notif">
                    <a class="notify-mobile" href="#" id="ShowMnoty" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="text-light fa fa-bell escrot-nav-icon"></i>
                        <span class="notification" style="background: transparent; border: none !important;"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left notif-content" aria-labelledby="ShowMnoty"></div>
                </div>
            </div>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'escrot'); ?>">
            <span class="navbar-toggler-icon icon-bar text-light"></span>
            <span class="navbar-toggler-icon icon-bar text-light"></span>
            <span class="navbar-toggler-icon icon-bar text-light"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <?php include ESCROT_PLUGIN_PATH . 'templates/forms/escrow-search-form.php'; ?>
            </div>

            <ul class="navbar-nav">
                <!-- Toggle Light/Dark Mode -->
                <li class="nav-item ps-3 d-flex align-items-center">
                    <a href="#" title="<?php esc_attr_e('Toggle Light/Dark Mode', 'escrot'); ?>" class="nav-link text-body p-0" id="<?= escrot_option('theme_class') === 'dark-edition' ? 'ToggleLightMode' : 'ToggleDarkMode'; ?>">
                        <?= escrot_option('theme_class') === 'dark-edition' ? '<span class="text-light">'.escrot_light_svg().'</span>' : '<i class="fa fa-moon escrot-nav-icon text-light fixed-plugin-button-nav"></i>'; ?>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-item px-3">
                    <a href="<?= ESCROT_INTERACTION_MODE === 'modal' ? 'javascript:;' : esc_url(admin_url('admin.php?page=escrowtics-settings')); ?>" class="nav-link text-body p-0" data-toggle="<?= ESCROT_INTERACTION_MODE === 'modal' ? 'modal' : ''; ?>" data-target="<?= ESCROT_INTERACTION_MODE === 'modal' ? '#escrot-sett-modal' : ''; ?>">
                        <i class="text-light fa fa-screwdriver-wrench escrot-nav-icon"></i>
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item px-3 dropdown escrot-view-notif">
                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="text-light fa fa-bell escrot-nav-icon"></i>
                        <span class="escrot-notification notification" style="background: transparent; border: none !important;"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right notif-content" aria-labelledby="navbarDropdownMenuLink"></div>
                </li>
				<?php $current_user_id = get_current_user_id(); ?>
				<li class="nav-item px-3 dropdown">
				  <a class="nav-link dropdown-toggle" href="#" id="navbarUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="text-light fa fa-user fnehd-nav-icon"></i>
				  </a>
				  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUserMenu">
				    <?php if( escrot_is_front_user() ): ?>
						<a class="dropdown-item" 
						   href="<?php echo esc_url( admin_url( 'admin.php?page=escrowtics-user-profile&user_id=' . $current_user_id ) ); ?>">
						  <i class="fa-regular fa-user"></i> &nbsp; <?php esc_html_e( 'Profile', 'escrowtics' ); ?>
						</a>
					<?php endif; ?>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" 
					   href="<?php echo esc_url( wp_logout_url( admin_url() ) ); ?>">
					  <i class="fa-solid fa-arrow-right-from-bracket"></i> &nbsp; <?php esc_html_e( 'Logout', 'escrowtics' ); ?>
					</a>
				  </div>
				</li>
            </ul>
        </div>
    </div>
</nav>
