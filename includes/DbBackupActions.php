<?php
/**
 * The DB Backup manager class of the plugin.
 * Defines all DB Backup Actions.
 * 
 * @since      1.0.0
 */
    namespace Escrowtics;
	
	use Escrowtics\database\DbBackupConfig; 

	defined('ABSPATH') or die();	
	   
	class DbBackupActions extends DbBackupConfig {
	
	
	
        public function register() {
		
            //Register hooks 
	        add_action( 'wp_ajax_escrot_dbbackup', array($this, 'actionDBBackup' ));
		    add_action( 'wp_ajax_escrot_dbrestore', array($this, 'actionDBRestore' ));
			add_action( 'wp_ajax_escrot_extfile_dbrestore', array($this, 'extFileDBRestore' ));
			add_action( 'wp_ajax_escrot_display_dbbackups', array($this, 'actionDisplayDbBackups' ));
			add_action( 'wp_ajax_escrot_dbbackups_tbl', array($this, 'actionReloadDbBackups' ));
			add_action( 'wp_ajax_escrot_del_dbbackup', array($this, 'actionDeleteDB' ));
            add_action( 'wp_ajax_escrot_del_dbbackups', array($this, 'actionDeleteMultDBs' ));
			add_action( 'escrot_auto_dbbackup_event', array($this, 'actionDBBackup' ) );//Run DbBackup Chron
	    }



        //Display Backups
	    public function actionDisplayDbBackups() {
			
	        include_once ESCROT_PLUGIN_PATH."templates/admin/db-backup/db-backups.php";
        
		    wp_die();
	    }	

        
		//Reload Backups Table
	    public function actionReloadDbBackups() {
			
	        include_once ESCROT_PLUGIN_PATH."templates/admin/db-backup/dbbackups-table.php";
        
		    wp_die();
	    }		
		
		

        //Backup DB
        public function actionDBBackup() {
		  
			
            $filename = 'escrowtics-dbbackup-'.date("Y-m-d-His").'.sql';			
			$wp_upload_path = wp_upload_dir();
		    $backup_dir = $wp_upload_path["basedir"].'/escrowtics-dbbackups/';
			$file_url = $wp_upload_path["baseurl"].'/escrowtics-dbbackups/'.$filename;			
			$file_path = $backup_dir.$filename;
			   
			//insert backup details into database
			$this->insertDbBackup($file_url, $file_path);
	        
			//create backup folder
            if (!file_exists($backup_dir)) {
               wp_mkdir_p($backup_dir);
			   $indexHandler = fopen($backup_dir.'/index.php', 'w+'); //create index.php file
			   fwrite($indexHandler, "<?php // Silence is golden");
			   fclose($indexHandler);
            }
			   
			//Get backup & log contents
			$response = $this->dbBackup();
			
			//write backup content to sql file
			$sqlScript = $response["backup"];
			$handler = fopen($file_path, 'w+');
			fwrite($handler, $sqlScript);
			fclose($handler); 
			
            if(ESCROT_DBACKUP_LOG){			
			   //write log to text file
			   $log = $response["log"];
			   $logFile = 'escrowtics-dbbackup-'.date("Y-m-d-His").'-log.txt';	
			   $logFile_path = $backup_dir.$logFile;
			   $logHandler = fopen($logFile_path, 'w+');
			   fwrite($logHandler, $log);
			   fclose($logHandler); 
			}
			
            echo "success";			
		    wp_die();
		
        }
   
   
   
   
        //Restore DB Backup (Server-side File, No File Upload)
        public function actionDBRestore() {
	   
	        if (isset($_POST['BkupfileName'])) { 
			
			   $fileName = $_POST['BkupfileName'];
			   
			   $this->dbRestore($fileName);
			   
			   echo "success";
			}
			
			wp_die();
       } 
	   
	   
	    //Restore DB Backup From External File
        public function extFileDBRestore() {
			
			if(!empty($_FILES["backup_file"]["name"])){ 
                 
                // File path config 
                $fileName = basename($_FILES["backup_file"]["name"]);
		
	           
		         // Upload file to the server 
                 if(move_uploaded_file($_FILES["backup_file"]["tmp_name"], $fileName)){ 
		   
                     $this->dbRestore($fileName);
		   
		             echo "success";
                }
            }  
			
            wp_die();
        } 
	   
	   
	   
	   
	   
	    //Delete DB 
        public function actionDeleteDB() {
		
            if (isset($_POST['deleteDBid'])) {
               $deleteDBid = $_POST['deleteDBid'];
               $this->deleteDB($deleteDBid);
            }
			 if (isset($_POST['DBpath'])) {
               $DBpath = $_POST['DBpath'];
			   unlink($DBpath);//delete DB Backup File
			   unlink( str_replace('.sql', '-log.txt', $DBpath) );//delete Backup Log
	        }
		    wp_die();
	   }	
   
   
   

        //Delete Multiple Backups  
        public function actionDeleteMultDBs() {
            if (isset($_POST['multDBid'])) {
               $multDBid = $_POST['multDBid'];
               $this->deleteMultDBs($multDBid);
	        }
			 if (isset($_POST['multDBpath'])) {
               $DBpaths = explode(",", $_POST['multDBpath']);
			   foreach($DBpaths as $DBpath) {
				 unlink($DBpath);//delete DB Backup File
				 unlink( str_replace('.sql', '-log.txt', $DBpath) );//delete Backup Log
			   }
	        }
	        wp_die();
        }
		
	
   
   
    }



