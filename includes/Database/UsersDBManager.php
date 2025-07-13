<?php
/**
 * The Users Database Interaction class of the plugin.
 * Handles all database interactions for user-related actions.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Database;

defined('ABSPATH') || exit;

class UsersDBManager
{
    protected $tables;
    private   $db;

    /**
     * Constructor to initialize table names with the WordPress table prefix.
     */
    public function __construct() {
		
		$this->db = new DBHelper();

        $this->tables = (object)[
            'escrows'          => $this->db->tbl_pfx . 'escrowtics_escrows',
            'escrowMeta'       => $this->db->tbl_pfx . 'escrowtics_escrow_meta',
            'transactionsLog'  => $this->db->tbl_pfx . 'escrowtics_transactions_log',
            'notifications'    => $this->db->tbl_pfx . 'escrowtics_notifications',
            'users'            => $this->db->tbl_pfx . 'escrowtics_users',
            'invoices'         => $this->db->tbl_pfx . 'escrowtics_invoices',
            'disputes'         => $this->db->tbl_pfx . 'escrowtics_disputes',
            'disputeMeta'      => $this->db->tbl_pfx . 'escrowtics_disputes_meta',
        ];
    }
	
	
	/**
     * Count total number of escrowtics users.
     *
     * @return int Total user count.
     */
	
	public function getTotalUserCount() {
		$user_counts = count_users();

		// Check if the role exists in the counts
		if (isset($user_counts['avail_roles']['escrowtics_user'])) {
			return $user_counts['avail_roles']['escrowtics_user'];
		}

		// If no users with the role exist, return 0
		return 0;
	}
	
	
	/**
	 * Fetch all WordPress users with the specified role, including their meta data.
	 *
	 * Combines user data and meta data fields into a single array for each user.
	 * This method retrieves all users with the role 'escrowtics_user' and merges
	 * their user data with their meta data.
	 *
	 * @return array List of users with combined data and meta fields.
	 */
	public function getAllUsers(){
		$args = [
			'role'    => 'escrowtics_user',
			'orderby' => 'ID',      
			'order'   => 'ASC',  
		];

		$user_query = new \WP_User_Query($args);

		// Check if there are any results.
		if (!empty($user_query->get_results())) {
			// Get the results as an array of WP_User objects.
			$users = $user_query->get_results();
			$users_with_data_and_meta = [];

			foreach ($users as $user) {
				// Get user meta data as an associative array.
				$user_meta = get_user_meta($user->ID);

				// Flatten meta data (remove nested arrays).
				$flattened_meta = [];
				foreach ($user_meta as $key => $value) {
					$flattened_meta[$key] = maybe_unserialize($value[0]);
				}

				// Combine user data and meta data.
				$combined_data = array_merge(
					[
						'ID'              => $user->ID,
						'user_login'      => $user->user_login,
						'user_email'      => $user->user_email,
						'first_name'      => $user->first_name,
						'last_name'       => $user->last_name,
						'display_name'    => $user->display_name,
						'user_registered' => $user->user_registered,
						'role'            => 'escrowtics_user'
					],
					$flattened_meta
				);

				$users_with_data_and_meta[] = $combined_data;
			}

			return $users_with_data_and_meta;
		} else {
			return []; // Return an empty array if no users are found.
		}
	}



    /**
     * Insert a user.
     *
     * @param array $data Associative array of user data.
     * @param array $meta_data Associative array of user meta data.
     * @return int|false Inserted row ID or false on failure.
     */
    public function insertUser($user_data, $meta_data){
			
		$user_id = wp_insert_user($user_data);

		if (is_wp_error($user_id)) {
			wp_send_json_error(['message'=> $user_id->get_error_message()]);
		}	
		//User Meta Data
		foreach ( $meta_data as $key => $value ) {
			update_user_meta( $user_id, $key, $value );
		}
    }


    /**
     * Fetch user info by ID.
     *
     * @param int $id User ID.
     * @return array|null User data or null if not found.
     */
    public function getUserById($user_id){
    
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
			'user_url'        => $user->user_url,
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
	 * Update a user's data and meta.
	 *
	 * @param int   $user_id The ID of the user to update.
	 * @param array $user_data Associative array of user data to update.
	 * @param array $meta_data Associative array of user meta fields to update.
	 * @return bool|WP_Error True on success, WP_Error on failure.
	 */
    public function updateUser($user_id, $user_data = [], $meta_data = []) {
		$user_id = absint($user_id); // Ensure the user ID is valid.

		if (!$user_id || !get_userdata($user_id)) {
			return;
		}

		// Update user data.
		$user_data['ID'] = $user_id; // ID is required for wp_update_user().
		$result = wp_update_user($user_data);

		if (is_wp_error($result)) {
			return $result; // Return WP_Error if user update fails.
		}

		// Update user meta data.
		foreach ($meta_data as $meta_key => $meta_value) {
			update_user_meta($user_id, $meta_key, $meta_value);
		}

		return true;
    }

    /**
     * Delete a user.
     *
     * @param int $userId User ID to delete.
     * @return void
     */
    public function deleteUser($user_id){

        $user_id = absint($user_id);
		$username = get_user_by( 'ID', $user_id )->user_login;
		
		wp_delete_user($user_id);
        $this->db->escrotDelete($this->tables->escrows, ['payer' => $username]);
		$this->db->escrotDelete($this->tables->escrows, ['earner' => $username]);
        $this->db->escrotDelete($this->tables->notifications, ['subject_id' => $user_id]);
    }

    /**
     * Delete multiple users.
     *
     * @param string $userIds Comma-separated list of user IDs.
     * @return void
     */
    public function deleteUsers($user_ids)
    {
        $ids = array_map('absint', explode(',', $user_ids));

        foreach ($ids as $id) {
            $this->deleteUser($id);
        }
    }

    /**
     * Verify if user already.
     *
     * @param string $field Indentifier(user_login||user_email) to check.
     * @return string "taken" or "not_taken".
     */
    public function verifyUser($field){
		$user_id = username_exists($field);
		if(is_email($field)){
			$user_id = email_exists($field);
		} 

		if ($user_id) {
			echo 'taken';
		} else {
			echo 'not_taken';
		}
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
	 * Retrieves the details of a specific dispute based on the dispute ID.
	 *
	 * @param int $id The ID of the dispute to retrieve.
	 * @return array|null The dispute information as an associative array, or null if not found.
	 */
	public function getDisputeById($dispute_id)
	{
		$sql = "SELECT * FROM {$this->tables->disputes} WHERE dispute_id = %d";
		return $this->db->escrotQuery($sql, [$dispute_id], 'row');
	}

	
	/**
	 * Retrieves metadata associated with a specific dispute by dispute ID.
	 *
	 * @param int $id The ID of the dispute to retrieve metadata for.
	 * @return array An array of metadata records for the dispute.
	 */
	public function getDisputeMetaById($dispute_id){
		$sql = "SELECT * FROM {$this->tables->disputeMeta} WHERE dispute_id = %d";
		return $this->db->escrotQuery($sql, [$dispute_id]);
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
	 * Counts the total number of escrows associated with a specific user as the payer.
	 *
	 * @param string $username The username of the payer.
	 * @return int The total count of escrows.
	 */
	public function getUserEscrowsCount($username){
		$sql = "SELECT COUNT(*) FROM {$this->tables->escrows} WHERE payer = %s";
		return $this->db->escrotQuery($sql, [$username], 'var');
	}
	
	
	
    /**
     * Fetch all user escrows.
     *
     * @param string $username Username.
     * @return array List of escrow records.
     */
    public function getUserEscrows($username){
        $sql = "SELECT * FROM {$this->tables->escrows} WHERE payer = %s";
		return $this->db->escrotQuery($sql);
    }

	
	/**
	 * Counts the total number of escrows where a specific user is listed as the earner.
	 *
	 * @param string $username The username of the earner.
	 * @return int The total count of earnings.
	 */
	public function getUserEarningsCount($username){
		$sql = "SELECT COUNT(*) FROM {$this->tables->escrows} WHERE earner = %s";
		return $this->db->escrotQuery($sql, [$username], 'var');
	}

	
	/**
	 * Retrieves all escrows where a specific user is listed as the earner.
	 *
	 * @param string $username The username of the earner.
	 * @return array An array of escrow records where the user is the earner.
	 */
	public function getUserEarnings($username){
		$sql = "SELECT * FROM {$this->tables->escrows} WHERE earner = %s";
		return $this->db->escrotQuery($sql, [$id]);
	}

	
	/**
	 * Counts the number of metadata records associated with a specific escrow ID.
	 *
	 * @param int $id The escrow ID to count metadata for.
	 * @return int The total count of metadata records.
	 */
	public function getEscrowMetaCount($escrow_id){
		$sql = "SELECT COUNT(*) FROM {$this->tables->escrowMeta} WHERE escrow_id = %d";
		return $this->db->escrotQuery($sql, [$escrow_id], 'var');
	}


	/**
	 * Retrieves metadata records associated with a specific escrow ID.
	 *
	 * @param int $id The escrow ID to retrieve metadata for.
	 * @return array An array of metadata records for the escrow.
	 */
	public function fetchEscrowMetaById($id){
		$sql = "SELECT * FROM {$this->tables->escrowMeta} WHERE escrow_id = %d";
		return $this->db->escrotQuery($sql, [$id]);
	}

	
	/**
	 * Retrieves the transaction log for the current logged-in user.
	 *
	 * @return array An array of transaction log records for the user.
	 */
	public function getUserTransactionLog(){
		$sql = "SELECT * FROM {$this->tables->transactionsLog} WHERE user_id = %d ORDER BY log_id DESC";
		return $this->db->escrotQuery($sql, [get_current_user_id()]);
	}

	
	/**
	 * Counts the total number of transaction log records for the current logged-in user.
	 *
	 * @return int The total count of transaction log records.
	 */
	public function getUserTransactionLogCount(){
		$sql = "SELECT COUNT(*) FROM {$this->tables->transactionsLog} WHERE user_id = %d";
		return $this->db->escrotQuery($sql, [get_current_user_id()], 'var');
	}
	
	
	/**
	 * Counts the total number of invoices for a specific user, filtered by product.
	 *
	 * @param string $subject The product name to filter invoices by.
	 * @return int The total count of filtered invoices.
	 */
	public function getUserFilteredInvoicesCount($subject){
		$sql = "SELECT COUNT(*) FROM {$this->tables->invoices} WHERE user_id = %d AND product = %s";
		return $this->db->escrotQuery($sql, [get_current_user_id(), $subject], 'var');
	}
	
	
	/**
	 * Retrieves filtered invoices for the current logged-in user based on a specific product (doposit or withdrawal).
	 *
	 * @param string $subject The product name to filter invoices by.
	 * @return array An array of invoice records matching the filter criteria.
	 */
	public function getUserFilteredInvoices($subject){
		$sql = "SELECT * FROM {$this->tables->invoices} WHERE user_id = %d AND product = %s ORDER BY id DESC";
		return $this->db->escrotQuery($sql, [get_current_user_id(), $subject]);
	}




}
