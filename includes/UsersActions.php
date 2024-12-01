<?php
/**
 * The Users manager class of the plugin.
 * Defines all Users Actions.
 * @since      1.0.0
 * @package    Escrowtics
 */
	
namespace Escrowtics; 

use Escrowtics\database\UsersConfig; 

defined('ABSPATH') or die();
	
class UsersActions extends UsersConfig {
		
		
	public function register() {
	
		//Register Hooks 
		add_action( 'wp_ajax_escrot_users', array($this, 'actionDisplayUsers' ));
		add_action( 'wp_ajax_escrot_users_tbl', array($this, 'actionReloadUsers' ));
		add_action( 'wp_ajax_escrot_user_profile', array($this, 'actionDisplayUserProfile' ));
		add_action( 'wp_ajax_escrot_insert_user', array($this, 'actionInsertUser' ));
		add_action( 'wp_ajax_escrot_update_user', array($this, 'actionUpdateUser' ));
		add_action( 'wp_ajax_escrot_user_data', array($this, 'actionGetUserByID' ));
		add_action( 'escrot_get_user_name', array($this, 'actionGetUserName' ));
		add_action( 'wp_ajax_escrot_del_user', array($this, 'actionDeleteUser' ));
		add_action( 'wp_ajax_escrot_del_users', array($this, 'actionDeleteUsers' ));
		add_action( 'wp_ajax_escrot_verify_useremail', array($this, 'actionVerifyUserEmail' ));
		add_action( 'wp_ajax_escrot_export_user_excel', array($this, 'exportToExcel' ));
		
	    //Frontend Hooks
		add_action( 'wp_ajax_nopriv_escrot_user_login', array($this, 'userlogin' ));
		add_action( 'wp_ajax_escrot_user_login', array($this, 'userlogin' ));
		add_action( 'wp_ajax_nopriv_escrot_user_signup', array($this, 'userSignup' ));
		add_action( 'wp_ajax_escrot_user_signup', array($this, 'userSignup' ));
		add_action( 'wp_ajax_escrot_user_logout', array($this, 'UserLogout' ));
		add_action( 'wp_ajax_escrot_change_user_pass', array($this, 'ChangeUserPass' ));
		add_action( 'wp_ajax_escrot_reload_user_account', array($this, 'reloadUserAccount' ));
		
		if(is_escrot_front_user()){
			add_filter( 'show_admin_bar', '__return_false');//Hide Admin Bar for front user
		}
	}	
	
	
	//Send Ajax Response
	public function sendResponse($response) {
		wp_send_json($response);
	}

		
	//Insert new user (Admin)	
	public function actionInsertUser() {	
		
		if(!check_ajax_referer( 'escrot_user_nonce', 'nonce' )) {
			wp_send_json(['status'=>'Error: Invalid nonce. Try reloading the page']); 
		}
		
		$form_data = ['username', 'password', 'firstname', 'lastname', 'email', 'phone', 'address', 'country', 'company',   
		              'website', 'bio', 'user_image'];
		$data = escrot_get_form_data($form_data);
		
		$wp_data = [
				'user_login'   => $data["username"],
				'user_pass'    => $data["password"],
				'user_email'   => $data["email"],
				'display_name' => $data["firstname"].' '.$data["lastname"],
				'role'         => 'escrowtics_user'
			];
	
		wp_insert_user( $wp_data );
		
		$data["creation_date"] = date("Y-m-d H:i:s");
		$data["balance"] = 0;
		$data["status"] = 0;
		unset ($data["password"]);
			
		$user = get_user_by('login', $data["username"]);
		$data["user_id"] = $user->ID;
		
		$this->insertUser($data);
		
		wp_send_json(['status'=>'success']);
  
	}


	//Display Users
	public function actionDisplayUsers() {	
		include_once ESCROT_PLUGIN_PATH."templates/admin/users/users.php";		
		wp_die();
	}
	
	
	//Reload Users
	public function actionReloadUsers() {
		include_once ESCROT_PLUGIN_PATH."templates/admin/users/users-table.php";	
		wp_die();
	}


	//Reload User Account (FrontEnd)
	public function reloadUserAccount() {	
		$user_id = get_current_user_id();	
		$user_data = $this->getUserByID($user_id);
		include ESCROT_PLUGIN_PATH."templates/forms/user-account-form.php";		
		wp_die();
	}
	
	
	//Display User Profile - Backend
	public function actionDisplayUserProfile() {	
		include_once ESCROT_PLUGIN_PATH."templates/admin/users/user-profile.php";		
		wp_die();
	}


	//Edit User Record (pull existing data into form) 
	public function actionGetUserByID() {	
	  if(isset($_POST['UserId'])) {
		$UserId = $_POST['UserId'];
		$row = $this->getUserByID($UserId);
		wp_send_json(['data' => $row]);
	  }
	}
	
	
	//Get User Name 
	public function actionGetUserName($id) {	
		$user = $this->getUserByID($id);
		return $user["firstname"].' '.$user["lastname"]; 
	}


