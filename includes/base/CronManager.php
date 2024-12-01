<?php
/**
 * The Cron manager class of the plugin.
 * Defines all cron methods and jobs
 * @since      1.0.0
 * @package    Escrowtics
 */
	namespace Escrowtics\base;  
	
	defined('ABSPATH') or die();
	
	class CronManager {
	
	
        public function register() {
           //Register hooks 
            add_filter( 'cron_schedules', array($this, 'customCronIntervals'));//Add custom cron intervals
            add_action( 'init', array($this, 'registerDbBackupEvent'));//register DbBackup event to WordPress init
	    }
		
        
        //Add custom cron interval callback
        public function customCronIntervals($schedules) {
			
            // add 'weekly' cron  interval
            $schedules['weekly'] = array(
                'interval' => WEEK_IN_SECONDS,
                'display' => __('Once Weekly')
            );        
            // add 'monthly' cron  interval
            $schedules['monthly'] = array(
                'interval' => MONTH_IN_SECONDS,
                'display' => __('Once a month')
            );
			// add 'minute' cron  interval
            $schedules['minute'] = array(
                'interval' => MINUTE_IN_SECONDS,
                'display' => __('Once a Minute')
            );
            //return
            return $schedules;
        }
        
		
        
        //Add auto dbbackup cron event
        public function registerDbBackupEvent() {
		    if(ESCROT_AUTO_DBACKUP) {	
                if( !wp_next_scheduled( 'escrot_auto_dbbackup_event' ) ) {
                    // schedule an event
                    wp_schedule_event( time(), ESCROT_AUTO_BACKUP_FREQ, 'escrot_auto_dbbackup_event' );
                }
			}
        }
 
        
        
    }



