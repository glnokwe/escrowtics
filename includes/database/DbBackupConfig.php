<?php
 /**
 * The DB Backup Database Configuration class of the plugin.
 * Defines all DB interraction for DB Backup Actions.
 * @since      1.0.0
 * @package    Escrowtics
 */  
	namespace Escrowtics\database;

	defined('ABSPATH') or die();	
	   
	class DbBackupConfig {
		
		public $dbbackupTable;
		
	    public function __construct(){
			
           global $wpdb; 

	       $this->dbbackupTable   = $wpdb->prefix."escrowtics_dbbackups";
		
        }  
	
	    //Backup DB
        public function dbBackup() {
	
	        global $wpdb;
			
			$response = array( 'backup' => "",  'log' => ""); 
			
			$log = "\n#--------------------------------------------------------\n";//Log content
		    $log .= " Database Table Backup (Row Count)";
		    $log .= "\n#--------------------------------------------------------\n";
	        
            //Get All Escrowtics Table Names From the Database			
	        $tables = $wpdb->get_col("SHOW TABLES like '{$wpdb->prefix}escrowtics%'");
			
	        $output = '';//start writing sql content
	
	        foreach ($tables as $table) {
				
				    $log .= "\n $table";
				
				    //Drop table before recreating table (useful during DB restore)	
	                $output .= "DROP TABLE IF EXISTS ".$table.";";
					
		            $result = $wpdb->get_results("SELECT * FROM {$table}", ARRAY_N);
		            $creatTbl = $wpdb->get_row('SHOW CREATE TABLE ' . $table, ARRAY_N);
		            $output .= "\n\n" . $creatTbl[1] . ";\n\n";
					$log .= "(" . count($result) . ")";
		            for ($i = 0; $i < count($result); $i++) {
		                $row = $result[$i];
		                $output .= 'INSERT INTO ' . $table . ' VALUES(';
		                for ($j = 0; $j < count($result[0]); $j++) {
		                    $row[$j] = $wpdb->_real_escape($row[$j]);
		                    $output .= (isset($row[$j])) ? '"' . $row[$j] . '"' : '""';
		                    if ($j < (count($result[0]) - 1)) {
		                        $output .= ',';
		                    }
		                }
		                $output .= ");\n";
		            }
		            $output .= "\n";
	
            }
			
	        $wpdb->flush();
			
		    $log .= "\n#--------------------------------------------------------\n";
			
			$response["backup"] = $output;
			
			$response["log"] = $log;
			
			return $response;
			
			
        }
   
   
   
   	    //Restore DB
        public function dbRestore($fileName) {
			global $wpdb;
		    $sql = '';
	        if (file_exists($fileName)) {
            $lines = file($fileName);
            foreach ($lines as $line) {
                // Ignore comments from the SQL script
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }
                $sql .= $line;
                if (substr(trim($line), - 1, 1) == ';') {
				    $wpdb->query($sql);
                    $sql = '';
                }
            } // end foreach
           }
        }


        //Backup DB
        public function insertDbBackup($backup_url, $backup_path) {
			global $wpdb;
			$wpdb->insert($this->dbbackupTable, array("backup_url" => $backup_url, "backup_path" => $backup_path));
		}


        // Display Backups
	    public function displayDbBackups() {
	     global $wpdb; 
            $sql = $sql = "SELECT * FROM $this->dbbackupTable ORDER BY backup_id DESC";
            $data = $wpdb->get_results($sql, ARRAY_A);
            return $data;
	    }		
	
	
	    //Count available backups
        public function totalDbBackups(){
		     global $wpdb;  
             $sql = "SELECT COUNT(*) FROM $this->dbbackupTable";
		     $rowCount = $wpdb->get_var($sql);
             return $rowCount;
        }
		
		
		
		// Delete backup data from backup table
        public function deleteDB($backup_id){
            global $wpdb;	
		    $where = array('backup_id' => $backup_id); 
		    $wpdb->delete($this->dbbackupTable, $where);
		 
        }
	  
	  
	    //Delete Multiple backup data from backup table
        public function deleteMultDBs($multid){
			global $wpdb;
			$ids = explode(',', $multid);
			foreach	($ids as $id) {
				$where = array('backup_id' => $id); 
				$wpdb->delete($this->dbbackupTable, $where);
			}
        }
	
	
		
   }