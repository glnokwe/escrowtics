<?php
/**
 * The DB Backup manager class of the plugin.
 * Defines all DB Backup Actions.
 *
 * @since 1.0.0
 */

namespace Escrowtics;

use Escrowtics\Database\DBBackupDBManager;

defined('ABSPATH') || exit;

class DBBackupActions extends DBBackupDBManager {

    /**
     * Registers hooks and actions.
     */
    public function register() {
        $ajax_actions = [
            'escrot_dbbackup' => 'actionDBBackup',
            'escrot_dbrestore' => 'actionDBRestore',
            'escrot_extfile_dbrestore' => 'extFileDBRestore',
            'escrot_display_dbbackups' => 'actionDisplayDBBackups',
            'escrot_dbbackups_tbl' => 'actionReloadDBBackups',
            'escrot_del_dbbackup' => 'actionDeleteDB',
            'escrot_del_dbbackups' => 'actionDeleteMultDBs',
			'escrot_dbrestore_progress' => 'actionDBRestoreProgress'
        ];

        foreach ($ajax_actions as $hook => $method) {
            add_action("wp_ajax_{$hook}", [$this, $method]);
        }

        // Cron events
        add_action('escrot_auto_dbbackup_event', [$this, 'actionDBBackup']);
		add_action('escrot_restore_database_event', [$this, 'dbRestore']);
    }
	
	public function actionStartSession() {
		if (!session_id()) {
			session_start();
		}
	}

    /**
     * Display backups.
     */
    public function actionDisplayDBBackups() {
        $data_count = $this->totalDBBackups();
        include_once ESCROT_PLUGIN_PATH . 'templates/admin/db-backup/db-backups.php';
        wp_die();
    }

    /**
     * Reload backups table.
     */
    public function actionReloadDBBackups() {
        $data_count = $this->totalDBBackups();
        include_once ESCROT_PLUGIN_PATH . 'templates/admin/db-backup/dbbackups-table.php';
        wp_die();
    }

    /**
     * Create a database backup.
     */
    public function actionDBBackup() {
        $filename = 'escrowtics-dbbackup-' . date("Y-m-d-His") . '.sql';
        $backup_dir = $this->prepareBackupDirectory();

        $file_path = $backup_dir . $filename;
        $file_url = wp_upload_dir()["baseurl"] . '/escrowtics-dbbackups/' . $filename;

        $this->insertDBBackup($file_url, $file_path);

        $response = $this->dbBackup();
        $this->writeToFile($file_path, $response['backup']);

        if ( escrot_option('dbackup_log') ) {
            $log_filename = 'escrowtics-dbbackup-' . date("Y-m-d-His") . '-log.txt';
            $log_file_path = $backup_dir . $log_filename;
            $this->writeToFile($log_file_path, $response['log']);
        }
        wp_send_json_success(['message' => __('Database Backup Created Successfully!', 'escrowtics')]);
    }

    
	/**
	 * Restore a database backup.
	 */
	public function actionDBRestore() {
		escrot_verify_permissions('manage_options'); //Ensure admin user has permission

		$file_name = isset($_POST['BkupfileName'])? sanitize_text_field($_POST['BkupfileName']) : '';
		if (empty($file_name) || !file_exists($file_name)) {
			wp_send_json_error(['message' => __('Invalid or missing backup file.', 'escrowtics')]);
		}

		// Create progress JSON file
		$progress_file = $this->getProgressFilePath();
		file_put_contents(
			$progress_file, 
			json_encode(['percent_complete' => 0, 'message' => 'Preparing the backup file...', 'completed' => false])
		);

		// Schedule the restore process
		$timestamp = time() + 3; // Start in 3 seconds
		wp_schedule_single_event($timestamp, 'escrot_restore_database_event', [$file_name]);

		wp_send_json_success(['message' => __('Restore process scheduled.', 'escrowtics')]);
	}

    /**
     * Handles AJAX request to get the restore progress.
     */
	public function actionDBRestoreProgress() {
		$progress_file = $this->getProgressFilePath();

		if (!file_exists($progress_file)) {
			wp_send_json_error(['message' => __('Progress file not found.', 'escrowtics')]);
		}

		$progress_data = json_decode(file_get_contents($progress_file), true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			wp_send_json_error(['message' => __('Invalid progress data.', 'escrowtics')]);
		}

		wp_send_json_success($progress_data);
	}
	
