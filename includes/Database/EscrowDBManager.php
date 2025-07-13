<?php
/**
 * Escrows Database Interaction class of the plugin.
 * Handles all DB interactions for Escrow actions.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Database;

defined('ABSPATH') || exit;

class EscrowDBManager {

    protected $tables;
    private   $db;

    public function __construct() {

        $this->db = new DBHelper();

        // Initialize table names
        $this->tables = (object) [
            'escrows'          => $this->db->tbl_pfx . 'escrowtics_escrows',
            'escrow_meta'      => $this->db->tbl_pfx . 'escrowtics_escrow_meta',
            'transactions_log' => $this->db->tbl_pfx . 'escrowtics_transactions_log',
            'dbbackups'        => $this->db->tbl_pfx . 'escrowtics_dbbackups',
            'notifications'    => $this->db->tbl_pfx . 'escrowtics_notifications',
            'invoices'         => $this->db->tbl_pfx . 'escrowtics_invoices',
        ];
    }

    /**
     * Fetch the last inserted ID from a table.
     */
    public function getLastID($id, $table) {
        $sql = "SELECT $id FROM $table ORDER BY $id DESC LIMIT 1";
        return $this->db->escrotQuery($sql, [], 'var');
    }

    /**
     * Insert data into a database table.
     */
    public function insertData($table, $data) {
        return $this->db->escrotInsert($table, $data);
    }

    /**
     * Update data in a database table.
     */
    public function updateData($table, $data, $where) {
        return $this->db->escrotUpdate($table, $data, $where);
    }

    /**
     * Fetch all rows from the Escrows table.
     */
    public function fetchAllEscrows() {
        $sql = "SELECT * FROM {$this->tables->escrows} ORDER BY escrow_id DESC";
        return $this->db->escrotQuery($sql);
    }
	
	/**
     * Fetch all rows from the Escrow meta table.
     */
    public function fetchAllEscrowMeta() {
        $sql = "SELECT * FROM {$this->tables->escrow_meta} ORDER BY meta_id DESC";
        return $this->db->escrotQuery($sql);
    }

    /**
     * Fetch recent escrows (limit 7).
     */
    public function fetchRecentEscrows() {
        $sql = "SELECT * FROM {$this->tables->escrows} ORDER BY escrow_id DESC LIMIT 7";
        return $this->db->escrotQuery($sql);
    }

    /**
     * Fetch a single escrow by its ID.
     */
    public function getEscrowById($id) {
        $sql = "SELECT * FROM {$this->tables->escrows} WHERE escrow_id = %d";
        return $this->db->escrotQuery($sql, [$id], 'row');
    }

    /**
     * Count total escrows.
     */
    public function getTotalEscrowCount() {
        $sql = "SELECT COUNT(*) FROM {$this->tables->escrows}";
        return $this->db->escrotQuery($sql, [], 'var');
    }
	
	/**
	 * Check if Earner already exist in payer's escrow list.
	 */
	public function earnerExistInPayerList($payer, $earner) {
		$sql = "SELECT COUNT(*) FROM {$this->tables->escrows} WHERE payer = %s AND earner = %s";
		$rowCount = $this->db->escrotQuery($sql, [$payer, $earner], 'var');
		return $rowCount > 0;
	}


    /**
     * Check if an escrow exists by its ID.
     */
    public function escrowExists($id) {
        $sql = "SELECT COUNT(*) FROM {$this->tables->escrows} WHERE escrow_id = %d";
        return $this->db->escrotQuery($sql, [$id], 'var') > 0;
    }

    /**
     * Fetch user data by user ID.
     */
    public function getUserById($id) {
        $user_id = absint($user_id); // Ensure the user ID is an integer.
		$user = get_userdata($user_id);

		if (!$user) {
			return null; // User does not exist.
		}

		// Retrieve user data.
		$user_data = [
			'ID'              => $user->ID,
			'user_login'      => $user->user_login,
			'user_email'      => $user->user_email,
			'first_name'      => $user->first_name,
			'last_name'       => $user->last_name,
			'user_registered' => $user->user_registered,
			'display_name'    => $user->display_name
			
		];

		// Retrieve all user meta.
		$user_meta = get_user_meta($user_id);

		// Flatten meta (to handle single and multiple values properly).
		foreach ($user_meta as $key => $value) {
			$user_meta[$key] = maybe_unserialize($value[0]);
		}

		// Combine user data and meta into one array.
		$combined_data = array_merge($user_data, $user_meta);

		return $combined_data;
    }

    /**
     * Delete an escrow and its associated data.
     */
    public function deleteEscrow($escrow_id) {
        $this->db->escrotDelete($this->tables->escrows, ['escrow_id' => $escrow_id]);
        $this->db->escrotDelete($this->tables->escrow_meta, ['escrow_id' => $escrow_id]);
        $this->db->escrotDelete($this->tables->notifications, ['subject_id' => $escrow_id]);
    }

    /**
     * Delete multiple escrows and their associated data.
     */
    public function deleteEscrows($ids) {
        foreach (explode(',', $ids) as $id) {
            $this->deleteEscrow($id);
        }
    }
	
	
	/**
	 * Count Total Escrow Meta
	 */
	public function getEscrowMetaCount($id) {
		$sql = "SELECT COUNT(*) FROM {$this->tables->escrow_meta} WHERE escrow_id = %d";
		return $this->db->escrotQuery($sql, [$id], 'var');
	}

	
	/**
	 * Fetch Meta by meta ID
	 */
	public function getMetaById($id) {
		$sql = "SELECT * FROM {$this->tables->escrow_meta} WHERE meta_id = %d";
		return $this->db->escrotQuery($sql, [$id], 'row');
	}

	 
	/**
	 * Fetch Escrow Meta by escrow ID
	 */
	public function fetchEscrowMetaById($id) {
		$sql = "SELECT * FROM {$this->tables->escrow_meta} WHERE escrow_id = %d ORDER BY escrow_id DESC";
		return $this->db->escrotQuery($sql, [$id]);
	}

	/**
	 * Delete escrow metadata
	 */
	
	public function deleteEscrowMeta($meta_id) {
		$this->db->escrotDelete($this->tables->escrow_meta, ['meta_id' => $meta_id]);
	}

	// Delete multiple escrow metadata records
	/**
	 * Count Total Escrow Meta
	 */
	public function deleteEscrowMetas($multid) {
		$ids = explode(',', $multid);
		foreach ($ids as $id) {
			$this->deleteEscrowMeta($id);
		}
	}

	 
	/**
	 * Count Total Escrows Per User
	 */
	public function getUserEscrowsCount($username) {
		$sql = "SELECT COUNT(*) FROM {$this->tables->escrows} WHERE payer = %s";
		return $this->db->escrotQuery($sql, [$username], 'var');
	}

	/**
	 * Get User's Escrows
	 */
	public function getUserEscrows($username) {
		$sql = "SELECT * FROM {$this->tables->escrows} WHERE payer = %s";
		return $this->db->escrotQuery($sql, [$username]);
	}

	
	/**
	 * Escrow Search Count
	 */
	public function escrowSearchCount($text) {
		$sql = "SELECT COUNT(*) FROM {$this->tables->escrows} WHERE earner LIKE %s OR payer LIKE %s";
		return $this->db->escrotQuery($sql, ["%$text%", "%$text%"], 'var');
	}

	/**
	 * Escrow Search Data
	 */
	public function escrowSearchData($text) {
		$sql = "SELECT * FROM {$this->tables->escrows} WHERE earner LIKE %s OR payer LIKE %s";
		return $this->db->escrotQuery($sql, ["%$text%", "%$text%"]);
	}


    /**
     * Add a transaction log entry.
     */
    public function logTransaction($data) {
        return $this->insertData($this->tables->transactions_log, $data);
    }

    /**
     * Fetch all transaction logs for admin (user_id = 0).
     */
    public function fetchAdminTransactionLogs() {
        $sql = "SELECT * FROM {$this->tables->transactions_log} WHERE user_id = 0 ORDER BY log_id DESC";
        return $this->db->escrotQuery($sql);
    }

    /**
     * Count all admin transaction logs (user_id = 0).
     */
    public function getAdminTransactionLogCount() {
        $sql = "SELECT COUNT(*) FROM {$this->tables->transactions_log} WHERE user_id = 0";
        return $this->db->escrotQuery($sql, [], 'var');
    }
	
	/**
	 * Delete log
	 */
	
	public function deleteLog($log_id) {
		$this->db->escrotDelete($this->tables->escrow_meta, ['meta_id' => $meta_id]);
	}

	/**
	 * Delete multiple log records
	 */
	public function deleteLogs($multid) {
		$ids = explode(',', $multid);
		foreach ($ids as $id) {
			$this->deleteEscrowMeta($id);
		}
	}

    /**
     * Fetch invoices filtered by product.
     */
    public function fetchInvoices($product) {
        $sql = "SELECT * FROM {$this->tables->invoices} WHERE product = %s ORDER BY id DESC";
        return $this->db->escrotQuery($sql, [$product]);
    }

    /**
     * Count invoices filtered by product.
     */
    public function getInvoiceCount($product) {
        $sql = "SELECT COUNT(*) FROM {$this->tables->invoices} WHERE product = %s";
        return $this->db->escrotQuery($sql, [$product], 'var');
    }
	
	/**
	 * Delete invoice
	 */
	
	public function deleteInvoice($id) {
		$this->db->escrotDelete($this->tables->invoices, ['id' => $id]);
	}

	/**
	 * Delete multiple invoices
	 */
	public function deleteInvoices($multid) {
		$ids = explode(',', $multid);
		foreach ($ids as $id) {
			$this->deleteInvoice($id);
		}
	}
	
	
}
