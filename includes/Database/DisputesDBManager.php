<?php
/**
 * The Disputes Database Interaction class of the plugin.
 * Handles all database interactions for dispute actions in the plugin.
 * 
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Database;

defined('ABSPATH') || exit;

/**
 * Class DisputesDBManager
 * Provides methods for interacting with the disputes database tables.
 */
class DisputesDBManager {

    protected $tables;
    private   $db;

    /**
     * Constructor to initialize table names with the appropriate WordPress table prefix.
     */
    public function __construct() {
		
		 $this->db = new DBHelper();
		
         $this->tables = (object)[
			'users'         => $this->db->tbl_pfx . 'escrowtics_users',
			'disputes'      => $this->db->tbl_pfx . 'escrowtics_disputes',
			'escrow_meta'      => $this->db->tbl_pfx . 'escrowtics_escrow_meta',
			'disputes_meta' => $this->db->tbl_pfx . 'escrowtics_disputes_meta',
			'notifications' => $this->db->tbl_pfx . 'escrowtics_notifications'
		];
    }

    /**
     * Insert data into a specified table.
     * 
     * @param string $table The name of the table.
     * @param array $data The data to be inserted.
     */
    public function insertData($table, $data) {
        return $this->db->escrotInsert($table, $data);
    }

    /**
     * Get the ID of the last inserted dispute.
     * 
     * @return int The last inserted dispute ID.
     */
    public function getLastInsertedDisputeID() {
        $sql = "SELECT dispute_id FROM {$this->tables->disputes} ORDER BY dispute_id DESC LIMIT 1";
		return $this->db->escrotQuery($sql, [], 'var');
    }

    /**
     * Fetch all disputes to display in the disputes table.
     * 
     * @return array An array of disputes.
     */
    public function getAllDisputes() {
        $sql = "SELECT * FROM {$this->tables->disputes} ORDER BY dispute_id DESC";
        return $this->db->escrotQuery($sql);
    }

    /**
     * Fetch a specific dispute by ID.
     * 
     * @param int $id The dispute ID.
     * @return array|null The dispute record, or null if not found.
     */
    public function getDisputeById($id) {
        $sql = "SELECT * FROM {$this->tables->disputes} WHERE dispute_id = %d";
        return $this->db->escrotQuery($sql, [$id], 'row');
    }

    /**
     * Count the total number of disputes.
     * 
     * @return int Total disputes count.
     */
    public function getTotalDisputeCount() {
        $sql = "SELECT COUNT(*) FROM {$this->tables->disputes}";
        return $this->db->escrotQuery($sql, [], 'var');
    }
	
	 /**
     * Count disputes where the user is a complainant.
     *
     * @param string $username Username.
     * @return int Number of disputes.
     */
    public function getUserComplainantDisputeCount($username){
        $sql = "SELECT COUNT(*) FROM {$this->tables->disputes} WHERE complainant = %s";
        return $this->db->escrotQuery($sql, [$username], 'var');
    }
	
	
	/**
     * Count already existing disputes between for given escrow.
     *
     * @param strings $escrow_id Escrow ID.
     * @return bool.
     */
	public function escrowDisputeExist($escrow_id){
		$sql = "SELECT COUNT(*) FROM {$this->tables->disputes} WHERE escrow_id = %d";
        $rowCount = $this->db->escrotQuery($sql, [$escrow_id], 'var');
		
	    if($rowCount > 0){
			return true;
		} else {
			return false;
		}
	}
	
	/**
     * Fetch the most recent milestone by Escrow ID.
     * 
     * @param int $escrow_id The escrow ID.
     * @return array|null The milestone record, or null if not found.
     */
    public function getEsrowMilestoneByescrowId($escrow_id) {
        $sql = "SELECT * FROM {$this->tables->escrow_meta} WHERE escrow_id = %d ORDER BY meta_id DESC LIMIT 1";
        return $this->db->escrotQuery($sql, [$escrow_id], 'row');
    }
	
	
	/**
     * Count already existing disputes between for given escrow.
     *
     * @param strings $escrow_id Escrow ID.
     * @return bool.
     */
	public function disputeExist($dispute_id){
		$sql = "SELECT COUNT(*) FROM {$this->tables->disputes} WHERE dispute_id = %d";
        $rowCount = $this->db->escrotQuery($sql, [$dispute_id], 'var');
		
	    if($rowCount > 0){
			return true;
		} else {
			return false;
		}
	}
    
	
	/**
     * Count disputes where the user is an accused.
     *
     * @param string $username Username.
     * @return int Number of disputes.
     */
    public function getUserAccusedDisputeCount($username){
        $sql = "SELECT COUNT(*) FROM {$this->tables->disputes} WHERE accused = %s";
        return $this->db->escrotQuery($sql, [$username], 'var');
    }
	
	
	
	
	/**
	 * Retrieves all disputes initiated by a specific user as the complainant.
	 *
	 * @param string $username The username of the complainant.
	 * @return array An array of disputes associated with the user as the complainant.
	 */
	public function getUserComplainantDisputes($username){
		$sql = "SELECT * FROM {$this->tables->disputes} WHERE complainant = %s";
		return $this->db->escrotQuery($sql, [$username]);
	}

	
	/**
	 * Retrieves all disputes where a specific user is listed as the accused party.
	 *
	 * @param string $username The username of the accused.
	 * @return array An array of disputes associated with the user as the accused.
	 */
	public function getUserAccusedDisputes($username){
		$sql = "SELECT * FROM {$this->tables->disputes} WHERE accused = %s";
		return $this->db->escrotQuery($sql, [$username]);
	}
	

    /**
     * Count the total number of metadata entries for a specific dispute.
     * 
     * @param int $dispute_id The dispute ID.
     * @return int The count of metadata entries.
     */
    public function getDisputeMetaCount($dispute_id) {
        $sql = "SELECT COUNT(*) FROM {$this->tables->disputes_meta} WHERE dispute_id = %d";
        return $this->db->escrotQuery($sql, [$dispute_id], 'var');
    }

    /**
     * Fetch all metadata entries for a specific dispute by ID.
     * 
     * @param int $dispute_id The dispute ID.
     * @return array An array of metadata entries.
     */
    public function getDisputeMetaById($dispute_id) {
		$sql = "SELECT * FROM {$this->tables->disputes_meta} WHERE dispute_id = %d";
        return $this->db->escrotQuery($sql, [$dispute_id]);
    }

    /**
     * Update a specific dispute record.
     * 
     * @param array $data The data to update, including the `dispute_id` as the key.
     */
    public function updateDispute($data) {
		return $this->db->escrotUpdate($this->tables->disputes, $data, ['dispute_id' => $data['dispute_id']]);
    }

    /**
     * Delete a specific dispute and its metadata.
     * 
     * @param int $dispute_id The ID of the dispute to delete.
     */
    public function deleteDispute($dispute_id) {
         $this->db->escrotDelete($this->tables->disputes,      ['dispute_id' => $dispute_id]);
         $this->db->escrotDelete($this->tables->disputes_meta, ['dispute_id' => $dispute_id]);
		 $this->db->escrotDelete($this->tables->notifications, ['subject_id' => $dispute_id]);
    }

    /**
     * Delete multiple disputes and their metadata.
     * 
     * @param string $dispute_ids Comma-separated string of dispute IDs.
     */
    public function deleteDisputes($dispute_ids) {
        $ids = array_map('intval', explode(',', $dispute_ids)); // Sanitize IDs.
        foreach ($ids as $id) {
            $this->deleteDispute($id); 
        }
    }
	
	
	
	
}
