<?php
/**
 * The Users manager class of the plugin.
 * Defines all Users Actions.

 * @since      1.0.0
 * @package    Escrowtics
 */
	
namespace Escrowtics; 

use Escrowtics\Database\UsersDBManager; 

defined('ABSPATH') || exit;
	
class UsersActions extends UsersDBManager {
		
		
	  public function register() {
        $ajax_actions = [
            'escrot_users' => 'actionDisplayUsers',
            'escrot_users_tbl' => 'actionReloadUsers',
            'escrot_user_profile' => 'actionDisplayUserProfile',
            'escrot_insert_user' => 'actionInsertUser',
            'escrot_update_user' => 'actionUpdateUser',
            'escrot_user_data' => 'actionGetUserById',
            'escrot_del_user' => 'actionDeleteUser',
            'escrot_del_users' => 'actionDeleteUsers',
            'escrot_verify_user' => 'actionVerifyUser',
            'escrot_export_user_excel' => 'exportUsersToExcel',
            'escrot_reload_user_escrow_tbl' => 'actionReloadUserEscrows',
            'escrot_reload_user_earnings_tbl' => 'actionReloadUserEarnings',
            'escrot_user_login' => 'userLogin',
            'escrot_user_signup' => 'userSignup',
            'escrot_user_logout' => 'userLogout',
            'escrot_change_user_pass' => 'changeUserPass',
            'escrot_reload_user_account' => 'reloadUserAccount',
        ];

        foreach ($ajax_actions as $action => $method) {
            add_action("wp_ajax_$action", [$this, $method]);
            add_action("wp_ajax_nopriv_$action", [$this, $method]);
        }

        // Disable admin bar for non-admin users
        add_filter('show_admin_bar', function($show) {
			if (escrot_is_front_user()) {
				return false;
			}
			return $show;
		});
    }

		
		
	//Insert new user (Admin)	
	public function actionInsertUser() {
		
		escrot_verify_permissions('manage_options');//Admin permission
		escrot_validate_ajax_nonce('escrot_user_nonce', 'nonce');
		
		//User Data
		$user_data = ['user_login', 'user_pass', 'first_name', 'last_name', 'user_email', 'user_url'];
		$user_data = escrot_sanitize_form_data($user_data);
		$user_data['display_name'] = $user_data["first_name"].' '.$user_data["last_name"];
		$user_data['role'] = 'escrowtics_user';
		
		// Ensure email and username do not already exist.
		if ( email_exists( $user_data['user_email'] ) ) {
			wp_send_json_error([
				'message' => __( 'An account is already registered with this email address.', 'escrowtics' ),
			]);
		}

		if ( username_exists( $user_data['user_login'] ) ) {
			wp_send_json_error([
				'message' => __( 'An account is already registered with that username. Please choose another.', 'escrowtics' ),
			]);
		}
		
		//User Meta Data
		$meta_data = ['phone', 'address', 'country', 'company', 'bio', 'user_image', 'status'];
		$meta_data = escrot_sanitize_form_data($meta_data);
		$meta_data["balance"] = 0; //define default user balance
		
		$this->insertUser($user_data, $meta_data);
		
		wp_send_json_success(['message'=>__('User Added successfully', 'escrowtics')]);
  
	}


	/**
	 *Display Users
	 */
	public function actionDisplayUsers() {	
	    ob_start();
		include_once ESCROT_PLUGIN_PATH."templates/admin/users/users.php";		
		wp_send_json(['data' => ob_get_clean()]);
	}
	
	 /**
     * Reloads the current user's account form(Frontend)
     */
    public function reloadUserAccount() {
        $user_id = get_current_user_id();
        $user_data = $this->getUserById($user_id);

        ob_start();
        include ESCROT_PLUGIN_PATH . 'templates/forms/user-account-form.php';
        wp_send_json(['data' => ob_get_clean()]);
    }
	
	 /**
     * Reloads the user table (Admin)
     */
    public function actionReloadUsers() {
        ob_start();
        include_once ESCROT_PLUGIN_PATH . 'templates/admin/users/users-table.php';
        wp_send_json(['data' => ob_get_clean()]);
    }


