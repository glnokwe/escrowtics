<?php

/**
* Core Plugin wide functions
* Provide helper functionalities
* @since      1.0.0
* @package    Escrowtics
*/

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

defined('ABSPATH') or die();

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

    $qrcode = (new QRCode($options))->render(esc_html($data));
    return sprintf('<img src="%s" alt="QR Code" width="%d" height="%d" />', esc_url($qrcode), intval($width), intval($height));
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
 * Handle file upload securely.
 *
 * @param string $file File input name.
 * @return string|WP_Error Uploaded file URL or error message.
 */
function escrot_uploader($file) {
    if (!empty($_FILES[$file]['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';

        $uploadedfile = $_FILES[$file];
        $upload_overrides = ['test_form' => false];

        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            return esc_url($movefile['url']);
        } else {
            return new WP_Error('upload_error', esc_html($movefile['error']));
        }
    }
    return new WP_Error('no_file', __('No file uploaded.', 'escrowtics'));
}


/**
 * Check if a user has the "escrowtics_user" role.
 *
 * @param int $user_id User ID.
 * @return bool True if the user has the role, false otherwise.
 */
function is_escrot_front_user($user_id = null) {
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
function escrot_get_form_data(array $fields) {
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

    if (empty($data['username'])) {
        $error->add('empty_username', __('Username is required.', 'escrowtics'));
    }
    if (empty($data['password'])) {
        $error->add('empty_password', __('Password is required.', 'escrowtics'));
    }
    if (!empty($_POST['form_type']) && $_POST['form_type'] === 'signup form') {
        if (empty($data['email']) || !is_email($data['email'])) {
            $error->add('invalid_email', __('Valid email is required.', 'escrowtics'));
        }
        if (empty($data['confirm_password']) || $data['password'] !== $data['confirm_password']) {
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

	
//Get User Data
function escrot_get_user_data($id) {
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}escrowtics_users WHERE user_id = %d";
    $row = $wpdb->get_row($wpdb->prepare($sql, intval($id)), ARRAY_A);
    return $row ? $row : [];
}


//Get Sinle User Data
function escrot_single_user_data($col, $row, $val) {
    global $wpdb;
    $allowed_columns = ['column1', 'column2']; // Replace with actual allowed column names
    if (!in_array($col, $allowed_columns)) {
        return null; // Prevent unauthorized column access
    }
    $sql = "SELECT $col FROM {$wpdb->prefix}escrowtics_users WHERE $row = %s";
    return $wpdb->get_var($wpdb->prepare($sql, sanitize_text_field($val)));
}


//Check if User Exist
function escrot_user_exist($username) {
	global $wpdb;
    $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}escrowtics_users WHERE username = %s";
    $rowCount = $wpdb->get_var($wpdb->prepare($sql, $username));
    if($rowCount == 1){
	   return true;
    } else {
	  return false; 
    }
}



//Get Escrow Data
function escrot_get_escrow_data($id) {
	global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}escrowtics_escrows WHERE escrow_id = %d";
    $row = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
    return $row[0];
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
	$output ='';
	$output .='
	  <div class="'.$col_class.'">
		<div class="card card-chart">
			<div class="card-header card-header-icon card-header-'.$color.'">
				<div class="card-icon">
				   <i class="fas fa-'.$icon.'"></i>
				</div>
				<h4 class="card-title mt-3 mb-2 ms-3"> '.__($title, "escrowtics").'';
				if(!empty($subtitle)){  $output .='<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$subtitle.'</small>'; }	
				$output .='
				</h4>
			</div>
			<div class="card-body p-3">';
				if($type == 'table'){
				   $output .='	
					<div id="'.$id.'">
						'.escrot_loader(__("Loading..", "escrowtics")).'
					</div>';
				}
				if($type == 'chart'){
					 if($count > 0) {
					   $output .='										 
						<div style="height: '.$box_ht.'" id="'.$id.'" class="ct-chart">
							'.escrot_loader(__("Loading..", "escrowtics")).'
						</div>';
					} else {  
						$output .='<h4 style="height: '.$box_ht.'" class="text-light text-center pt-5">'.__("Not enough data to draw chart", "escrowtics").'</h4>'; 
					}
				}
		  $output .='		
			</div>
		 </div>
	  </div>';
	  
	return trim($output);
}


//dsiplay chart and table stats
function escrot_tab_stat_chart_tbl($data) {
	$output ='';
	$output .='
	  <div class="'.$data["col_class"].'" id="'.$data["id"].'">
		<div class="card card-chart">
			<div class="card-header card-header-icon card-header-'.$data["color"].'">
				<div class="card-icon">
				   <i class="fas fa-'.$data["icon"].'"></i>
				</div>
				<h4 class="card-title mt-3 mb-2 ms-3"> '.$data["title"];
					if(!empty($data["subtitle"])){ $output .='<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data["subtitle"].'</small>'; }	
			$output .='
				</h4>
			</div>
			<div class="card-body p-3">
				<div class="col-xs-12" id="escrot-tabs">
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">';
						foreach($data["tabs"] as $title => $val){
							$active_class = $val["active"]? " show active" : "";
							$output .=' <a class="nav-item nav-link'.$active_class.'" data-toggle="tab" href="#'.$val["id"].'-tab" role="tab" aria-selected="'.$val["selected"].'">
							'.$val["title"].'</a>';
						}
						$output .='</div>
					</nav>
					<div class="tab-content py-3 px-3 px-sm-0">';
						foreach($data["tabs"] as $title => $val){
							$active_class = $val["active"]? " show active" : ""; 
							$output .='<div class="tab-pane fade'.$active_class.'" id="'.$val["id"].'-tab" role="tabpanel">';
							
								if($val["type"] == 'table'){
								   $output .='	
									<div id="'.$val["id"].'">
										'.escrot_loader(__("Loading..", "escrowtics")).'
									</div>';
								}
								if($val["type"] == 'chart'){
									 if($val["count"] > 0) { 
									   $output .='										 
										<div style="height: '.$data["box_ht"].'" id="'.$val["id"].'" class="ct-chart">
											'.escrot_loader(__("Loading..", "escrowtics")).'
										</div>';
									} else {  
										$output .='<h4 style="height: '.$data["box_ht"].'" class="text-light text-center pt-5">'.__("Not enough data to draw chart", "escrowtics").'</h4>'; 
									}
								}
							$output .='</div>';
						}
					$output .='
					</div>
				</div>
			</div>
		 </div>
	  </div>';
	  
	return trim($output);
}

//dsiplay box stats
function escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title) {
	$x = ($count == 1)?  $sub : $sub_s; 
	$output ='';
	$output .='
	  <div class="'.$col_class.'">
		 <div class="card card-chart mb-2">
				<div class="card-header card-header-'.$color.' card-header-icon">
					<div class="card-icon escrot-rounded">
					  <i class="fas fa-'.$icon.'"></i>
					</div>
				<div class="text-end pt-1">
					<p class="card-category text-right text-sm mb-0 text-capitalize">
						'.$title.'
					</p>
					<h4 class="text-right escrot-stats-text mb-4">';
					
					if($id == "escrot-stat-total-balance"){ $output .= ESCROT_CURRENCY.' '; }
					$output .= escrot_minify_count($count).'
			         </h4>
				</div>
			</div>
			<hr class="dark horizontal my-0">
			<div class="card-footer p-3">
				<p class="mb-0"><span class="text-success text-sm font-weight-bolder">
					'.escrot_minify_count($count).'</span> <span class="text-light text-dark">'.$x.'</span>	
				</p>						  
			</div>
		</div>	
	  </div>';
	  
	return trim($output);
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


//Get current users list
function escrot_users(){
	global $wpdb; 
	$sql = "SELECT * FROM {$wpdb->prefix}escrowtics_users ORDER BY user_id DESC";
	$rows = $wpdb->get_results($sql, ARRAY_A);
	$Users = [];
	foreach($rows as $row){
		$Users[$row["username"]] = $row["username"];
	};
	return $Users;
}

//Get current wordpress users list
function escrot_wp_users(){
	$users = get_users();
	$data = [];
	foreach ( $users as $user ) {
		$data[$user->user_login] = $user->user_login;
	}
	return $data;
}

//Get current wordpress pages list
function escrot_wp_pages(){
	 $pages = get_pages(); 
	 $data = [];
	foreach ( $pages as $page ) {
		$data[$page->ID] = $page->post_title;
	}
	return $data;
}


/**
 * Get plugin countries list.
 *
 * @return array List of countries.
 */
function escrot_countries() {
    include_once ESCROT_PLUGIN_PATH . 'lib/countries.php';
    return $countries;
}


//Get currency list
function escrot_currencies(){
   include ESCROT_PLUGIN_PATH."lib/currencies.php";
   return $currencies;
}


/**
 * Get plugin timezones list.
 *
 * @return array List of timezones.
 */
function escrot_timezones() {
    include_once ESCROT_PLUGIN_PATH . 'lib/timezones.php';
    return $timezones;
}

function escrot_light_svg(){
	return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';
}

//Display Collapsable contents
function escrot_callapsable_dialogs(array $dialogs){

    if(ESCROT_PLUGIN_INTERACTION_MODE !== "modal") {  
	
	    foreach($dialogs as $dialog){ ?>     
  
			<div class="card shadow-lg mb-3 escrot-admin-forms collapse" id="<?php echo $dialog['id'] ?>">
			  <div class='card-header'>
				<h3 class='text-light card-title text-center'>
				   <?php 
					 echo $dialog['title']; 
					 if(!empty($dialog['header'])){
						include ESCROT_PLUGIN_PATH."templates/admin/template-parts/".$dialog['header']; 
					}
				   ?>
				</h3>
				<span class="float-right">
				   <button type="button" class="close escrot-close-btn text-light" data-toggle="collapse" 
				   data-target="#<?php echo $dialog['id']; ?>">
					  <span aria-hidden="true"><b>&times;</b></span>
				   </button>
				</span>
			</div>
			<div class="card-body <?= $dialog['type']== 'data'? 'p-5' : ''; ?>">
			  <div <?php if(!empty($dialog['data_id'])){ echo 'id="'.$dialog["data_id"].'"'; } ?>>
				<?php 
					if(!empty($dialog['callback'])){
						include ESCROT_PLUGIN_PATH."templates/forms/".$dialog['callback']; 
					}
				?>
			  </div>
			 </div>
			</div>
			
<?php } } } ?>
