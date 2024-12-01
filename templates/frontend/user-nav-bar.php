<?php 

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
            class="nav-item <?php echo esc_attr($menu['li-classes']); ?> <?php echo ($menu['type'] === 'drop-down') ? 'dropdown' : ''; ?>" 
            id="<?php echo esc_attr($menu['li-id']); ?>"
        >
            <a 
                class="nav-link <?php echo esc_attr($menu['active_classes']); ?> <?php echo ($menu['type'] === 'drop-down') ? 'dropdown-toggle' : ''; ?>" 
                <?php 
                if ($menu['type'] === 'drop-down') :
                    echo 'href="#" id="' . esc_attr($menu['collapse-id']) . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
                else :
                    echo 'href="' . esc_url($menu['href']) . '"';
                endif;
                ?>
            >
                <i class="escrot-nav-icon fas fa-<?php echo esc_attr($menu['icon']); ?>"></i>&nbsp;
                <?php echo $menu['title']; ?>
            </a>

            <?php if ($menu['type'] === 'drop-down') : ?>
                <div 
                    class="dropdown-menu dropdown-menu-right rounded p-2" 
                    aria-labelledby="<?php echo esc_attr($menu['collapse-id']); ?>"
                >
                    <?php foreach ($menu['submenus'] as $submenu) : ?>
                        <a 
                            id="<?php echo esc_attr($submenu['li-id']); ?>" 
                            class="dropdown-item escrot-rounded" 
                            href="<?php echo esc_url($submenu['href']); ?>" 
                            <?php 
                            if ($submenu['li-id'] === 'EscrotAddTicketsFrontNavItem') :
                                if (ESCROT_PLUGIN_INTERACTION_MODE === 'modal') :
                                    echo 'data-toggle="modal" data-target="#escrot-add-ticket-modal"';
                                else :
                                    echo 'data-toggle="collapse" data-target="#escrot-add-ticket-form-dialog"';
                                endif;
                            endif;
                            ?>
                        >
                            <i class="escrot-nav-icon fas fa-<?php echo esc_attr($submenu['icon']); ?>"></i>&nbsp;
                            <?php echo esc_html($submenu['title']); ?>
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
                                class="nav-link" 
                                href="javascript:;" 
                                id="escrot-front-user-noty" 
                                data-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false" 
                                data-endpoint-url="<?php echo esc_url($routes['view_ticket']); ?>"
                            >
                                <i class="text-light fa fa-bell escrot-nav-icon"></i>
                                <span style="background: transparent; border: none !important;" class="notification"></span>
                            </a>
                            <div 
                                class="dropdown-menu dropdown-menu-right notif-content rounded" 
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
