<?php
/**
 * The Admin Notification manager class of the plugin.
 * Defines all Admin Notification Actions.
 * @since      1.0.0
 * @package    Escrowtics
 */
	namespace Escrowtics;
	
	use Escrowtics\database\NotificationConfig; 
	
	defined('ABSPATH') or die();
	
	use \DateTime;	
		
	class NotificationActions extends NotificationConfig {
		
		
		public function register() {
		
          //Register hooks 
	      add_action( 'wp_ajax_escrot_notifications', array($this, 'actionGetNotifications' ));
		  add_action( 'escrot_notify', array($this, 'notify' ));
			
	    }

  
	    public function actionGetNotifications() {
			
	      if(isset($_POST['noty-action'])){

            if($_POST["noty-action"] != ''){ 
 
              $this->updateNotyStatus();
	        }
	  
	  
            $output = '';
	 
            if( $this->totalNotyCount() > 0 ){
		 
	        $rows = $this->getNotifications();	 
		 
            foreach ($rows as $row){
	
                date_default_timezone_set(ESCROT_TIMEZONE);
	
	            $datetimeNow = date('Y-m-d H:i:s T');		 	
	            $timestamp = new DateTime($datetimeNow);
	            $datetime  = new DateTime($row["date"]);
	            $timeSecs = abs($timestamp->getTimestamp() - $datetime->getTimestamp());
	            $timeMnts = round($timeSecs/60, 0);
	            $timeHr = round($timeSecs/3600, 0);
	
	
	            $notyDate = date("M d", strtotime($row["date"]));
	            $notyHr = date("h:i A", strtotime($row["date"]));	 
		 
	            $break_notif_sbjt = explode(':', $row["subject"]);
	            $get_ref_id = $row["subject_id"];	

				$notif_sbjt = explode(',', $row["subject"])[0];	
   
                $output .= '<li>';
	 
                if($break_notif_sbjt[0] == "New User Account Created, ID"){
		
		            $qtelink = "admin.php?page=escrowtics-user-profile&user_id=".$get_ref_id."";
		            $output .= '<a href="'.$qtelink.'" style="display: inline-block !important" class="dropdown-item escrot-rounded"><i style="display: inline-block !important" class="fa fa-user-group sett-icon"></i>&nbsp;&nbsp;';
	
	            } elseif($break_notif_sbjt[0] == "New Support Ticket Opened, ID"){
					if(is_escrot_front_user()){
						if(isset($_POST['endpoint_url'])){
							$endpoint_url = $_POST['endpoint_url'];
							$ticket_url =  add_query_arg(['ticket_id' => $get_ref_id],  $endpoint_url );
						}
					} else {
						$ticket_url = "admin.php?page=escrowtics-view-ticket&ticket_id=".$get_ref_id;
					}
		            $output .= '<a href="'.$ticket_url.'" style="display: inline-block !important" class="dropdown-item escrot-rounded"><i style="display: inline-block !important" class="fa fa-user-group sett-icon"></i>&nbsp;&nbsp;';
				}  else {
		
	               $output .= '<a href="#" id="'.$get_ref_id.'" style="display: inline-block !important" class="noty dropdown-item escrot-rounded"><i style="display: inline-block !important" class="fa fa-bell sett-icon"></i>&nbsp;&nbsp;';
	
	            }
				
                $output .= ' <strong>'.$notif_sbjt.'</strong>&nbsp;<br/>
                <small><em>'.$row["message"].'</em></small><br/><small class="noty-small">';
                if($timeSecs < 5 || $timeSecs == 5){$output .= __(" just now", "escrowtics");}
	            elseif($timeSecs > 5 && $timeSecs < 60){$output .= $timeSecs.__(" seconds ago", "escrowtics");}
	            elseif($timeSecs == 60 ){$output .= $timeMnts.__(" minute ago", "escrowtics");}
	            elseif($timeSecs > 60 && $timeSecs < 3600){$output .= $timeMnts.__(" minutes ago", "escrowtics");}
	            elseif($timeSecs == 3600){$output .= $timeHr.__(" hour ago", "escrowtics");}
	            elseif($timeSecs > 3600 && $timeSecs < 86400 ){$output .= $timeHr.__(" hours ago", "escrowtics");}
	            elseif($timeSecs > 86400 && $timeSecs < 172800){$output .= __("Yesterday at ").$notyHr;}
	            elseif($timeSecs > 172800){$output .= $notyDate.__(" at ", "escrowtics").$notyHr;}
                $output .= '</small><a/></li>';

                }
	
            } else{
               $output .= '
               <li><a href="#" class="text-bold text-italic">'.__("No Notification Found", "escrowtics").'</a></li>';
            }
			
			$noty_bg = is_escrot_front_user()? 'bg-secondary' : 'bg-primary';

            wp_send_json(['noty' => $output, 'unseen_noty' => $this->unseenNotyCount(), 'noty_bg_class' => $noty_bg ]);
   


	     }
	   }  
	}
	

