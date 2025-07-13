<?php 

/**
 * Admin Settings Form Template
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

defined('ABSPATH') || exit;

$tabs = [
    [
        'id'        => 'GeneralTab',
        'title'     => __("General", "escrowtics"),
        'sections'  => ['general', 'company_logo'],
        'icon'      => 'gear'
    ],
    [
        'id'        => 'EscrowsTab',
        'title'     => __("Escrows", "escrowtics"),
        'sections'  => ['backend_escrow', 'ref_id', 'escrow_fees'],
        'icon'      => 'filter-circle-dollar'
    ],
    [
        'id'        => 'EmailsTab',
        'title'     => __("Email", "escrowtics"),
        'sections'  => ['email', 'smtp', 'user_escrow_email', 'admin_escrow_email'],
        'icon'      => 'envelope'
    ],
    [
        'id'        => 'StylingTab',
        'title'     => __("Styling", "escrowtics"),
        'sections'  => ['admin_appearance', 'public_appearance', 'labels'],
        'icon'      => 'paint-brush'
    ],
    [
        'id'        => 'DBBackupTab',
        'title'     => __("DB Backup", "escrowtics"),
        'sections'  => ['dbbackup'],
        'icon'      => 'database'
    ],
    [
        'id'        => 'PaymentTab',
        'title'     => __("Payments", "escrowtics"),
        'sections'  => ['bitcoin_payment', 'paypal_payment', 'invoice'],
        'icon'      => 'dollar-sign'
    ],
    [
        'id'        => 'CommissionTab',
        'title'     => __("Commissions", "escrowtics"),
        'sections'  => ['commissions', 'commissions_tax', 'commissions_threshold'],
        'icon'      => 'coins'
    ],
    [
        'id'        => 'DisputeTab',
        'title'     => __("Disputes", "escrowtics"),
        'sections'  => ['disputes', 'disputes_file'],
        'icon'      => 'people-arrows'
    ],
    [
        'id'        => 'AdvancedTab',
        'title'     => __("Advanced", "escrowtics"),
        'sections'  => ['advanced'],
        'icon'      => 'shield'
    ]
];

	
$custom_sections = ['company_logo', 'smtp', 'user_escrow_email', 'admin_escrow_email', 'labels'];
	
if (defined('ESCROT_INTERACTION_MODE') && ESCROT_INTERACTION_MODE === 'modal') : 

ob_start();

?>
    <div class="text-center">
        <button id="impSett" type="button" class="btn btn-round btn-icon-text escrot-btn-behance" 
                data-toggle="modal" 
                data-target="#escrot-options-import-modal">
            <i class="fas fa-upload"></i> <?= esc_html__("Import Settings", "escrowtics"); ?>
        </button>
        <button id="escrot-export-settings" class="btn btn-round m-1 btn-info">
            <i class="fa fa-download"></i> <?= esc_html__("Export Settings", "escrowtics"); ?>
        </button>
    </div>
    <br>
<?php endif; ?>

<form method="post" action="options.php" id="escrot-options-form">
    <?php 
    // Output security fields for the registered setting
    settings_fields('escrowtics_plugin_settings'); 
    // Display errors or notifications
    settings_errors(); 
    ?>

    <div id="escrot-settings-panel">
        <div class="card-body">
		<div class="pb-5 float-right card-header justify-content-between">
			<button title="<?= esc_html__("Save Settings", "escrowtics"); ?>" type="submit" name="submit" class="escrot-submit-settings shadow-lg btn btn-sm btn-outline-success">
				<i class="fa fa-save"></i> <span class="d-none d-md-inline"><?= esc_html__("Save Settings", "escrowtics"); ?></span>
			</button>
			 <button title="<?= esc_html__("Reset Settings", "escrowtics"); ?>" type="button" class="escrot-reset-settings shadow-lg btn btn-sm btn-outline-danger ml-3">
				<i class="fa fa-shuffle"></i> <span class="d-none d-md-inline"><?= esc_html__("Reset Settings", "escrowtics"); ?></span>
			</button>
		</div>
		
            <ul class="nav nav-pills w-100" role="tablist"> 
                <?php  foreach ($tabs as $tab) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $tab['id'] === 'GeneralTab' ? 'active' : ''; ?>" 
                           data-toggle="tab" 
                           href="#<?= esc_attr($tab['id']); ?>" 
                           role="tablist">
                            <i class="fa fa-<?= esc_attr($tab['icon']); ?>"></i> 
                            <?= esc_html($tab['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="tab-content tab-space">
                <?php foreach ($tabs as $tab) : ?>
                    <div class="tab-pane <?= $tab['id'] === 'GeneralTab' ? 'active' : ''; ?>" id="<?= esc_attr($tab['id']); ?>">
					<section id="escrot-horizontal-tabs">
							<div class="pt-5 container">
								<div class="row">
									<div class="col-md-12 ">
										<nav>
											<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
												<?php $counter = 0; ?>
												<?php  foreach ($tab['sections'] as $section) : ?>
													<?php
														$page = 'escrowtics_' . $section;
														$section_id = 'escrot_' . $section .'_settings';
													?>
													<a class="nav-item nav-link <?=  $counter === 0 ? 'active' : ''; ?>" id="<?= $section_id ?>-tab" data-toggle="tab" href="#<?= $section_id ?>_id" role="tab" aria-controls="<?= $section_id ?>_id" aria-selected="<?=  $counter === 0 ? 'true' : 'false'; ?>">
														<?= esc_html( escrot_get_settings_section_title( $page, $section_id ) ); ?>
													</a>
												<?php $counter++; endforeach; ?>	
											</div>
										</nav>
										<div class="tab-content py-3 px-3 px-sm-0 w-100" id="nav-tabContent">
											<?php $counter = 0; ?>
										    <?php  foreach ($tab['sections'] as $section) : ?>
											
											    <?php
												$page = 'escrowtics_' . $section;
												$section_id = 'escrot_' . $section .'_settings';
												?>
												<div class="tab-pane fade <?=  $counter === 0 ? 'active show' : ''; ?>" id="<?= $section_id ?>_id" role="tabpanel" aria-labelledby="<?= $section_id ?>-tab"> 
													<div class="row">
													
														<?php if( in_array($section, $custom_sections) ) { 
															$id = 'escrot-'.$section.'-options'; 
														?>
															<div id="<?= $id; ?>" class="col-md-12 flex card shadow-lg pr-5 pl-5">
																<div class="row">
																	<?php 
																		if($section ==='user_escrow_email' || $section ==='admin_escrow_email'){ 
																			echo escrot_merge_tags_table(); 
																		} 
																		do_settings_sections( 'escrowtics_' . $section ); 
																	?>
																</div>
															</div>
													
													   <?php } else { do_settings_sections('escrowtics_' . $section); } ?>
													</div>	
												</div>
												
											<?php   $counter++; endforeach;  ?>
											 
										</div>
									
									</div>
								</div>
							</div>
						</section>
						
						
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <br><br>

        <button title="<?= esc_html__("Save Settings", "escrowtics"); ?>" type="submit" name="submit" class="escrot-submit-settings float-right shadow-lg btn btn-sm btn-outline-success">
				<i class="fa fa-save"></i> <span class="d-none d-md-inline"><?= esc_html__("Save Settings", "escrowtics"); ?></span>
		</button>
		 <button title="<?= esc_html__("Reset Settings", "escrowtics"); ?>" type="button" class="mr-3 escrot-reset-settings float-right shadow-lg btn btn-sm btn-outline-danger">
			<i class="fa fa-shuffle"></i> <span class="d-none d-md-inline"><?= esc_html__("Reset Settings", "escrowtics"); ?></span>
		</button>
        <?php if (ESCROT_INTERACTION_MODE === "modal" && !wp_is_mobile()) : ?>
            <button type="button" class="btn shadow-lg btn btn-sm btn-outline-default float-right" data-dismiss="modal">
                <?= esc_html__("Close Panel", "escrowtics"); ?>
            </button>
        <?php endif; ?>
    </div>
</form>

<?php 

$content = ob_get_clean(); 
$translations = [
	'{escrot_currency}' => escrot_option('currency'),
];

echo strtr($content, $translations);




