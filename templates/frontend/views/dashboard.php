<?php
/**
 * Escrow Dashboard.
 * Displays user's escrow metrics.
 *
 * @since 1.0.0
 */
 
 defined('ABSPATH') || exit;

// Redirect to dashboard if the endpoint is not set
if (!$escrot_endpoint) {
    // Add the 'dashboard' endpoint to the current URL and redirect
    $redirect = add_query_arg(['endpoint' => 'dashboard'], escrot_current_url());
    echo '<meta http-equiv="refresh" content="0;url=' . $redirect . '">';
}



// Metrics to display on the dashboard
$metrics = [
    __('Escrow List', 'escrowtics') => ['icon' => 'filter-circle-dollar', 'count' => $escrow_count, 'url' => 'escrow_list'],
    __('Earning List', 'escrowtics') => ['icon' => 'hand-holding-dollar', 'count' => $earning_count, 'url' => 'earning_list'],
    __('Total Balance', 'escrowtics') => ['icon' => 'wallet', 'count' => $user_data['balance']]
];

?>
<div class="section escrot-user-dashboard gray-bg">
	<a href="#" data-toggle="<?= ESCROT_INTERACTION_MODE === 'modal'? 'modal'  : 'collapse' ?>" data-target="<?= ESCROT_INTERACTION_MODE === 'modal'? '#escrot-add-escrow-modal' : '#escrot-add-escrow-form-dialog' ?>">
		<h3 class="p-2 text-center"><?= __('Add Escrow'); ?> <i class="fa fa-add"></i></h3>
	</a>	
    <div class="d-flex flex-wrap gap-4 justify-content-center p-5">
        <!-- Loop through the metrics and display each -->
        <?php foreach ($metrics as $tle => $val) { ?>
            <div class="escrot-dashboard-metric p-2">
                <?php if(isset($val['url'])) { ?><a href="<?= esc_url($routes[$val['url']]); ?>" class="text-decoration-none"> <?php } ?>
                    <div class="card escrot-dashboard-metric-box shadow-sm text-center">
                        <h3><i class="text-secondary fa-xl fa fa-<?= $val['icon']; ?>"></i> 
                            <?= escrot_minify_count($val['count']); ?></h3>
                        <p class="m-0px font-w-600">
                            <?php
                                echo '<br><b>' . $tle . '</b>';
                                if ($tle == "Total Balance") {
                                    echo ' (' . escrot_option('currency') .' '. number_format($val['count']) . ')';
                                } else {
                                    echo ' (<b>' . escrot_minify_count($val['count']) . '</b>'.( $val['count'] > 1? __(" Members", "escrowtics") : __(" Member", "escrowtics") ) . ')';
                                }
                            ?> 
                        </p>
                    </div>
                <?php if(isset($val['url'])) { ?></a> <?php } ?>
            </div>
        <?php } ?>  
    </div>
</div>
