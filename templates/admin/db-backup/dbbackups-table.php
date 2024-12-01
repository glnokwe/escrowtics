<?php
 /**
 * The DB Backups Table.
 * List all available DB Backups.
 * 
 * @since      1.0.0
 */ 
           
$swalfire = 'Swal.fire("'.__("No Action Selected!", "escrowtics").'", "'.__("Please select an action to continue!", "escrowtics").'", "warning");';


$output = "";

$backups = $this->displayDbBackups();
$rowCnt = $this->totalDbBackups();

if ($rowCnt > 0) {
 
	$output .="

	<select id='track-list-actions'>
	<option value='option1'>".__('Select action', 'escrowtics')."</option>
	<option value='option2'>".__('Delete', 'escrowtics')."</option>
	</select>

	<div id='option1' style='display: none;' class='btndiv'><a type='button' class='btn escrot-tbl-action-btn' 
	onclick='".$swalfire."'><i class='fas fa-check' ></i> ".__('Apply', 'escrowtics')."</a></div>

	<div id='option2' style='display: none;' class='btndiv'><a type='button' id='delete_db_records' class='btn btn-danger escrot-tbl-action-btn'> ".__('Delete', 'escrowtics')."</a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> 
	".__('Selected', 'escrowtics')."</span></div>


	<table class='table border escrot-data-table stripe hover order-column' id='escrot-db-backup-table' width='100%' cellspacing='0' style='font-size:14px;'>
		<thead class='escrot-th'>
				<tr>
					<th data-orderable='false' style='color:#06accd !important;'><center><input style='border: solid gold !important;' type='checkbox' id='select_all'></center></th>
					<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Creation Date', 'escrowtics')."</th>";
					
					
		if(ESCROT_DBACKUP_LOG){ $output .=" <th class='escrot-th'>".__('Backup Logs', 'escrowtics')."</th>"; }
				
		$output .="	<th class='escrot-th'>".__('Backup File', 'escrowtics')."</th>
					<th class='escrot-th'>".__('File Size', 'escrowtics')."</th>
					<th class='escrot-th'><center>".__('Action', 'escrowtics')."</center></th>
				</tr>
			</thead>
		<tbody>";
		
	foreach ($backups as $backup) {
	 
		if (file_exists($backup['backup_path'])) {	 
		 
			$output.="<tr id='".$backup['backup_id']."'>  ";  
				
				$output.="			
						<td><center><input type='checkbox' class='escrot-checkbox' data-bkup-path='".$backup['backup_path']."' data-escrot-row-id='".$backup['backup_id']."'></center></td>
						<td></td>
						<td>".$backup['creation_date']."</td>";
						
				if(ESCROT_DBACKUP_LOG){	
				  $output .="<td><a target='_blank' href='".str_replace('.sql', '-log.txt', $backup['backup_url'])."' id='".$backup[ 'backup_id']."' class='btn btn-icon-text escrot-btn-sm btn-success seeDBLog'>
					<i class='fas fa-eye'></i> <spa class='d-none d-md-inline'>
					".__('View Log', 'escrowtics')."</span></a></td>";
				}
				
				$output .="	<td><a class='btn btn-icon-text escrot-btn-sm btn-info' data-toggle='tooltip' title='Download Backup' href='". 
						  $backup['backup_url']."'><i class='fas fa-download'></i> <spa class='d-none d-md-inline'>
						  ".__('Download', 'escrowtics')."</span></a></td>
						<td>".round(filesize($backup['backup_path'])/1000, 2)." kb</td>
						
						<td><center>
						<a href='#' data-toggle='tooltip' title='Restore Backup' id='".$backup['backup_path']."' class='btn btn-icon-text escrot-btn-sm restoreDB btn-behance' >
						<i class='fas fa-sync'></i> <spa class='d-none d-md-inline'>
						".__('Restore', 'escrowtics')."</span>
						</a>
						
						<a href='#' data-toggle='tooltip' title='".__('Delete', 'escrowtics')."' id='".$backup['backup_id']."' data-bkup-path='".$backup['backup_path']."' class='btn btn-icon-text escrot-btn-sm btn-danger deleteDB'>
						<i class='fas fa-trash'></i>
						</a>
						
						</a></center>
						</td>
					  </tr>
					"; 	
				

		} else{
			$this->deleteDB($backup['backup_id']);//delete DB info if no backup file exist
		} 
	}

	$output .= "
		</tbody>
		<thead class='escrot-th'>
				<tr>
					<th data-orderable='false'><center><input type='checkbox' id='select_all2'></center></th>
					<th class='escrot-th'>".__('No.', 'escrowtics')."</th>
					<th class='escrot-th'>".__('Creation Date', 'escrowtics')."</th>";
		if(ESCROT_DBACKUP_LOG){ $output .=" <th class='escrot-th'>".__('Backup Logs', 'escrowtics')."</th>"; }
		$output .="	<th class='escrot-th'>".__('Backup File', 'escrowtics')."</th>
					<th class='escrot-th'>".__('File Size', 'escrowtics')."</th>
		
					<th class='escrot-th'><center>".__('Action', 'escrowtics')."</center></th>
				</tr>
			</thead>
		</table>
	<br>
	<select id='track-list-actions2'>
	<option value='option1a'>".__('Select action', 'escrowtics')."</option>
	<option value='option2b'>".__('Delete', 'escrowtics')."</option>
	</select>

	<div id='option1a' style='display: none;' class='btndiv2'><a type='button' class='btn escrot-tbl-action-btn' onclick='".$swalfire."'><i class='fas fa-check'></i> ".__('Apply', 'escrowtics')."</a></div>

	<div id='option2b' style='display: none;' class='btndiv2'><a type='button' id='delete_db_records' class='btn btn-danger escrot-tbl-action-btn'> ".__('Delete', 'escrowtics')."</a> <span class='escrot-selected' id='escrot-select-count'><b>0</b> 
	".__('Selected', 'escrowtics')."</span></div>";

	echo $output;  
	
} else{
	echo '<h3 class="text-light text-center mt-5">'.__("No database backup found", "escrowtics").'</h3>';
}