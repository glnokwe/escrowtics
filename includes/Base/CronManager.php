<?php
/**
 * The Cron manager class of the plugin.
 * Defines all cron methods and jobs
 * @since      1.0.0
 * @package    Escrowtics
 */
	namespace Escrowtics\Base;  
	
	defined('ABSPATH') || exit;
	
	class CronManager {
	
	
        public function register() {
           //Register hooks 
            add_filter( 'cron_schedules', array($this, 'customCronIntervals'));//Add custom cron intervals
            add_action( 'init', array($this, 'registerDBBackupEvent'));//register DBBackup event to WordPress init
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
        public function registerDBBackupEvent() {
		    if( escrot_option('auto_dbackup') ) {	
                if( !wp_next_scheduled( 'escrot_auto_dbbackup_event' ) ) {
                    // schedule an event
                    wp_schedule_event( time(), escrot_option('auto_dbackup_freq'), 'escrot_auto_dbbackup_event' );
                }
			}
        }
 
        
        
    }