	//Update User Account
	public function actionUpdateUser() {	
		
		if(!check_ajax_referer( 'escrot_user_nonce', 'nonce' )) {
			wp_send_json('Error: Invalid nonce. Try reloading the page'); 
		}
		
		$form_data = ['user_id','username', 'firstname', 'lastname', 'email', 'phone', 'address', 'country', 'company', 'website', 'bio', 'user_image'];
		
		$data = escrot_get_form_data($form_data);
		
		if(is_escrot_front_user()){
			$data["user_id"] = get_current_user_id(); 
			$data["user_image"] = escrot_uploader('file');
			if(empty($data["user_image"])) unset($data["user_image"]);
		}
		
		$wp_data = [
			'ID'           => $data["user_id"],
			'user_email'   => $data["email"],
			'display_name' => $data["firstname"].' '.$data["lastname"]
		];
		
		$wp_update = wp_update_user($wp_data);
		
		if ( is_wp_error( $wp_update ) ) {
			wp_send_json(['status' => $wp_update->get_error_message()]);
		}
	 
		$this->updateUser($data);
		
		wp_send_json_success(['message' => __('User Updated successfully', 'escrowtics')]);
 
	}


	//Deletet Record  
	public function actionDeleteUser() {			
	   if (isset($_POST['UserID'])) {
		  $UserID = $_POST['UserID'];
		  $this->deleteUser($UserID);
		  wp_die();
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
	public function actionVerifyUserEmail() {		
	   if(isset($_POST['UserEmail'])) {
		 $UserEmail = $_POST['UserEmail'];
		 $this->verifyUserEmail($UserEmail);
		 wp_die();
	   }
	}   


	//Export to excel
	public function exportToExcel() {	
		
		$exportData = $this->displayUsers();

		$output = '
		<table border="1">
			<tr style="font-weight:bold">
				<th>ID.</th>
				<th>Username</th>
				<th>Email</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Phone</th>
				<th>Company</th>
				<th>Website</th>
				<th>Country</th>
				<th>Address</th>
				<th>Bio</th>
				<th>User Image</th>
		    </tr>';
		foreach ($exportData as $export) {
		  $output .= '
		    <tr>
				<td>'.$export['user_id'].'</td>
				<td>'.$export['username'].'</td>
				<td>'.$export['email'].'</td>
				<td>'.$export['firstname'].'</td>
				<td>'.$export['lastname'].'</td>
				<td>'.$export['phone'].'</td>
				<td>'.$export['company'].'</td>
				<td>'.$export['website'].'</td>
				<td>'.$export['country'].'</td>
				<td>'.$export['address'].'</td>
				<td>'.$export['bio'].'</td>
				<td>'.$export['user_image'].'</td>
		    </tr>';
		}  
		$output .= '</table>';
		
		wp_send_json(['data'=>$output, 'lable' => 'users']);
	  
	}  
		
		
		
	/****************************************  Frontend Actions **************************************/
	

	//Redirect front users away from WP Admin
	public function redirectFromWPAdmin() {
		wp_safe_redirect(home_url(), 302);
		exit();
	}
	
	
	//Redirect front users away from WP Admin
	public function redirectFromWPLogin() {
		global $pagenow;
		if($pagenow == "wp-login.php"){
			wp_safe_redirect(home_url(), 302);
			exit();
		}
	}	
		
		
		
	public function userlogin() {
		// Bail early if there no nonce.
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json(['status' => __('Nonce is required', 'escrowtics')]);
		}

		try {
			if(!check_ajax_referer( 'escrot_sa_login_nonce', 'nonce' )) {
				wp_send_json(['status' => __('Invalid nonce. Try reloading the page', 'escrowtics')]);
			} 
			
			$data = escrot_get_form_data(['username','password','remember','redirect']);

			$credentials = array(
				'user_login'    => $data["username"],
				'user_password' => $data["password"],
				'remember'      => 'yes' === $data["remember"],
			);

			$validate = escrot_validate_form($data);

			if ( $validate->has_errors() ) {
				wp_send_json(['status' => $validate->get_error_message()]);
			}

			if ( is_email( $data["username"] ) ) {
				$user = get_user_by( 'email', $data["username"] );
				$credentials['user_login'] = $user->user_login;
				$error = ['status' => __('No User found with the given email address.', 'escrowtics')];
			} else {
				$user = get_user_by( 'login', $data["username"]);
				$error = ['status' => __('No User found with the given username.', 'escrowtics')];
			}	
			if (!$user) {
				wp_send_json($error);
			} else {
				if( !is_escrot_front_user($user->ID)) {
					wp_send_json($error);
				}
			}

			$user = wp_signon( $credentials, is_ssl() );

			if ( is_wp_error( $user ) ) {
				if ( 'incorrect_password' === $user->get_error_code() ) {
					wp_send_json(['status' => __('Incorrect password. Please try again.', 'escrowtics')]);
				}

				wp_send_json(['status' => $user->get_error_message()]);
			}
			
			$login_redirect = add_query_arg(['endpoint' => 'dashboard'], $data["redirect"]);//add dashboard endpoint
			
			wp_send_json(['status' => 'success', 
								 'message'  => __( 'Signed in successfully.', 'escrowtics' ),	
								 'redirect' => escrot_redirect_url($user, $login_redirect)
								]);
					
		} catch ( \Exception $e ) {
			wp_send_json(['status' => $e->getMessage()]);
		}
	}




	public function userSignup() {
		
		// Bail early if there no nonce.
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json(['status' => __('Nonce is required', 'escrowtics')]);
		}

		try {
			if(!check_ajax_referer( 'escrot_signup_nonce', 'nonce' )) {
				wp_send_json(['status' => __('Invalid nonce. Try reloading the page', 'escrowtics')]);
			}
			
			$form_data = ['firstname','lastname', 'username', 'email', 'password', 'confirm_password', 'redirect'];

			$data = escrot_get_form_data($form_data);
			
			$validate = escrot_validate_form( $data );

			if ( $validate->has_errors() ) {
				wp_send_json(['status' => $validate->get_error_message()]);
			}
			
			if ( email_exists( $data["email"] ) ) {
				//Filters error message for already existing email address while creating new user.
				$message = apply_filters( 'escrowtics_signup_error_email_exists', __( 'An account is already registered with your email address.', 'escrowtics' ), $email );
				wp_send_json(['status' => $message ]);
			}

			if ( username_exists( $data["username"] ) ) {
				wp_send_json(['status' => __( 'An account is already registered with that username. Please choose another.', 'escrowtics' )] );
			}
			
			$role  = "escrowtics_user";
		  
			$new_user = wp_insert_user(array(
					  'user_login'		=> $data["username"],
					  'user_pass'	 	=> $data["password"],
					  'user_email'		=> $data["email"],
					  'first_name'		=> $data["firstname"],
					  'last_name'	    => $data["lastname"],
					  'display_name'    => $data["firstname"].' '.$data["lastname"],
					  'user_registered'	=> date('Y-m-d H:i:s'),
					  'role'		    => $role
				  )
			  );
			  
			if ( is_wp_error( $new_user ) ) {
				wp_send_json(['status' => $new_user->get_error_message()]);
			}
			
			
			$user_data = escrot_get_form_data(['username', 'firstname', 'lastname', 'email', 'phone', 'address', 'country', 'company',   
		                                       'website', 'bio', 'user_image']);//Add Accessory User data
						
			$user_data["balance"] = 0;
			$user_data["user_id"] = get_user_by('email', $data["email"])->ID;
			
			$this->insertUser($user_data);
			
			
			escrot_notify_new_user($user_data["user_id"], $user_data["username"]);//Notify Admin
			
			escrot_new_user_email($user_data["username"]);//Email Amin
				
			wp_signon( [ 'user_login' => $data["username"], 'user_password' => $data["password"] ], is_ssl() );//Login New User
			
			$login_redirect = explode('?', $data["redirect"])[0];
			
			$login_redirect = add_query_arg(['endpoint' => 'dashboard'], $login_redirect);
		  
			wp_send_json(['status' => 'success', 
						  'message'  => __( "User created successfully.", 'escrowtics' ),	
						  'redirect' => escrot_redirect_url($new_user, $login_redirect)
						]);
		

		} catch ( \Exception $e ) {
			wp_send_json(['status' => $e->getMessage()]);
		}
		
	} 


