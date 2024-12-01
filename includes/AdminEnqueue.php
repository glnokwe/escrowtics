<?php

/**
 * The admin-specific styles and scripts.
 * @since      1.0.0
 * @package    Escrowtics
 */
 
    namespace Escrowtics;
	
	defined('ABSPATH') or die();
 
    class AdminEnqueue {

	
	    public function register() {
		
            //Register hooks 
	        add_action( 'admin_enqueue_scripts', array($this, 'escrotAdminStyles' ));
	        add_action( 'admin_enqueue_scripts', array($this, 'escrotAdminScripts'));
		
	    }
	
	
	    //Check if current url is a Escrowtics page
	    public function escrotPage($page) {
		    if (isset($_GET['page'])) {
		  
		        $urlArray = explode('-', $_GET['page']);
		        if ( in_array($page, $urlArray) ) { return true; } else { return false; }
		
	        } 
	    }
		
	
	    //Check if current url is a unique Escrowtics page
	    public function uniqueEscrotPage($page) {
		    if (isset($_GET['page']) && $page == $_GET['page']) {
		        return true; 
	        }  else { 
		        return false;
		    }
	    }
		
		//Load inline & custom css.
		public static function escrotInlineAdminCss() {

			// Bail early if top menu is not being used.
			if(ESCROT_ADMIN_NAV_STYLE == 'sidebar' ){ return;}
			
			//Top nav css
			$inline_css = "
				@media (min-width: 991px){ .main-panel { width: 100% !important;} }
				@media screen and (min-width: 1080px) { .escrot-tbl-action-btn { margin: -6% 0 0 25%; } }
				@media screen and (min-width: 1280px) { .escrot-tbl-action-btn { margin: -4% 0 0 18% } }
				@media screen and (min-width: 1440px) { .escrot-tbl-action-btn {margin: -3.5% 0 0 15%; } } 
				.main-panel > .content { margin-top: 10px; }
				.dark-edition .escrot-top-nav-item :hover {color: #fff !important;}
				.navbar.bg-dark .escrot-top-nav-item .active {color: #7b1fa2 !important; border: 1px solid  #7b1fa2;!important; margin-left: 0px !important; border-radius: 0px !important; }
				.navbar.bg-dark .escrot-top-nav-item .active .fa {color: #7b1fa2 !important;}
				.dark-edition .navbar.bg-dark .escrot-top-nav-item .active {background-color:#223663; color: #fff !important; border: 1px solid #fff; !important;}
				.dark-edition .navbar.bg-dark .escrot-top-nav-item .active .fa {color: #fff !important;}
				.escrot-top-nav{width: 98%; margin-left: auto; margin-right: auto; }
				 #screen-options-wrap { width: 100% !important; }
				 .navbar .collapse .navbar-nav .nav-item .nav-link { font-size: .69rem; }
				 .footer { left: -1%; };";
			 
			wp_add_inline_style( 'escrot-admin-css', $inline_css );
		}
	

	    //Register the stylesheets for the admin area.
	    public function escrotAdminStyles() {
		    //Check page
            if ( $this->escrotPage('escrowtics') ){
		        wp_enqueue_style('escrot-mdb', ESCROT_PLUGIN_URL.'lib/bootstrap/css/m-dash.min.css', array(), ESCROT_VERSION, 'all');
				wp_enqueue_style('escrot-btchcss', ESCROT_PLUGIN_URL.'lib/bootstrap/css/choices.min.css', array(), ESCROT_VERSION, 'all');
				wp_enqueue_style('escrot-bbl-chat', ESCROT_PLUGIN_URL.'lib/bootstrap/css/bubble-chat.css', array(), ESCROT_VERSION, 'all');
		        wp_enqueue_style('escrot-fa-icons', ESCROT_PLUGIN_URL.'lib/fontawesome/css/all.min.css', array(), ESCROT_VERSION, 'all');
				wp_enqueue_style('escrot-dt-css', ESCROT_PLUGIN_URL.'lib/jquery/css/jquery.dataTables.min.css', array(), ESCROT_VERSION, 'all' );
		        wp_enqueue_style('escrot-admin-css', ESCROT_PLUGIN_URL.'assets/css/escrot-admin.css', array(), ESCROT_VERSION, 'all' );
				$this->escrotInlineAdminCss();
	        }
	        wp_enqueue_style('escrot-wp-css', ESCROT_PLUGIN_URL.'assets/css/escrot-wp-admin-styles.css', array(), ESCROT_VERSION, 'all');
	    }
	
	
	

        //Register the JavaScript for the admin area.
	    public function escrotAdminScripts() {
        
		    //Check page
            if ( $this->escrotPage('escrowtics') ) {
				
				if (defined('ESCROT_FOLD_WP_MENU') && ESCROT_FOLD_WP_MENU) {
					$wpfold = true;
				} else {
					$wpfold = false;
				}

				$params = array('ajaxurl' => admin_url('admin-ajax.php'), 
								'is_front_user' => is_escrot_front_user()? 'true' : 'false',
								'light_svg' => escrot_light_svg(),
								'rest_api_data' => ESCROT_REST_API_DATA,
								'wpfold' => $wpfold
								);	
                wp_enqueue_script('jquery');
			    wp_enqueue_script('jquery-form');
			    wp_enqueue_script('media-upload');
			    wp_enqueue_media();
			    wp_enqueue_script('escrot-admin-popper', ESCROT_PLUGIN_URL.'lib/jquery/js/popper.min.js', ESCROT_VERSION, false );
		        wp_enqueue_script('escrot-admin-btjs', ESCROT_PLUGIN_URL.'lib/bootstrap/js/m-design.min.js', ESCROT_VERSION, false );
				wp_enqueue_script('escrot-admin-btchjs', ESCROT_PLUGIN_URL.'lib/bootstrap/js/choices.min.js', ESCROT_VERSION, false );
				wp_enqueue_script('escrot-escrow-js', ESCROT_PLUGIN_URL.'assets/js/escrow-script.js', ESCROT_VERSION, false );
				
			    if ( $this->uniqueEscrotPage('escrowtics-users') || $this->uniqueEscrotPage('escrowtics-user-profile')) {
		           wp_enqueue_script('escrot-user-js', ESCROT_PLUGIN_URL.'assets/js/users-script.js', ESCROT_VERSION, false );
			    }
				
				if ( $this->uniqueEscrotPage('escrowtics-support-tickets') || $this->uniqueEscrotPage('escrowtics-view-ticket')) {
		           wp_enqueue_script('escrot-sup-js', ESCROT_PLUGIN_URL.'assets/js/support-script.js', ESCROT_VERSION, false );
			    }
			    
			    if ( $this->uniqueEscrotPage('escrowtics-db-backups')) {
		           wp_enqueue_script('escrot-db-backup-js', ESCROT_PLUGIN_URL.'assets/js/db-backup-script.js', ESCROT_VERSION, false );
			    }
			    if ( $this->uniqueEscrotPage('escrowtics-dashboard') || $this->uniqueEscrotPage('escrowtics-stats') || $this->uniqueEscrotPage('escrowtics-user-profile')) {
		           wp_enqueue_script('canvas-js', ESCROT_PLUGIN_URL.'lib/jquery/js/canvasjs.min.js', ESCROT_VERSION, false );
			    }
                if ( !$this->uniqueEscrotPage('escrowtics-dashboard') ) {
		           wp_enqueue_script('escrot-dt-js', ESCROT_PLUGIN_URL.'lib/jquery/js/jquery.dataTables.min.js', ESCROT_VERSION, false );
			    }
		        wp_enqueue_script('escrot-admin-swal', ESCROT_PLUGIN_URL.'lib/jquery/js/sweetalert2.min.js', ESCROT_VERSION, false );
			    wp_enqueue_script('escrot-js-pdf', ESCROT_PLUGIN_URL.'lib/download-pdf/jspdf.min.js', ESCROT_VERSION, false );
			    wp_enqueue_script('escrot-html-canvas', ESCROT_PLUGIN_URL.'lib/download-pdf/html2canvas.min.js', ESCROT_VERSION, false );
			    wp_enqueue_script('escrot-noty-js', ESCROT_PLUGIN_URL.'assets/js/notification-script.js', ESCROT_VERSION, false );
			    wp_enqueue_script('escrot-sett-js', ESCROT_PLUGIN_URL.'assets/js/settings-script.js', ESCROT_VERSION, false );
			    wp_enqueue_script('escrot-jasny', ESCROT_PLUGIN_URL.'lib/bootstrap/js/jasny-bootstrap.min.js', ESCROT_VERSION, false );
				wp_enqueue_script('escrot-wiz', ESCROT_PLUGIN_URL.'lib/bootstrap/js/jquery.bootstrap-wizard.js', ESCROT_VERSION, false );
				wp_enqueue_script('escrot-bs-cp-js', ESCROT_PLUGIN_URL.'lib/bootstrap/js/bootstrap-colorpicker.min.js', ESCROT_VERSION, false );
				wp_enqueue_script('escrot-general-admin-js', ESCROT_PLUGIN_URL.'assets/js/escrot-admin.js', ESCROT_VERSION, false );
				
				wp_localize_script('escrot-general-admin-js', "escrot", $params);
				
			}
		
	   }
	
   }
	
	
	
	
