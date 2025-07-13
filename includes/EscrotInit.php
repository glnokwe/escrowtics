<?php

/**
* Plugin initialiation class. 
* Registers all admin and frontend hooks.
*
* @since    1.0.0
* @package  Escrowtics
*/

namespace Escrowtics;

defined('ABSPATH') || exit;

final class EscrotInit {

	/* 
	*Store all classes in an array
	*@return array list of all classes
	*since  1.0.0
	*/
	public static function getServices() {
	
		return[ 
				Database\DBMigration::class,
				Base\OptionsManager::class,
				Base\CronManager::class,
				Base\Shortcodes::class,
				Email\EmailManager::class,
				AdminScreenOptions::class,
				AdminPluginLinks::class,
				AdminMenu::class,
				AdminEnqueue::class,	
				UsersActions::class,
				EscrowsActions::class,
				DisputesActions::class,	
				Api\BitcoinPay\BitcoinPayActions::class,
				Api\Paypal\PaypalActions::class,					
				Api\RestApi\RestApiActions::class,
				Api\DataTable\DataTableActions::class,
				NotificationActions::class,
				DBBackupActions::class,	
				PublicEnqueue::class,
				Base\I18n::class,				
			  
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
	public static function registerServices() {
	
		foreach (self::getServices() as $class) {
		
			$service = self::instantiate($class);
		
			if ( method_exists($service, 'register' ) ) {
			   
				$service->register(); 
			}
		}
	}
	

}