	/**
	 *Reload User Escrow Table (Admin)
	 */
	public function actionReloadUserEscrows() {
		if(isset($_POST['user_id'])){
			$user_id = $_POST['user_id'];	
			$username = get_user_by( 'ID', $user_id)->user_login;
			$data_count = $this->getUserEscrowsCount($username);
			
			ob_start();
			include ESCROT_PLUGIN_PATH."templates/escrows/escrows-table.php";
			wp_send_json(['data' => ob_get_clean()]);
		}
	}
	
	
	/**
	 *Reload User Earnings Table (Admin)
	 */
	public function actionReloadUserEarnings() {
		if(isset($_POST['user_id'])){
			$user_id = $_POST['user_id'];	
			$username = get_user_by( 'ID', $user_id)->user_login;
			$data_count = $this->getUserEarningsCount($username);
			ob_start();
			include ESCROT_PLUGIN_PATH."templates/escrows/earnings-table.php"; 
			wp_send_json(['data' => ob_get_clean()]);
		}
	}
	
	
	//Display User Profile - Backend
	public function actionDisplayUserProfile() {
        ob_start();		
		include_once ESCROT_PLUGIN_PATH."templates/admin/users/user-profile.php";
		wp_send_json(['data' => ob_get_clean()]);
	}


	//Edit User Record (pull existing data into form) 
	public function actionGetUserById() {	
	  escrot_verify_permissions('manage_options');
	  if(isset($_POST['UserId'])) {
		$user_id = $_POST['UserId'];
		$row = $this->getUserById($user_id);
		wp_send_json(['data' => $row]);
	  }
	}
	
	
	//Get User Name 
	public function actionGetUserName($id) {	
		$user = $this->getUserById($id);
		return $user["firstname"].' '.$user["lastname"]; 
	}


	//Update User Account
	public function actionUpdateUser() {	
		if(!escrot_is_front_user()){ escrot_verify_permissions('manage_options'); }
		escrot_validate_ajax_nonce('escrot_user_nonce', 'nonce');
		
		//User Data
		$user_data = ['ID', 'first_name','last_name', 'user_email', 'user_url'];
		
		$user_data = escrot_sanitize_form_data($user_data);
		$user_id = $user_data["ID"];
		
		//User Meta Data
		$meta_data = ['phone', 'address', 'country', 'company', 'bio', 'user_image', 'status'];
		$meta_data = escrot_sanitize_form_data($meta_data);
		
		if(escrot_is_front_user()){
			$user_id = get_current_user_id(); 
			$meta_data["user_image"] = escrot_uploader('file');
			if(empty($meta_data["user_image"])) unset($meta_data["user_image"]);
		} 
		
		$user_data = [
			'user_url'     => $user_data["user_url"],
			'user_email'   => $user_data["user_email"],
			'first_name'   => $user_data["first_name"],
			'last_name'    => $user_data["last_name"],
			'display_name' => $user_data["first_name"].' '.$user_data["last_name"]
			
		];
	 
		$result = $this->updateUser($user_id, $user_data, $meta_data);
		
		if (is_wp_error($result)) {
			wp_send_json_error(['message' => $result->get_error_message()]);
		} else {
			wp_send_json_success(['message' => __('User Updated successfully', 'escrowtics')]);
		}
		
	}


	//Deletet Record  
	public function actionDeleteUser() {			
	   if (isset($_POST['UserID'])) {
		  $UserID = $_POST['UserID'];
		  $this->deleteUser($UserID);
		  wp_send_json_success(['message' => __('User deleted successfully', 'escrowtics')]);
	   }
	}   

	//Deletet Multiple Records  
	public function actionDeleteUsers() {		
	   if (isset($_POST['multUserid'])) {
		  $multUserid = $_POST['multUserid'];
		  $this->deleteUsers($multUserid);
		  wp_die();
	   }
	}   

	// Verify User Email
	public function actionVerifyUser() {		
	   if(isset($_POST['user_field'])) {
		 $field = $_POST['user_field'];
		 $this->verifyUser($field);
		 wp_die();
	   }
	}   
	
	
	/**
	 * Export Users to Excel
	 */
	public function exportUsersToExcel() {
		$data = $this->getAllUsers();
		$columns = [
			'ID.' => 'ID',
			'Username' => 'user_login',
			'Email' => 'user_email',
			'First Name' => 'first_name',
			'Last Name' => 'last_name',
			'Phone' => 'phone',
			'Company' => 'company',
			'Website' => 'website',
			'Country' => 'country',
			'Address' => 'address',
			'Bio' => 'bio',
			'User Image' => 'user_image',
			'Date' => 'user_registered'
		];
		escrot_excel_table($data, $columns, 'users');
	}

	

