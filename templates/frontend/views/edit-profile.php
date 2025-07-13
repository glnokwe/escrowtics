<?php
// Define tab data
$tabs = [
    [
        'id'      => 'escrot-user-dashboard',
        'title'   => __('Profile', 'fnehousing'),
        'content' => ESCROT_PLUGIN_PATH . 'templates/frontend/views/user-dashboard.php',
        'active'  => true,
    ],
    [
        'id'      => 'escrot-edit-account',
        'title'   => __('Edit Account', 'fnehousing'),
        'content' => ESCROT_PLUGIN_PATH . 'templates/forms/user-account-form.php',
        'active'  => false,
    ],
    [
        'id'      => 'escrot-edit-pass',
        'title'   => __('Password & Security', 'fnehousing'),
        'content' => ESCROT_PLUGIN_PATH . 'templates/forms/user-password-form.php',
        'active'  => false,
    ],
];

// Determine padding class based on device
$padding_class = wp_is_mobile() ? 'p-2' : 'p-5';
?>

<div id="escrot-user-account-form-wrapper" class="card shadow-lg p-5">
    <div class="col-xs-12 <?php echo esc_attr($padding_class); ?>" id="escrot-horizontal-tabs">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <?php foreach ($tabs as $tab): ?>
                    <a class="nav-item nav-link <?php echo $tab['active'] ? 'active' : ''; ?>"
                       data-toggle="tab"
                       href="#<?php echo esc_attr($tab['id']); ?>"
                       role="tab"
                       aria-selected="<?php echo $tab['active'] ? 'true' : 'false'; ?>">
                        <?php echo esc_html($tab['title']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
        <div class="tab-content py-3 px-3 px-sm-0">
            <?php foreach ($tabs as $tab): ?>
                <div class="tab-pane fade <?php echo $tab['active'] ? 'show active' : ''; ?>"
                     id="<?php echo esc_attr($tab['id']); ?>"
                     role="tabpanel">
                    <?php include_once $tab['content']; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>