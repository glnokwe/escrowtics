<?php    

/**
 * Frontend modals
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */
 
 defined('ABSPATH') || exit;

	
$modals = array(
	array(
		"id" => "escrot-add-escrow-modal",
		"modal-static" => false,
		"modal-dialog-class" => "",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "",
		"title" => __("Add Escrow", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "add-escrow-form.php"
	),
	array(
		 "id" => "escrot-milestone-form-modal",
		 "modal-static" => false,
		 "modal-dialog-class" => "",
		 "modal-content-class" => "",
		 "header-status" => false, "header" => "",
		 "modal-title-class" => "",
		 "type" => "",  "icon" => "",
		 "title" => __("Add Escrow", "escrowtics"),
		 "modal-body-id" => "",
		 "callback" => "add-milestone-form.php"
	),
	array(
		 "id" => "escrot-view-milestone-modal",
		 "modal-static" => false,
		 "modal-dialog-class" => "w-50",
		 "modal-content-class" => "escrot-modal-sm",
		 "header-status" => false, "header" => "",
		 "modal-title-class" => "",
		 "type" => "",  "icon" => "",
		 "title" => __("Escrow Milestone Details", "escrowtics"),
		 "modal-body-id" => "escrot-view-milestone-modal-body",
		 "callback" => ""
	),
	array(
		"id" => "escrot-bitcoin-deposit-form-modal",
		"modal-static" => false,
		"modal-dialog-class" => "w-50",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "",
		"title" => __("User Deposit - Bitcoin", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "bitcoin-deposit-form.php"
	),
	array(
		"id" => "escrot-bitcoin-withdraw-form-modal",
		"modal-static" => false,
		"modal-dialog-class" => "",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "",
		"title" => __("User Withdrawal - Bitcoin", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "bitcoin-withdrawal-form.php"
	),
	array(
		"id" => "escrot-paypal-deposit-form-modal",
		"modal-static" => false,
		"modal-dialog-class" => "w-50",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "",
		"title" => __("Paypal Deposit", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "paypal-deposit-form.php"
	),
	array(
		"id" => "escrot-paypal-withdraw-form-modal",
		"modal-static" => false,
		"modal-dialog-class" => "",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "",
		"title" => __("Paypal Withdrawal", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "paypal-withdraw-form.php"
	),
	array(
		"id" => "escrot-manual-deposit-form-modal",
		"modal-static" => false,
		"modal-dialog-class" => "",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "",
		"title" => __("Manual Deposit", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "manual-deposit-form.php"
	),
	array(
		"id" => "escrot-manual-withdraw-form-modal",
		"modal-static" => false,
		"modal-dialog-class" => "",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "",
		"title" => __("Manual Withdrawal", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "manual-withdraw-form.php"
	),
	array(
		"id" => "escrot-add-dispute-modal",
		"modal-static" => false,
		"modal-dialog-class" => "",
		"modal-content-class" => "",
		"header-status" => false, "header" => "",
		"modal-title-class" => "",
		"type" => "",  "icon" => "people-arrows",
		"title" => __("Add Dispute", "escrowtics"),
		"modal-body-id" => "",
		"callback" => "add-dispute-form.php"
	)	

);

 
foreach($modals as $modal){ ?> 
 
	<div class="modal fade"<?= ($modal["modal-static"]? ' data-backdrop="static"' : ' style="z-index: 1045;"');  ?> id="<?= $modal["id"]; ?>">
	  <div class="modal-dialog <?= $modal["modal-dialog-class"]; ?>">
		<div class="modal-content  escrot-modal-content <?= $modal["modal-content-class"]; ?>">
			<div class="modal-header">
				<h3 class="modal-title text-dark <?= $modal["modal-title-class"]; ?>">
					<?php if($modal["header-status"]){ 
					   include_once(ESCROT_PLUGIN_PATH."templates/admin/template-parts/".$modal["header"]); 
					} else { ?>
						<i class="fa fa-<?= $modal["icon"]; ?> sett-icon"></i> 
						&nbsp;<?php if($modal["type"]== "edit-form") {echo $modal["title"]; } else { 
						echo __($modal["title"], "escrowtics"); } 
					} ?>
				</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="<?= $modal["modal-body-id"]; ?>">
				<?php 
					if($modal["id"] == 'escrot-ajax-results-modal'){ ?>
						<section style="max-width: 100%">
							<div class="container" style="margin-left: auto; margin-right: auto; margin-top: 0;">
								<div class="escrot-container position-relative">
									<div class="col-md-11 ml-auto mr-auto" style="margin-left: auto; margin-right: auto;">
										<div id="escrot-ajax-results-wrapper"> </div>
										<?php  if(ESCROT_CLIENT_NOTE){ include ESCROT_PLUGIN_PATH."templates/frontend/escrow-note-form.php"; } ?>
									</div>  
								</div>
							</div>
						</section>
					<?php }
					if(!empty($modal["callback"])) { 
						 if(explode('.', $modal["callback"])[1] == 'php') {
							include_once(ESCROT_PLUGIN_PATH."templates/forms/".$modal["callback"] ); 
						 } else {
							echo do_shortcode('['.$modal["callback"].']'); 
						 }
					}
				?>
			</div>
		</div>
	  </div>
	</div>
	
<?php } ?>