<?php

    /**
    * Plugin initialiation class. 
    * Registers all admin and frontend hooks.
    * @since    1.0.0
	* @package  Escrowtics
    */
	
    namespace Escrowtics;
	
	defined('ABSPATH') or die();
 
    final class EscrotInit {
	
	    /* 
        *Store all classes in an array
	    *@return array list of all classes
	    *since  1.0.0
	    */
	    public static function get_services() {
		
	    return[ 
		        database\DatabaseMigration::class,
	            base\OptionsManager::class,
				base\CronManager::class,
			    base\Shortcodes::class,
				email\EmailManager::class,
				AdminScreenOptions::class,
	            AdminPluginLinks::class,
			    AdminMenu::class,
			    AdminEnqueue::class,	
			    UsersActions::class,
                EscrowsActions::class,
				SupportActions::class,	
				api\BitcoinPay\BitcoinPayActions::class,	
				api\RestApi\RestApi::class,
                NotificationActions::class,
                DbBackupActions::class,	
                PublicEnqueue::class,
                base\I18n::class,				
			  
			];
     
	    }
	
	
	
	    /* 
        *Initialize the class
	    *@param   $class             from the services array
        *@return  class instance     new instance of the class
	    */
	    private static function instantiate($class){
		
		    $service = new $class();
		    return $service;
	    }
		
	
	
	    /* 
        *Loop through the classes, initialize, and 
	    *call the register() *method if it exist
	    *@return void
	    */
        public static function register_services() {
		
		    foreach (self::get_services() as $class) {
			
			    $service = self::instantiate($class);
			
			    if ( method_exists($service, 'register' ) ) {
				   
				    $service->register(); 
			    }
		    }
	    }
		

    }
