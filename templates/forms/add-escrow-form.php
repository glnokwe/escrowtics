<?php

/**
 * Escrow Form Template
 *
 *
 * @version   1.0.0
 * @package   Escrowtics
 */

$form_type = 'add';

if (escrot_option('escrow_form_style') === 'normal') : ?>
    <div class="p-5">
        <form id="AddEscrowForm" enctype="multipart/form-data">
            <div class="card-body">
                <div class="text-danger" id="escrot-escrow-error"></div>
                <div class="row">
                    <?php
                    $form_title = escrot_is_front_user() 
                        ? esc_html__("Username (Earner)", "escrowtics") 
                        : esc_html__("Escrow Parties (Payer & Earner)", "escrowtics");
                    ?>
                    <div class="col-md-12">
                        <label>
                            <h3 class="text-dark">
                                <?= $form_title; ?>
                            </h3>
                        </label>
                    </div>
                    <?php
                    include ESCROT_PLUGIN_PATH . "templates/forms/form-fields/escrow-form-fields/escrow-info-form-fields.php";
                    ?>
                    <div class="col-md-12">
                        <label>
                            <h3 class="text-dark">
                                <?php esc_html_e("Transaction Details", "escrowtics"); ?>
                            </h3>
                        </label>
                    </div>
                    <?php
                    include ESCROT_PLUGIN_PATH . "templates/forms/form-fields/escrow-form-fields/escrow-meta-form-fields.php";
                    ?>
                </div>
                <div class="row" id="appendCF"></div>
                <br><br>
                <div style="color: red;" class="add_error_msg"></div>
                <br>
                <button type="submit" class="btn escrot-btn-primary text-white" id="addTrackingBtn">
                    <?php esc_html_e("Add Escrow", "escrowtics"); ?>
                </button>
                <?php if (ESCROT_INTERACTION_MODE === "modal") : ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <?php esc_html_e("Cancel", "escrowtics"); ?>
                    </button>
                <?php else : ?>
                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#escrot-add-escrow-form-dialog">
                        <?php esc_html_e("Close Form", "escrowtics"); ?>
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php else : ?>
    <div class="wizard-container">
        <div class="card card-wizard bg-transparent p-0" data-color="purple" id="wizardProfile" style="border:none; box-shadow: none;">
            <form method="post" id="AddEscrowForm">
                <div class="text-danger" id="escrot-escrow-error"></div>
                <div class="wizard-navigation">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#EscrowInfoTab" role="tab">
                                <?php esc_html_e("Escrow Users", "escrowtics"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link escrot-form-next-btn" data-toggle="tab" href="#DetailsTab" role="tab">
                                <?php esc_html_e("Transaction Details", "escrowtics"); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="mt-5 card-footer">
                    <div class="mr-auto">
                        <input type="button" class="btn btn-outline-secondary btn-round btn-previous btn-fill btn-wd disabled" name="previous" value="<?php esc_html_e("Previous", "escrowtics"); ?>">
                    </div>
                    <div class="ml-auto">
                        <input type="button" class="btn btn-outline-info btn-next btn-round btn-fill btn-wd escrot-form-next-btn" name="next" value="<?php esc_html_e("Next", "escrowtics"); ?>">
                        <button type="submit" class="btn btn-outline-success btn-finish btn-round btn-fill btn-wd" name="finish" style="display: none;">
                            <i class="fas fa-user-plus"></i> <?php esc_html_e("Add Escrow", "escrowtics"); ?>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="EscrowInfoTab">
                            <h3 class="text-light">
                                <?php esc_html_e("Escrow Parties (Payer & Earner)", "escrowtics"); ?>
                            </h3>
                            <br><br>
                            <div class="row justify-content-center">
                                <?php include ESCROT_PLUGIN_PATH . "templates/forms/form-fields/escrow-form-fields/escrow-info-form-fields.php"; ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="DetailsTab">
                            <h3 class="text-light">
                                <?php esc_html_e("Transaction Details", "escrowtics"); ?>
                            </h3>
                            <br><br>
                            <div class="row justify-content-center">
                                <?php include ESCROT_PLUGIN_PATH . "templates/forms/form-fields/escrow-form-fields/escrow-meta-form-fields.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 card-footer">
                    <div class="mr-auto">
                        <input type="button" class="btn btn-outline-secondary btn-round btn-previous btn-fill btn-wd disabled" name="previous" value="<?php esc_html_e("Previous", "escrowtics"); ?>">
                    </div>
                    <div class="ml-auto">
                        <input type="button" class="btn btn-outline-info btn-next btn-round btn-fill btn-wd escrot-form-next-btn" name="next" value="<?php esc_html_e("Next", "escrowtics"); ?>">
                        <button type="submit" class="btn btn-outline-success btn-finish btn-round btn-fill btn-wd" name="finish" style="display: none;">
                            <i class="fas fa-user-plus"></i> <?php esc_html_e("Add Escrow", "escrowtics"); ?>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="text-danger add_error_mge"></div>
        </div>
    </div>
<?php endif; ?>
