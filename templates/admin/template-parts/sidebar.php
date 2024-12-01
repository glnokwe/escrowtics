<div 
    class="sidebar<?php echo (ESCROT_ADMIN_NAV_STYLE === 'sidebar') ? '' : ' d-block d-md-none'; ?>" 
    data-color="azure" 
    data-background-color="default"
>
    <?php
    // Include admin logo and menu list templates
    include ESCROT_PLUGIN_PATH . "templates/admin/template-parts/escrot-admin-logo.php";
    include ESCROT_PLUGIN_PATH . "templates/admin/template-parts/menu-list.php";
    ?>

    <div class="sidebar-wrapper">
        <ul class="nav">
            <?php if (!empty($menus)) : ?>
                <?php foreach ($menus as $menu) : ?>
                    <li class="nav-item <?php echo esc_attr($menu['li-classes']); ?>" id="<?php echo esc_attr($menu['li-id']); ?>">
                        <?php if ($menu['li-id'] === 'EscrotSettMenuItem' && ESCROT_PLUGIN_INTERACTION_MODE === 'modal') : ?>
                            <a class="nav-link escrot-nav-link" id="BtnSettings" data-toggle="modal" data-target="#escrot-sett-modal">
                        <?php else : ?>
                            <a class="nav-link escrot-nav-link" 
                                <?php echo ($menu['type'] === 'drop-down') ? 'data-toggle="collapse"' : ''; ?> 
                                href="<?php echo esc_url($menu['href']); ?>">
                        <?php endif; ?>
                                <i class="fas fa-<?php echo esc_attr($menu['icon']); ?>"></i>
                                <p>
                                    <?php echo esc_html__($menu['title'], 'escrowtics'); ?>
                                    <?php if ($menu['type'] === 'drop-down') : ?>
                                        <b class="caret"></b>
                                    <?php endif; ?>
                                </p>
                            </a>

                        <?php if ($menu['type'] === 'drop-down') : ?>
                            <div class="collapse" id="<?php echo esc_attr($menu['collapse-id']); ?>">
                                <ul class="nav">
                                    <?php foreach ($menu['submenus'] as $submenu) : ?>
                                        <li class="nav-item" id="<?php echo esc_attr($submenu['li-id']); ?>">
                                            <a 
                                                class="nav-link escrot-nav-link"
                                                <?php 
                                                if ($submenu['li-id'] === 'EscrotQuikResDB') {
                                                    echo (ESCROT_PLUGIN_INTERACTION_MODE === 'modal') 
                                                        ? 'data-toggle="modal" data-target="#escrot-db-restore-modal"' 
                                                        : 'data-toggle="collapse" data-target="#escrot-db-restore-form-dialog"';
                                                } 
                                                ?>
                                                href="<?php echo esc_url($submenu['href']); ?>"
                                            >
                                                <i class="fas fa-<?php echo esc_attr($submenu['icon']); ?>"></i>
                                                <span class="sidebar-normal"><?php echo esc_html__($submenu['title'], 'escrowtics'); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
