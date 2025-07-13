<?php

/**
* Core Plugin wide functions
* Provide helper functionalities
* @since      1.0.0
* @package    Escrowtics
*/

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Escrowtics\Base\DefaultOptions;

defined('ABSPATH') || exit;


/**
 * Retrieve plugin options
 *
 * @param string $key The option name.
 */
function escrot_option($key) {
    $options = get_option('escrowtics_options', []);
	$option = ( !empty($options[$key]) || is_bool($options[$key]) ) ? $options[$key] : DefaultOptions::get($key);
    return $option;
}


/**
 * Retrieves the user's IP address.
 *
 * @return string User's IP address.
 */
function escrot_get_ip() {
	$ip = '';

	// Check if HTTP_CLIENT_IP is set and valid
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	// Check if HTTP_X_FORWARDED_FOR is set and contains a valid IP
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		foreach ($ipList as $ipItem) {
			$ipItem = trim($ipItem);
			// Validate each IP
			if (filter_var($ipItem, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				$ip = $ipItem;
				break;
			}
		}
	}
	// Use REMOTE_ADDR as the fallback
	elseif (!empty($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	// If the IP is ::1 (IPv6 localhost), map it to 127.0.0.1
	if ($ip === '::1') {
		$ip = '127.0.0.1';
	}

	return $ip;
}


/**
 * Verify user permissions.
 *
 * @param string $capability The capability to check.
 */
function escrot_verify_permissions($capability) {
	$capability = escrot_is_front_user()? 'escrowtics_user' : $capability;
	if (!current_user_can($capability)) {
		wp_send_json_error(__('You do not have the required permissions.', 'escrowtics'), 403);
	}
}

 /**
 * Validates the nonce for AJAX requests.
 *
 * @param string $nonce_action Action for nonce validation.
 * @param string $nonce_field  Nonce field to validate.
 */
function escrot_validate_ajax_nonce($nonce_action, $nonce_field) {
	if (!check_ajax_referer($nonce_action, $nonce_field, false)) {
		wp_send_json_error(['message' => __('Invalid nonce. Try reloading the page.', 'escrowtics')]);
	}
}

/**
 * Generate a QR Code.
 *
 * @param string $data Data to encode in the QR code.
 * @param int    $width Width of the QR code.
 * @param int    $height Height of the QR code.
 * @return string HTML string for the QR code.
 */
function escrot_generate_qrcode($data, $width = 300, $height = 300) {
    $options = new QROptions([
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
    ]);

    $qrcode = (new QRCode($options))->render($data);
    return sprintf('<img src="%s" alt="QR Code" width="%d" height="%d" />', $qrcode, intval($width), intval($height));
}


/**
 * Deregister unwanted scripts.
 *
 * @param array $handles List of script handles to remove.
 */
function escrot_deregister_scripts(array $handles) {
    foreach ($handles as $handle) {
        wp_dequeue_script($handle);
        wp_deregister_script($handle);
    }
}

/**
 * Deregister unwanted styles.
 *
 * @param array $handles List of style handles to remove.
 */
function escrot_deregister_styles(array $handles) {
    foreach ($handles as $handle) {
        wp_dequeue_style($handle);
        wp_deregister_style($handle);
    }
}

/**
 * Retrieve the title of a specific section in WordPress settings.
 *
 * This function extracts the section title for a given settings page and section ID
 * from the global `$wp_settings_sections` array. It parses the title to retrieve the 
 * text content inside `<h4>` tags.
 *
 * @param string $page  The slug of the settings page.
 * @param string $section_id The ID of the section.
 * 
 * @return string|null  The extracted section title, or null if not found.
 */
function escrot_get_settings_section_title($page, $section_id) {
    global $wp_settings_sections;

    // Check if the page and section exist
    if (isset($wp_settings_sections[$page][$section_id])) {
        $title = $wp_settings_sections[$page][$section_id]['title'];
		preg_match('/<h4>(.*?)<\/h4>/', $title, $matches);
		
		return $matches[1];
    }
    return null;
}


/**
 * Generate a random unique ID.
 *
 * @param int $length Length of the generated ID.
 * @return string Random unique ID.
 */
function escrot_unique_id($length = 12) {
    $characters = defined('ESCROT_ESCROW_REF_CHARACTERS') ? ESCROT_ESCROW_REF_CHARACTERS : '0123456789';
    $ref_id = '';
    for ($i = 0; $i < intval($length); $i++) {
        $ref_id .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $ref_id;
}



/**
 * Check if string is variable.
 *
 * @param string $url URL or string to be checked.
 * @return bool.
 */
function escrot_is_valid_url($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}


/**
 * Handle file upload securely.
 *
 * @param string $file File input name.
 * @return string|WP_Error Uploaded file URL or error message.
 */
function escrot_uploader($file, $file_size_limit = 5, array $allowed_types = ['image/jpeg','image/png','application/pdf']) {
    // Check if the file input is set and has a valid name
    if (!empty($_FILES[$file]['name'])) {
        // Include WordPress file handling functions
        require_once ABSPATH . 'wp-admin/includes/file.php';
        
        // Sanitize file input to prevent potential security risks
        $uploadedfile = $_FILES[$file];
        $upload_overrides = [
            'test_form' => false, // Prevent form checking to avoid issues with AJAX submissions
        ];

        // Check file size
        if ($uploadedfile['size'] > $file_size_limit*1024*1024) {
			$error = sprintf(__('The uploaded file exceeds the size limit of %s megabytes.', 'escrowtics'), $file_size_limit);
			return new \WP_Error('file_size_error', $error);
        }

        // Check file type
        $file_type = wp_check_filetype($uploadedfile['name']);
        if (!in_array($file_type['type'], $allowed_types)) {
			$allowed = [];
			foreach($allowed_types as $type){
				switch($type){
					case 'image/jpeg':
					$allowed[] = 'Jpeg';
					break;
					case 'image/png':
					$allowed[] = 'Png';
					break;
					case 'application/pdf':
					$allowed[] = 'Pdf';
					break;
					case 'application/msword':
					$allowed[] = 'Word';
					break;
					case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
					$allowed[] = 'Excel(xls)';
					break;
					case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
					$allowed[] = 'Excel(xlsx)';
					break;
				}
			}
			if (count($allowed) > 1) {
				$last_item = array_pop($allowed); // Remove the last element
				$allowed_types = implode(', ', $allowed) . ' and ' . $last_item; // Concatenate the rest with 'and'
			} else {
				$allowed_types = $allowed[0]; // If there's only one element
			}
			$error = sprintf(__('Invalid file type. Only %s files are allowed.', 'escrowtics'), $allowed_types);
			return new \WP_Error('file_type_error', $error);
        }

        // Handle the file upload
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        // Check if the file upload was successful
        if ($movefile && !isset($movefile['error'])) {
            // Return the file URL if upload is successful
            return esc_url($movefile['url']);
        } else {
            // Return the error message if upload failed
            return new \WP_Error('upload_error', esc_html($movefile['error']));
        }
    }
}



/**
 * Check if a user has the "escrowtics_user" role.
 *
 * @param int $user_id User ID.
 * @return bool True if the user has the role, false otherwise.
 */
function escrot_is_front_user($user_id = null) {
    $user_id = $user_id ?: get_current_user_id();
    $user = get_userdata($user_id);
    return $user && in_array('escrowtics_user', (array) $user->roles, true);
}
	

/**
 * Display an image with fallback.
 *
 * @param string $src Image URL.
 * @param int    $size Image width.
 * @param string $class Optional CSS classes.
 * @return string HTML string for the image.
 */
function escrot_image($src, $size, $class = '') {
    $default = ESCROT_PLUGIN_URL . 'assets/img/placeholder.jpg';
    $img_src = !empty($src) ? esc_url($src) : esc_url($default);
    return sprintf('<img src="%s" class="%s" width="%d" alt="" />', $img_src, esc_attr($class), intval($size));
}
	


/**
 * Sanitize and prepare form data for processing.
 *
 * @param array $fields List of form fields to process.
 * @return array Sanitized form data.
 */
function escrot_sanitize_form_data(array $fields) {
    $data = [];
    foreach ($fields as $key) {
        if (isset($_POST[$key])) {
            $value = wp_unslash($_POST[$key]);
            switch ($key) {
                case 'email':
                    $data[$key] = sanitize_email($value);
                    break;
                case 'username':
                    $data[$key] = sanitize_user($value);
                    break;
                case 'redirect':
                    $data[$key] = esc_url_raw($value);
                    break;
                default:
                    $data[$key] = sanitize_text_field($value);
            }
        } else {
            $data[$key] = '';
        }
    }
    return $data;
}



/**
 * Get sanitized request data ($_GET).
 *
 * @param array $fields List of fields to process.
 * @return array Sanitized request data.
 */
function escrot_get_request_data(array $fields) {
    $data = [];
    foreach ($fields as $key) {
        $data[$key] = isset($_GET[$key]) ? sanitize_text_field(wp_unslash($_GET[$key])) : '';
    }
    return $data;
}

	
/**
 * Validate user login/signup form data.
 *
 * @param array $data Form data to validate.
 * @return WP_Error Validation errors, if any.
 */
function escrot_validate_form($data) {
    $error = new \WP_Error();

    if (empty($data['user_login'])) {
        $error->add('empty_username', __('Username is required.', 'escrowtics'));
    }
    if (empty($data['user_pass'])) {
        $error->add('empty_password', __('Password is required.', 'escrowtics'));
    }
    if (!empty($_POST['form_type']) && $_POST['form_type'] === 'signup form') {
        if (empty($data['user_email']) || !is_email($data['user_email'])) {
            $error->add('invalid_email', __('Valid email is required.', 'escrowtics'));
        }
        if (empty($data['confirm_pass']) || $data['user_pass'] !== $data['confirm_pass']) {
            $error->add('passwords_do_not_match', __('Passwords do not match.', 'escrowtics'));
        }
    }

    return apply_filters('escrot_validate_form_data', $error, $data);
}


//Return redirection url. Filters redirection URL to redirect to after user is logged in.
function escrot_redirect_url( $user, $redirect ) {
	$redirect_url = apply_filters( 'escrot_after_login_redirect_url', $redirect, $user );
	$redirect_url = wp_validate_redirect( $redirect_url, $redirect );
	return $redirect_url;
}


//Minify Count
function escrot_minify_count($count) {
	if(is_numeric($count)) {
		if ( $count > 999 && $count <= 999999 ){ 
		   $output = round($count/1000, 1).'K'; 
		} elseif ( $count > 999999 ) { 
			$output = round($count/1000000, 1).'M'; 
		}  elseif ( $count > 999999999 ) { 
			$output = round($count/1000000000, 1).'B';
		}  else { 
			$output = $count; 
		} 
	}else {
		$output = 0;
	}
	return $output;
}

//dsiplay chart and table stats
function escrot_stat_chart_tbl($col_class, $color, $icon, $title, $subtitle, $type, $count, $id, $box_ht) {
	ob_start();
	?>
	<div class="<?= esc_attr($col_class); ?>">
		<div class="card card-chart">
			<div class="card-header card-header-icon card-header-<?= esc_attr($color); ?>">
				<div class="card-icon">
					<i class="fas fa-<?= esc_attr($icon); ?>"></i>
				</div>
				<h4 class="card-title mt-3 mb-2 ms-3">
					<?= $title; ?>
					<?php if (!empty($subtitle)) : ?>
						<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $subtitle; ?></small>
					<?php endif; ?>
				</h4>
			</div>
			<div class="card-body p-3">
				<?php if ($type === 'table') : ?>
					<div id="<?= esc_attr($id); ?>">
						<?= escrot_loader(__('Loading...', 'escrowtics')); ?>
					</div>
				<?php elseif ($type === 'chart') : ?>
					<?php if ($count > 0) : ?>
						<div style="height: <?= intval($box_ht); ?>px;" id="<?= esc_attr($id); ?>" class="ct-chart">
							<?= escrot_loader(__('Loading...', 'escrowtics')); ?>
						</div>
					<?php else : ?>
						<h4 style="height: <?= intval($box_ht); ?>px;" class="text-light text-center pt-5">
							<?= esc_html__('Not enough data to draw chart', 'escrowtics'); ?>
						</h4>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}




/**
 * Display chart and table stats with tabs.
 *
 * @param array $data Data array containing configuration for charts, tables, and tabs.
 * @return string Sanitized HTML output for the tabs, charts, and tables.
 */
function escrot_tab_stat_chart_tbl($data) {
    // Validate required keys in $data
    $required_keys = ['col_class', 'id', 'color', 'icon', 'title', 'tabs', 'box_ht'];
    foreach ($required_keys as $key) {
        if (!isset($data[$key])) {
            return ''; // Exit early if required data is missing.
        }
    }

    ob_start(); // Start output buffering
    ?>
    <div class="<?= esc_attr($data['col_class']); ?>" id="<?= esc_attr($data['id']); ?>">
        <div class="card card-chart">
            <div class="card-header card-header-icon card-header-<?= esc_attr($data['color']); ?>">
                <div class="card-icon">
                    <i class="fas fa-<?= esc_attr($data['icon']); ?>"></i>
                </div>
                <h4 class="card-title mt-3 mb-2 ms-3">
                    <?= esc_html($data['title']); ?>
                    <?php if (!empty($data['subtitle'])) : ?>
                        <small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= esc_html($data['subtitle']); ?></small>
                    <?php endif; ?>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="col-xs-12" id="escrot-horizontal-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <?php foreach ($data['tabs'] as $tab) : ?>
                                <?php
                                if (!isset($tab['id'], $tab['title'], $tab['active'], $tab['selected'])) {
                                    continue;
                                }
                                $active_class = !empty($tab['active']) ? ' show active' : '';
                                ?>
                                <a class="text-light nav-item nav-link<?= esc_attr($active_class); ?>"
                                   data-toggle="tab"
                                   href="#<?= esc_attr($tab['id']); ?>-tab"
                                   role="tab"
                                   aria-selected="<?= esc_attr($tab['selected']); ?>">
                                    <?= esc_html($tab['title']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </nav>
                    <div class="tab-content py-3 px-3 px-sm-0">
                        <?php foreach ($data['tabs'] as $tab) : ?>
                            <?php
                            if (!isset($tab['id'], $tab['type'], $tab['active'], $tab['count'])) {
                                continue;
                            }
                            $active_class = !empty($tab['active']) ? ' show active' : '';
                            ?>
                            <div class="tab-pane fade<?= esc_attr($active_class); ?>"
                                 id="<?= esc_attr($tab['id']); ?>-tab"
                                 role="tabpanel">
                                <?php if ($tab['type'] === 'table') : ?>
                                    <div id="<?= esc_attr($tab['id']); ?>">
                                        <?= escrot_loader(__('Loading...', 'escrowtics')); ?>
                                    </div>
                                <?php elseif ($tab['type'] === 'chart') : ?>
                                    <?php if ((int)$tab['count'] > 0) : ?>
                                        <div style="height: <?= esc_attr($data['box_ht']); ?>;"
                                             id="<?= esc_attr($tab['id']); ?>"
                                             class="ct-chart">
                                            <?= escrot_loader(__('Loading...', 'escrowtics')); ?>
                                        </div>
                                    <?php else : ?>
                                        <h4 style="height: <?= esc_attr($data['box_ht']); ?>;"
                                            class="text-light text-center pt-5">
                                            <?php esc_html_e('Not enough data to draw chart', 'escrowtics'); ?>
                                        </h4>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return trim(ob_get_clean()); // Return the buffered content.
}



/**
 * Generate a statistics box.
 *
 * @param string $id        The ID of the stat box.
 * @param int    $count     The numerical value to display.
 * @param string $sub       Singular label for the stat (e.g., "Transaction").
 * @param string $sub_s     Plural label for the stat (e.g., "Transactions").
 * @param string $col_class CSS class for the column container.
 * @param string $color     Color theme for the stat box.
 * @param string $icon      Font Awesome icon class for the box.
 * @param string $title     Title of the stat box.
 *
 * @return string Sanitized HTML output for the stat box.
 */
function escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title) {
    $label = ($count == 1) ? $sub : $sub_s;

    ob_start(); // Start output buffering
    ?>
    <div class="<?= esc_attr($col_class); ?>">
        <div class="card card-chart mb-2">
            <div class="card-header card-header-<?= esc_attr($color); ?> card-header-icon">
                <div class="card-icon escrot-rounded">
                    <i class="fas fa-<?= esc_attr($icon); ?>"></i>
                </div>
                <div class="text-end pt-1">
                    <p class="card-category text-right text-sm mb-0 text-capitalize">
                        <?= esc_html($title); ?>
                    </p>
                    <h4 class="text-right escrot-stats-text mb-4">
                        <?php if ($id === 'escrot-stat-total-balance') : ?>
                            <?= esc_html(escrot_option('currency')); ?>
                        <?php endif; ?>
                        <?= esc_html(escrot_minify_count($count)); ?>
                    </h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <p class="mb-0">
                    <span class="text-success text-sm font-weight-bolder">
                        <?= esc_html(escrot_minify_count($count)); ?>
                    </span>
                    <span class="text-light text-dark"><?= esc_html($label); ?></span>
                </p>
            </div>
        </div>
    </div>
    <?php
    return trim(ob_get_clean()); 
}


function escrot_merge_tags_table() {
    $columns = [
        ["Escrow Ref ID", "{ref-id}"],
        ["Escow Status", "{status}"],
        ["Escrow Earner", "{earner}"],
        ["Escrow Amount", "{amount}"],
        ["Escrow Payer", "{payer}"],
        ["Escrow Title", "{title}"],
        ["Escrow Details", "{details}"],
        ["Current Year", "{current-year}"],
        ["Website Title", "{site-title}"],
        ["Company Address", "{company-address}"],
    ];

    ob_start(); ?>

    <div id="EscrotMergeTags" class="text-gray">
        <span class="small">
            <?= __("Use the following merge tags in the form fields if necessary", "escrowtics"); ?>
        </span>
        <table class="table-responsive escrot-tbl">
            <tr class="escrot-tr">
                <?php foreach ($columns as $column): ?>
                    <th class="escrot-th escrot-th-sm">
                        <?= __( $column[0], "escrowtics" ); ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr class="escrot-tr">
                <?php foreach ($columns as $column): ?>
                    <td class="escrot-td">
                        <?= $column[1]; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>

    <?php
    return ob_get_clean();
}




//Ajax loader
function escrot_ajax_loader($text = ""){
	return '<div id="escrot-loader" style="display:none;">
				<span class="spinner-border text-success" id="progress"></span>
				<span id="SpinLoaderText" class="text-success">'.$text.'</span>
			</div>';
}
		
//General loader		
function escrot_loader($text = ""){
	return '<div class="text-center text-success">
				<span class="spinner-border"></span>
				<span>'.$text.'</span>
		   </div>';
}


//Get current url.
function escrot_current_url() {
	if ( isset( $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] ) ) {
		return set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . untrailingslashit( $_SERVER['REQUEST_URI'] ) );
	}
	return ''; 
}


/**
 * Get plugin countries list.
 *
 * @return array List of countries.
 */
function escrot_countries() {
    include_once ESCROT_PLUGIN_PATH . 'lib/countries.php';
    return $countries?? [];
}


//Get currency list
function escrot_currencies(){
   include ESCROT_PLUGIN_PATH."lib/currencies.php";
   return $currencies?? [];
}


/**
 * Get plugin timezones list.
 *
 * @return array List of timezones.
 */
function escrot_timezones() {
    include_once ESCROT_PLUGIN_PATH . 'lib/timezones.php';
    return $timezones?? [];
}

function escrot_light_svg(){
	return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';
}

//Display Collapsable contents
/**
 * Display collapsable dialog content cards.
 *
 * @param array $dialogs Array of dialog configurations.
 * @return string Sanitized HTML output for collapsable dialogs.
 */
function escrot_callapsable_dialogs(array $dialogs) {
    if (ESCROT_INTERACTION_MODE === 'modal') {
        return '';
    }
	
    foreach ($dialogs as $dialog) {
        $dialog_id = esc_attr($dialog['id']);
        $title = $dialog['title'];
        $data_id = !empty($dialog['data_id']) ? esc_attr($dialog['data_id']) : '';
        $type_class = isset($dialog['type']) && $dialog['type'] === 'data' ? 'p-5' : '';
        $header_path = !empty($dialog['header']) ? ESCROT_PLUGIN_PATH . "templates/admin/template-parts/" . sanitize_file_name($dialog['header']) : '';
        $callback_path = !empty($dialog['callback']) ? ESCROT_PLUGIN_PATH . "templates/forms/" . sanitize_file_name($dialog['callback']) : '';

        ?>
        <div class="card shadow-lg mb-3 escrot-admin-forms collapse" id="<?= $dialog_id; ?>">
            <div class="card-header">
                <h3 class="text-dark card-title text-center">
                    <?= $title; ?>
                    <?php if (!empty($header_path) && file_exists($header_path)) : ?>
                        <?php include $header_path; ?>
                    <?php endif; ?>
                </h3>
                <span class="float-right">
                    <button type="button" class="close escrot-close-btn text-light" data-toggle="collapse"
                            data-target="#<?= $dialog_id; ?>">
                        <span aria-hidden="true"><b>&times;</b></span>
                    </button>
                </span>
            </div>
            <div class="card-body <?= esc_attr($type_class); ?>">
                <div <?= !empty($data_id) ? 'id="' . $data_id . '"' : ''; ?>>
                    <?php if (!empty($callback_path) && file_exists($callback_path)) : ?>
                        <?php include $callback_path; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
	
}

	
/**
 * Generates an HTML table for export.
 *
 * @param array  $data       Data to populate the table rows.
 * @param array  $columns    Column headers and corresponding keys in the data array.
 * @param string $label      Label for the exported data.
 */
function escrot_excel_table($data, $columns, $label) {
	$output = '<table border="1"><tr style="font-weight:bold">';
	
	// Generate table headers
	foreach ($columns as $header => $key) {
		$output .= "<th>{$header}</th>";
	}
	$output .= '</tr>';
	
	// Generate table rows
	foreach ($data as $row) {
		$output .= '<tr>';
		foreach ($columns as $key) {
			$output .= '<td>' . esc_html($row[$key]) . '</td>';
		}
		$output .= '</tr>';
	}
	$output .= '</table>';
	
	if ( wp_doing_ajax() ) {
		wp_send_json(['data' => $output, 'label' => $label]);
	} else {
		return $output;
	}
	
	
}