	//Logout User.
	public function UserLogout() {
		wp_logout();
		wp_send_json(['status' => 'success']);
	} 
	
	
	//Update User Passwrod.
	public function ChangeUserPass() {
		
		
		if(!check_ajax_referer( 'escrot_user_pass_nonce', 'nonce' )) {
			wp_send_json('Error: Invalid nonce. Try reloading the page'); 
		}
		
		$form_data = ['old_password', 'password', 'confirm_password'];
		$data = escrot_get_form_data($form_data);
		
		
		$user_id = get_current_user_id();
		
		$user = get_user_by( 'ID', get_current_user_id() );
		
		if ( !wp_check_password( $data['old_password'], $user->data->user_pass, $user_id) ) {
			wp_send_json(['status' => __( 'Current password is wrong', 'escrowtics' )]);
		} 
	
		if ( $data['password'] !== $data['confirm_password'] ) {
			wp_send_json(['status' => __( 'Passwords do not match.', 'escrowtics' )]);
		} 
		
		$wp_data = [ 'ID' => $user_id, 'user_pass'=> $data["password"]];

		$wp_update = wp_update_user($wp_data);
		
		if ( is_wp_error( $wp_update ) ) {
			wp_send_json(['status' => $wp_update->get_error_message()]);
		}
		
		$this->UserLogout();
			
		
	} 		
   

}