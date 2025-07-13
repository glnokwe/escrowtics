<?php

/**
 * The admin pages class of the plugin.
 * Adds all admin menu pages and subpages
 *
 * @since      1.0.0
 * @package    Escrowtics
 */
 
	namespace Escrowtics;
	
	defined('ABSPATH') || exit;
	 
	use Escrowtics\Api\SettingsApi;
	use Escrowtics\Api\callbacks\AdminCallbacks;
	
	 
	class AdminMenu {
		
		public $settings;

		public $pages = array();

		public $subpages = array();
		
		public $callbacks;
		
		
		
		public function register() {
			
			$this->settings = new SettingsApi();

			$this->callbacks = new AdminCallbacks();
            
			$this->setPages(); 

			$this->setSubpages();
			
			$this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
			
			add_action('admin_menu', array($this, 'removeEscrotExtraTopMenu'));
			
		} 
		

		public function capability() {
			
			$capability = "";
			
			include_once(ABSPATH . 'wp-includes/pluggable.php');
   
            $user = wp_get_current_user();
			$user_roles = $user->roles;
			
			$plugin_role = escrot_option('access_role');
			
			if(in_array("administrator", $user_roles)){
				$capability = "administrator"; 
			} elseif (in_array($plugin_role, $user_roles)){
				$capability = $plugin_role; 
			}
		
			return $capability;
			
		}	
		
			
		public function setPages() {
			
			$this->pages = array(
				array(
					'page_title' => 'Escrowtics Plugin', 
					'menu_title' => 'Escrowtics', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-dashboard', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
					'icon_url' => ESCROT_PLUGIN_URL. 'assets/img/escrowtics-icon.png', 
					'position' => 20
				),
				array(
					'page_title' => 'Escrowtics Escrows', 
					'menu_title' => 'Escrows', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-escrows', 
					'callback' => '', 
					'icon_url' => '', 
					'position' => 0
				)
			);
			
		}

		public function setSubpages(){
			
			$this->subpages = array(
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Escrows', 
					'menu_title' => 'Escrows', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-escrows', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Deposits', 
					'menu_title' => 'Deposits', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-deposits', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Withdrawals', 
					'menu_title' => 'Withdrawals', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-withdrawals', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Transaction Log', 
					'menu_title' => 'Transaction Log', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-transaction-log', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Users', 
					'menu_title' => 'Users', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-users', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Statistics', 
					'menu_title' => 'Statistics', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-stats', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Database Backups', 
					'menu_title' => 'DB Backups', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-db-backups', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Disputes', 
					'menu_title' => 'Disputes', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-disputes', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics Settings', 
					'menu_title' => 'Settings', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-settings', 
					'callback' => array( $this->callbacks, 'settingsTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics User Profile', 
					'menu_title' => '', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-user-profile', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics View Escrow', 
					'menu_title' => '', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-view-escrow', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				),
				array(
					'parent_slug' => 'escrowtics-dashboard', 
					'page_title' => 'Escrowtics View Dispute', 
					'menu_title' => '', 
					'capability' => $this->capability(), 
					'menu_slug' => 'escrowtics-view-dispute', 
					'callback' => array( $this->callbacks, 'adminGenTemplate' ), 
				)
			);
		}
		
		
		//Hide Escrowtics Extra Top menus
		public  function removeEscrotExtraTopMenu() {
			remove_menu_page('escrowtics-escrows');
	    }
		
		
		
	}
		
		
		
		
