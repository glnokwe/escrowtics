<?php

/**
 * Enqueues all The public-facing scripts of the plugin.
 * @since      1.0.0
 * @package    Escrowtics
 */
 
	namespace Escrowtics;
	
    defined('ABSPATH') or die();

	class PublicEnqueue {
		 
		//Register all frontend hooks  
		public function register() {
			add_action( 'wp_enqueue_scripts', array($this, 'enqueue_styles' ));
	        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'));
			add_action( 'wp_enqueue_scripts', array($this, 'dequeue_style'), 11);
		}

		//Register frontend stylesheets
		public function enqueue_styles() {
			wp_enqueue_style('escrot-mdpub', ESCROT_PLUGIN_URL.'lib/bootstrap/css/m-design.min.css', array(), ESCROT_VERSION, 'all');
			wp_enqueue_style('escrot-pub-dt', ESCROT_PLUGIN_URL.'lib/jquery/css/jquery.dataTables.min.css', array(), ESCROT_VERSION, 'all' );
			wp_enqueue_style('escrot-bbl-chat-pub', ESCROT_PLUGIN_URL.'lib/bootstrap/css/bubble-chat.css', array(), ESCROT_VERSION, 'all');
			wp_enqueue_style('fontawesome-icons', ESCROT_PLUGIN_URL.'lib/fontawesome/css/all.min.css', array(), ESCROT_VERSION, 'all');
			wp_enqueue_style('escrot-pub-css', ESCROT_PLUGIN_URL.'assets/css/escrot-public.css', array(), ESCROT_VERSION, 'all' );
			
			$this->escrotCustomCss();
		}
		
		
		public static function escrotCustomCss() {
			
			//custom colours css
			$custom_colours = "
				:root {
					--escrot-primary-color: ".ESCROT_PRIMARY_COLOR.";
					--escrot-secondary-color: ".ESCROT_SECONDARY_COLOR.";
					--escrot-font-family: inherit, jost, Roboto, Helvetica, Arial, tahoma;
				}";
				
			$custom_css = "";	
				
			if(is_user_logged_in())	{
    			$custom_css = "@media only screen and (max-width: 600px){ .escrot-logged-out{ display: none !important; } }";
			} else {
			    $custom_css = "@media only screen and (max-width: 600px){ .escrot-logged-in{ display: none !important; } }";
			}
			wp_add_inline_style( 'escrot-pub-css', $custom_colours.$custom_css.ESCROT_CUSTOM_CSS );
		}
		

		//Register frontend JavaScripts
		public function enqueue_scripts() {
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-form');
			wp_enqueue_script('escrot-popper-pup', ESCROT_PLUGIN_URL.'lib/jquery/js/popper.min.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-pub-bt-js', ESCROT_PLUGIN_URL.'lib/bootstrap/js/m-design.min.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-pub-dt', ESCROT_PLUGIN_URL.'lib/jquery/js/jquery.dataTables.min.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-swal-js', ESCROT_PLUGIN_URL.'lib/jquery/js/sweetalert2.min.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-jny-pub', ESCROT_PLUGIN_URL.'lib/bootstrap/js/jasny-bootstrap.min.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-pub-wiz', ESCROT_PLUGIN_URL.'lib/bootstrap/js/jquery.bootstrap-wizard.js', ESCROT_VERSION, false );
			
			wp_enqueue_script('escrot-escrow-pub-js', ESCROT_PLUGIN_URL.'assets/js/escrow-script.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-pub-user-js', ESCROT_PLUGIN_URL.'assets/js/users-script.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-general-public-js', ESCROT_PLUGIN_URL.'assets/js/escrot-public.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-pub-noty-js', ESCROT_PLUGIN_URL.'assets/js/notification-script.js', ESCROT_VERSION, false );
			wp_enqueue_script('escrot-pb-sup-js', ESCROT_PLUGIN_URL.'assets/js/support-script.js', ESCROT_VERSION, false );
			
			//Localize Scripts
			$params = array(
				'ajaxurl' => admin_url('admin-ajax.php'), 
				'is_front_user' => is_escrot_front_user()? 'true' : 'false'
			);
			wp_localize_script('escrot-general-public-js', "escrot", $params);
		}

		//Remove conflicting bootstrap from account page
		public function dequeue_style(){
			if(is_page( 'Account')){
				wp_dequeue_style('bootstrap'); 
			}
		}
		
		
		
	

    }