	/**
	 * Restore a database backup from an uploaded file.
	 */
	public function extFileDBRestore() {
		//Ensure admin user has permission
		escrot_verify_permissions('manage_options'); 
		
		// Check if a file is uploaded
		if (empty($_FILES['backup_file']['name'])) {
			wp_send_json_error(['message' => __('No file uploaded.', 'escrowtics')]);
			return;
		}

		// Validate and sanitize the file name
		$file_name = sanitize_file_name($_FILES['backup_file']['name']);
		$upload_dir = wp_upload_dir(); // Get WordPress uploads directory
		$destination = trailingslashit($upload_dir['basedir']) . 'escrowtics-dbbackups/' . $file_name;

		// Ensure the target directory exists
		if (!file_exists(dirname($destination))) {
			wp_mkdir_p(dirname($destination));
		}

		// Attempt to move the uploaded file to the designated directory
		if (!move_uploaded_file($_FILES['backup_file']['tmp_name'], $destination)) {
			wp_send_json_error(['message' => __('Failed to upload the file.', 'escrowtics')]);
			return;
		}

		// Initialize the progress file
		$progress_file = $this->getProgressFilePath();
		if (!file_put_contents(
			$progress_file, 
			json_encode(['percent_complete' => 0, 'message' => 'Preparing the backup file...', 'completed' => false])
		)) {
			wp_send_json_error(['message' => __('Failed to initialize progress file.', 'escrowtics')]);
			return;
		}

		// Schedule the restore process
		$timestamp = time() + 3; // Start in 3 seconds
		if (!wp_schedule_single_event($timestamp, 'escrot_restore_database_event', [$destination])) {
			wp_send_json_error(['message' => __('Failed to schedule restore process.', 'escrowtics')]);
			return;
		}

		// Send success response
		wp_send_json_success(['message' => __('Restore process scheduled.', 'escrowtics')]);
	}
	

    /**
     * Delete a single database backup.
     */
    public function actionDeleteDB() {
        $delete_db_id = sanitize_text_field($_POST['deleteDBid'] ?? '');
        $db_path = sanitize_text_field($_POST['DBpath'] ?? '');

        if ($delete_db_id) {
            $this->deleteDB($delete_db_id);
        }

        if ($db_path) {
            $this->deleteBackupFiles($db_path);
        }
		wp_send_json_success(['message' => __('DB Backup deleted successfully', 'escrowtics')]);
    }

    /**
     * Delete multiple database backups.
     */
    public function actionDeleteMultDBs() {
        $db_ids = $_POST['multDBid'] ?? [];
        $db_paths = explode(',', sanitize_text_field($_POST['multDBpath'] ?? ''));

        if (!empty($db_ids)) {
            $this->deleteMultDBs($db_ids);
        }

        foreach ($db_paths as $db_path) {
            $this->deleteBackupFiles($db_path);
        }
    }

    /**
     * Prepare the backup directory.
     *
     * @return string The backup directory path.
     */
    private function prepareBackupDirectory() {
        $upload_dir = wp_upload_dir();
        $backup_dir = trailingslashit($upload_dir['basedir']) . 'escrowtics-dbbackups/';

        if (!file_exists($backup_dir)) {
            wp_mkdir_p($backup_dir);
            $this->writeToFile($backup_dir . 'index.php', '<?php // Silence is golden');
        }
		return $backup_dir;
    }

    /**
     * Write content to a file.
     *
     * @param string $file_path The file path.
     * @param string $content   The content to write.
     */
    private function writeToFile($file_path, $content) {
        $handle = fopen($file_path, 'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    /**
     * Delete backup files (SQL and log).
     *
     * @param string $db_path The path to the SQL file.
     */
    private function deleteBackupFiles($db_path) {
        $log_path = str_replace('.sql', '-log.txt', $db_path);

        if (file_exists($db_path)) {
            unlink($db_path);
        }

        if (file_exists($log_path)) {
            unlink($log_path);
        }
    }
}