	/**
	 *Redirect front users away from WP Admin
	 */
	public function redirectFromWPAdmin() {
		wp_safe_redirect(home_url(), 302);
		exit();
	}
	
	/**
	 *Redirect front users away from WP Admin
	 */
	public function redirectFromWPLogin() {
		global $pagenow;
		if($pagenow == "wp-login.php"){
			wp_safe_redirect(home_url(), 302);
			exit();
		}
	}	
	
	
	/**
	 * Handle user login via AJAX.
	 *
	 * This method processes the AJAX login request, validates input, authenticates the user,
	 * and returns a JSON response with the login status and optional redirect URL.
	 *
	 * @return void
	 */
	public function userlogin() {
		// Bail early if there is no nonce in the request.
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error(['message' => __( 'Nonce is required.', 'escrowtics' )]);
		}

		try {
			// Verify the nonce.
			escrot_validate_ajax_nonce('escrot_user_login_nonce', 'nonce');

			// Sanitize and validate input fields.
			$user_data = escrot_sanitize_form_data( [ 'user_login', 'user_pass', 'remember', 'redirect' ] );
			$validate = escrot_validate_form( $user_data );

			if ( $validate->has_errors() ) {
				wp_send_json_error(['message' => $validate->get_error_message()]);
			}

			// Prepare login credentials.
			$credentials = [
				'user_login'    => $user_data['user_login'],
				'user_password' => $user_data['user_pass'],
				'remember'      => 'yes' === $user_data['remember'],
			];

			// Check if the username is an email, and resolve the actual username if it exists.
			if ( is_email( $user_data['user_login'] ) ) {
				$user = get_user_by( 'user_email', $user_data['user_login'] );
				if ( ! $user ) {
					wp_send_json_error(['message' => __( 'No user found with the given email address.', 'escrowtics' )]);
				}
				$credentials['user_login'] = $user->user_login;
			} else {
				$user = get_user_by( 'login', $user_data['user_login'] );
				if ( ! $user ) {
					wp_send_json_error(['message' => __( 'No user found with the given username.', 'escrowtics' )]);
				}
			}

			// Ensure the user has the appropriate role or capability.
			if ( ! escrot_is_front_user( $user->ID ) ) {
				wp_send_json_error(['message' => __( 'You are not authorized to log in using this account.', 'escrowtics' )]);
			}

			// Attempt to sign the user in.
			$user = wp_signon( $credentials, is_ssl() );

			if ( is_wp_error( $user ) ) {
				if ( 'incorrect_password' === $user->get_error_code() ) {
					wp_send_json_error(['message' => __( 'Incorrect password. Please try again.', 'escrowtics' )]);
				}

				wp_send_json_error(['message' => $user->get_error_message()]);
			}

			// Generate the login redirect URL.
			$login_redirect = add_query_arg(
				[ 'endpoint' => 'dashboard' ],
				! empty( $user_data['redirect'] ) ? $user_data['redirect'] : home_url()
			);

			// Send success response.
			wp_send_json_success([
				'message'  => __( 'Signed in successfully.', 'escrowtics' ),
				'redirect' => escrot_redirect_url( $user, $login_redirect ),
			]);

		} catch ( Exception $e ) {
			wp_send_json_error(['message' => $e->getMessage()]);
		}
	}

	
	
	
	/**
	 * Handle user signup via AJAX.
	 *
	 * This method processes the AJAX signup request, validates input, registers a new user,
	 * and returns a JSON response with the signup status and optional redirect URL.
	 *
	 * @return void
	 */
	public function userSignup() {
		// Bail early if there is no nonce in the request.
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error([
				'status'  => 'error',
				'message' => __( 'Nonce is required.', 'escrowtics' ),
			]);
		}

		try {
			
			// Verify the nonce.
			escrot_validate_ajax_nonce('escrot_signup_nonce', 'nonce');

			// Sanitize and validate input fields.
			$user_data = ['user_login', 'first_name', 'last_name', 'user_email', 'user_pass', 'confirm_pass', 'user_url', 'redirect'];
			$user_data = escrot_sanitize_form_data( $user_data);

			$user_data['display_name'] = trim( $user_data['first_name'] . ' ' . $user_data['last_name'] );
			$user_data['role']         = 'escrowtics_user';

			$validate = escrot_validate_form( $user_data );

			if ( $validate->has_errors() ) {
				wp_send_json_error([
					'status'  => 'error',
					'message' => $validate->get_error_message(),
				]);
			}
			
			$redirect = $user_data["redirect"];//keep redirect url, will be removed prior to adding user

			// Ensure email and username do not already exist.
			if ( email_exists( $user_data['user_email'] ) ) {
				wp_send_json_error([
					'message' => __( 'An account is already registered with this email address.', 'escrowtics' ),
				]);
			}

			if ( username_exists( $user_data['user_login'] ) ) {
				wp_send_json_error([
					'message' => __( 'An account is already registered with that username. Please choose another.', 'escrowtics' ),
				]);
			}

			// Remove unnecessary fields before inserting the user.
			unset( $user_data['confirm_pass'], $user_data['redirect'] );

			// Insert the user and validate the result.
			$new_user_id = wp_insert_user( $user_data );

			if ( is_wp_error( $new_user_id ) ) {
				wp_send_json_error(['message' => $new_user_id->get_error_message()]);
			}

			// Prepare and update user meta data.
			$meta_data = escrot_sanitize_form_data( ['phone', 'address', 'country', 'company', 'bio', 'user_image'] );
			$meta_data['status'] = 0;
			$meta_data['balance'] = 0;
			foreach ( $meta_data as $key => $value ) {
				update_user_meta( $new_user_id, $key, $value );
			}

			// Send notifications and email alerts.
			escrot_notify_new_user( $new_user_id, $user_data['user_login'] );
			escrot_new_user_email( $user_data['user_email'] ); 

			// Automatically log in the new user.
			wp_signon(
				[
					'user_login'    => $user_data['user_login'],
					'user_password' => $user_data['user_pass'],
				],
				is_ssl()
			);

			// Generate the redirect URL.
			$login_redirect = ! empty( $redirect ) ? $redirect : home_url();
			$login_redirect = add_query_arg( [ 'endpoint' => 'dashboard' ], explode( '?', $login_redirect )[0] );

			// Send success response.
			wp_send_json_success([
				'message'  => __( 'User Account created successfully.', 'escrowtics' ),
				'redirect' => escrot_redirect_url( get_userdata( $new_user_id ), $login_redirect ),
			]);

		} catch ( Exception $e ) {
			wp_send_json_error(['message' => $e->getMessage()]);
		}
	}
	


	/**
     * Logs the current user
     */
	public function UserLogout() {
		wp_logout();
		wp_send_json_success(['message' => 'Successfully signed out']);
	} 
	
	
	/**
	 *Update User Passwrod.
	 */
	public function ChangeUserPass() {
		
		// Bail early if there is no nonce in the request.
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error([
				'status'  => 'error',
				'message' => __( 'Nonce is required.', 'escrowtics' ),
			]);
		}
		
		//Verify Nounce
		escrot_validate_ajax_nonce('escrot_user_pass_nonce', 'nonce');
		
		$form_data = ['old_pass', 'user_pass', 'confirm_pass'];
		$data = escrot_sanitize_form_data($form_data);
		
		
		$user_id = get_current_user_id();
		
		$user = get_user_by( 'ID', get_current_user_id() );
		
		if ( !wp_check_password( $data['old_pass'], $user->data->user_pass, $user_id) ) {
			wp_send_json_error(['message' => __( 'Current password is wrong', 'escrowtics' )]);
		} 
	
		if ( $data['user_pass'] !== $data['confirm_pass'] ) {
			wp_send_json_error(['message' => __( 'Passwords do not match.', 'escrowtics' )]);
		} 
		
		$user_data = [ 
			'ID' => $user_id, 
			'user_pass'=> $data["user_pass"]
		];

		$user_update = wp_update_user($user_data);
		
		if ( is_wp_error( $user_update ) ) {
			wp_send_json_error(['message' => $wp_update->get_error_message()]);
		}
		
		wp_logout();
		
		wp_send_json_success(['message' => __('Password updated successfully', 'escrowtics')]);
			
		
	} 		
   

}