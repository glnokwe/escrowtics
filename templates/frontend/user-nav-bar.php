<?php 

/**
 * Frontend Navbar
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */
 
 defined('ABSPATH') || exit;


// Determine active classes for endpoints
$active_class = [];
foreach ($endpoints as $endpoint) {
    $active_class[$endpoint] = ($escrot_endpoint && isset($_GET['endpoint']) && $_GET['endpoint'] === $endpoint) ? 'active show' : '';
}

/**
 * Generate front menu navigation.
 *
 * @param array $menus Array of menus to render.
 */
function escrot_front_menu_manager($menus) {
    if (empty($menus)) {
        return;
    }

    ob_start(); // Start output buffering

    foreach ($menus as $menu) : ?>
        <li 
            class="nav-item <?= esc_attr($menu['li-classes']); ?> <?= ($menu['type'] === 'drop-down') ? 'dropdown' : ''; ?>" 
            id="<?= esc_attr($menu['li-id']); ?>"
        >
            <a 
                class="nav-link <?= esc_attr($menu['active_classes']); ?> <?= ($menu['type'] === 'drop-down') ? 'dropdown-toggle' : ''; ?>" 
                <?php 
                if ($menu['type'] === 'drop-down') :
                    echo 'href="#" id="' . esc_attr($menu['collapse-id']) . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
                else :
                    echo 'href="' . esc_url($menu['href']) . '"';
                endif;
                ?>
            >
                <i class="escrot-nav-icon fas fa-<?= esc_attr($menu['icon']); ?>"></i>&nbsp;
                <?= $menu['title']; ?>
            </a>

            <?php if ($menu['type'] === 'drop-down') : ?>
                <div 
                    class="dropdown-menu dropdown-menu-right rounded p-2" 
                    aria-labelledby="<?= esc_attr($menu['collapse-id']); ?>"
                >
                    <?php foreach ($menu['submenus'] as $submenu) : ?>
                        <a 
                            id="<?= esc_attr($submenu['li-id']); ?>" 
                            class="dropdown-item escrot-rounded" 
                            href="<?= esc_url($submenu['href']); ?>" 
                            <?php 
                            if ($submenu['li-id'] === 'EscrotAddDisputesFrontNavItem') :
                                if (ESCROT_INTERACTION_MODE === 'modal') :
                                    echo 'data-toggle="modal" data-target="#escrot-add-dispute-modal"';
                                else :
                                    echo 'data-toggle="collapse" data-target="#escrot-add-dispute-form-dialog"';
                                endif;
                            endif;
							if ($submenu['li-id'] === 'EscrotCreateEscrowFrontNavItem') :
                                if (ESCROT_INTERACTION_MODE === 'modal') :
                                    echo 'data-toggle="modal" data-target="#escrot-add-escrow-modal"';
                                else :
                                    echo 'data-toggle="collapse" data-target="#escrot-add-escrow-form-dialog"';
                                endif;
                            endif;
                            ?>
                        >
                            <i class="escrot-nav-icon fas fa-<?= esc_attr($submenu['icon']); ?>"></i>&nbsp;
                            <?= esc_html($submenu['title']); ?>
                        </a>
                        <?php if ($submenu['li-id'] !== end($menu['submenus'])['li-id']) : ?>
                            <div class="dropdown-divider"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </li>
    <?php endforeach;

    echo ob_get_clean(); // Output the buffered content
}

// Include the front menu list
include ESCROT_PLUGIN_PATH . "templates/frontend/front-menu-list.php";

?>
<div class="card-nav-tabs">
    <div class="escrot-user-nav escrot-bg-primary escrot-rounded-top">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper row">
                <div class="d-sm-flex col-md-9">
                    <ul class="nav nav-tabs d-sm-flex align-items-center justify-content-between" data-tabs="tabs">
                        <?php escrot_front_menu_manager($main_menu); ?>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="nav nav-tabs float-right">
                        <li class="nav-item dropdown escrot-view-notif pt-2">
                            <a 
                                class="nav-link dropdown-toggle" 
                                href="javascript:;" 
                                id="escrot-front-user-noty" 
                                data-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false" 
                                data-escrot-escrow-url="<?= esc_url($routes['view_escrow']); ?>"
								data-escrot-dispute-url="<?= esc_url($routes['view_dispute']); ?>"
                            >
                                <i class="text-light fa fa-bell escrot-nav-icon"></i>
                                <span style="background: transparent; border: none !important;" class="notification"></span>
                            </a>
                            <div 
                                class="dropdown-menu notif-content rounded" 
                                aria-labelledby="escrot-front-user-noty"
                            ></div>
                        </li>
                        <?php escrot_front_menu_manager($profile_menu); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<hr />
