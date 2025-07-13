<?php
/**
 * Frontend User Account Form Template
 *
 * @version   1.0.0
 * @package   Escrowtics
 */
 
 
// Check if the user's profile is complete
$user_info = [];
$info_list = ['phone', 'address', 'country', 'company', 'user_url', 'bio', 'user_image'];
foreach ($info_list as $info) {
    $user_info[$info] = $user_data[$info] ?? '';
}

// Calculate completion percentage
$completed_count = count( array_filter( $user_info, function ($value) { return !empty($value); } ) );
$percent_complete = round( ( $completed_count / count($user_info) ) * 100 );

// Format the user registration date
$date = new \DateTime($user_data['user_registered']);
$joined_date = $date->format('F j, Y');


// Define fields for user account form
$fields = [
    [
        'label' => __('Username', 'escrowtics'),
        'type' => 'text',
        'name' => 'user_login',
        'placeholder' => '',
        'value' => $user_data['user_login'],
        'readonly' => true,
        'class' => 'col-md-4',
    ],
    [
        'label' => __('First Name', 'escrowtics'),
        'type' => 'text',
        'name' => 'first_name',
        'placeholder' => __('John Smith', 'escrowtics'),
        'value' => $user_data['first_name'],
        'class' => 'col-md-4',
    ],
    [
        'label' => __('Last Name', 'escrowtics'),
        'type' => 'text',
        'name' => 'last_name',
        'placeholder' => __('Enter Last Name', 'escrowtics'),
        'value' => $user_data['last_name'],
        'class' => 'col-md-4',
    ],
    [
        'label' => __('Email', 'escrowtics'),
        'type' => 'text',
        'name' => 'user_email',
        'placeholder' => __('Enter Email', 'escrowtics'),
        'value' => $user_data['user_email'],
        'class' => 'col-md-4',
    ],
    [
        'label' => __('Phone', 'escrowtics'),
        'type' => 'text',
        'name' => 'phone',
        'placeholder' => __('Enter Phone No.', 'escrowtics'),
        'value' => $user_data['phone'],
        'class' => 'col-md-4',
    ],
    [
        'label' => __('Country', 'escrowtics'),
        'type' => 'select',
        'name' => 'country',
        'options' => escrot_countries(),
        'selected' => $user_data['country'],
        'class' => 'col-md-4',
    ],
    [
        'label' => __('Company', 'escrowtics'),
        'type' => 'text',
        'name' => 'company',
        'placeholder' => __('Enter Company', 'escrowtics'),
        'value' => $user_data['company'],
        'class' => 'col-md-6',
    ],
    [
        'label' => __('Website', 'escrowtics'),
        'type' => 'text',
        'name' => 'user_url',
        'placeholder' => __('Enter Website', 'escrowtics'),
        'value' => $user_data['user_url'],
        'class' => 'col-md-6',
    ],
    [
        'label' => __('Address', 'escrowtics'),
        'type' => 'text',
        'name' => 'address',
        'placeholder' => __('Enter Address', 'escrowtics'),
        'value' => $user_data['address'],
        'class' => 'col-md-12',
    ],
    [
        'label' => __('Company Bio', 'escrowtics'),
        'type' => 'textarea',
        'name' => 'bio',
        'placeholder' => __('Enter a short bio (max 200 characters)', 'escrowtics'),
        'value' => $user_data['bio'],
        'class' => 'col-md-12',
    ],
];
?>

<div class="pt-5 escrot-rounded e-profile">
    <form id="escrot-edit-user-form" class="form" enctype="multipart/form-data">
        <div style="color: red;" id="escrot_user_error"></div>
        <div class="row">
            <div class="col-12 col-sm-auto mb-3">
                <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                        <?= escrot_image($user_data['user_image'], 100, 'rounded-circle'); ?>
                    </div>
                </div>
            </div>
            <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">
                        <?= esc_html($user_data['first_name'] . ' ' . $user_data['last_name']); ?>
                    </h4>
                    <p class="mb-0">@<?= esc_html($user_data['user_login']); ?></p>
					
					<!-- Image Upload-->
					<div class="mt-2">
						<div class="fileinput fileinput-new text-center" data-provides="fileinput">
							<div class="fileinput-new thumbnail img-circle"></div>
							<div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
							<div>
								<span class="btn btn-round btn-primary btn-file btn-sm">
									<span class="fileinput-new">
										<i class="fa fa-fw fa-camera"></i><?= __('Update User Image', 'escrowtics'); ?>
									</span>
									<span class="fileinput-exists">
										<i class="fa fa-fw fa-camera"></i><?= __('Change Image', 'escrowtics'); ?>
									</span>
									<input type="file" name="file" accept="image/jpg,image/jpeg,image/png,image/webp"/>
								</span><br>
								<a href="javascript:;" class="btn btn-danger btn-round fileinput-exists btn-sm" data-dismiss="fileinput">
								<i class="fa fa-times"></i> <?= __('Remove', 'escrowtics'); ?></a>
							</div>
						</div>
					</div>
					
                </div>
                <div class="text-center text-sm-right">
                    <span class="badge badge-secondary"><?= __('User', 'escrowtics'); ?></span>
                    <div class="text-muted">
                        <small>
                            <?= sprintf(__('Joined: %s', 'escrowtics'), esc_html($joined_date)); ?><br>
                            <?= sprintf(__('Profile Completion: %d%%', 'escrowtics'), $percent_complete); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content pt-3">
            <div class="tab-pane active">
                <input type="hidden" name="action" value="escrot_update_user">
                <?php wp_nonce_field('escrot_user_nonce', 'nonce'); ?>

                <div class="row">
                    <?php foreach ($fields as $field): ?>
                        <div class="<?= esc_attr($field['class']); ?>">
                            <div class="form-group">
                                <label><b><?= esc_html($field['label']); ?></b></label>
                                <?php if ($field['type'] === 'select'): ?>
                                    <select class="form-control" name="<?= esc_attr($field['name']); ?>">
                                        <?php foreach ($field['options'] as $value => $title): ?>
                                            <option value="<?= esc_attr($value); ?>" <?= selected($value, $field['selected'], false); ?>>
                                                <?= esc_html($title); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php elseif ($field['type'] === 'textarea'): ?>
                                    <textarea class="form-control" name="<?= esc_attr($field['name']); ?>" 
                                              placeholder="<?= esc_attr($field['placeholder']); ?>" 
                                              rows="5" maxlength="200"><?= esc_html($field['value']); ?></textarea>
                                <?php else: ?>
                                    <input type="<?= esc_attr($field['type']); ?>" 
                                           class="form-control" 
                                           name="<?= esc_attr($field['name']); ?>" 
                                           placeholder="<?= esc_attr($field['placeholder']); ?>" 
                                           value="<?= esc_attr($field['value']); ?>" 
                                           <?= !empty($field['readonly']) ? 'readonly' : ''; ?>>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col d-flex justify-content-end">
                    <button class="btn text-light escrot-btn-primary escrot-rounded" type="submit">
						<?= __('Save Changes', 'escrowtics'); ?>
					</button>
                </div>
            </div>
        </div>
    </form>
</div>
