<?php 
/**
 * Custom REST API Endpoint class for the plugin
 * Defines REST API endpoints to export specific data
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\RestApi;

use Escrowtics\Database\EscrowDBManager;
use Escrowtics\Database\UsersDBManager;
use WP_REST_Request;

defined('ABSPATH') || exit;

class RestApiEndpoints {

	private $escrow;
	private $user;

	public function __construct() {
		$this->escrow = new EscrowDBManager();
		$this->user   = new UsersDBManager();
	}

	/**
	 * Register basic plugin data endpoint.
	 */
	public function pluginBasicDataEndpoint() {
		register_rest_route(ESCROT_PLUGIN_NAME . '/v1', '/basic-plugin-data', [
			'methods'  => 'GET',
			'callback' => [$this, 'getBasicPluginData'],
			'permission_callback' => function() {
				return $this->checkApiAccess('plugin_basics');
			},
		]);
	}

	public function escrowsEndpoint() {
		register_rest_route(ESCROT_PLUGIN_NAME . '/v1', '/escrow-data', [
			'methods'  => 'GET',
			'callback' => [$this, 'getAllEscrows'],
			'permission_callback' => function() {
				return $this->checkApiAccess('ecrows');
			},
		]);
	}

	public function escrowsMetaEndpoint() {
		register_rest_route(ESCROT_PLUGIN_NAME . '/v1', '/escrow-meta-data', [
			'methods'  => 'GET',
			'callback' => [$this, 'getAllEscrowMeta'],
			'permission_callback' => function() {
				return $this->checkApiAccess('ecrows');
			},
		]);
	}

	public function usersEndpoint() {
		register_rest_route(ESCROT_PLUGIN_NAME . '/v1', '/user-data', [
			'methods'  => 'GET',
			'callback' => [$this, 'getAllUsers'],
			'permission_callback' => function() {
				return $this->checkApiAccess('users');
			},
		]);
	}

	/**
	 * Checks if API access is allowed.
	 *
	 * @param string $data_type
	 * @return bool|\WP_Error
	 */
	public function checkApiAccess($data_type = 'ecrows') {
		if ($this->isInternalRequest()) {
			return true;
		}

		$data_types = escrot_option('rest_api_data');
		if (!in_array($data_type, $data_types)) {
			return new \WP_Error('missing_api_key', __('Access to requested data has been restricted.', 'escrowtics'), ['status' => 403]);
		}

		if (escrot_option( 'enable_rest_api_key' )) {
			return true;
		}

		return $this->validateApiKey();
	}

	/**
	 * Check if request is internal.
	 *
	 * @return bool
	 */
	protected function isInternalRequest() {
		$server_host  = parse_url(home_url(), PHP_URL_HOST);
		$request_host = $_SERVER['HTTP_HOST'] ?? '';
		return $server_host === $request_host || $_SERVER['REMOTE_ADDR'] === '127.0.0.1';
	}

	/**
	 * Get all escrow data.
	 */
	public function getAllEscrows() {
		$escrows       = $this->escrow->fetchAllEscrows();
		$escrows_count = $this->escrow->getTotalEscrowCount();

		return rest_ensure_response([
			'escrows'        => $escrows,
			'escrows_count'  => $escrows_count,
		]);
	}

	/**
	 * Get all escrow meta data.
	 */
	public function getAllEscrowMeta() {
		$escrow_meta        = $this->escrow->fetchAllEscrowMeta();
		$escrows_meta_count = $this->escrow->getEscrowMetaCount();

		return rest_ensure_response([
			'escrows_meta'        => $escrow_meta,
			'escrows_meta_count'  => $escrows_meta_count,
		]);
	}

	/**
	 * Get all user data.
	 */
	public function getAllUsers() {
		$users       = $this->user->getAllUsers();
		$users_count = $this->user->getTotalUserCount();

		return rest_ensure_response([
			'users'        => $users,
			'users_count'  => $users_count,
		]);
	}

	/**
	 * Get basic plugin info.
	 */
	public function getBasicPluginData() {
		return rest_ensure_response([
			'plugin_name'    => ESCROT_PLUGIN_NAME,
			'plugin_version' => ESCROT_VERSION,
			'plugin_author'  => 'Ngunyi Yannick',
		]);
	}

	/**
	 * Generate REST API key for current user.
	 */
	public function generateRestApiKey() {
		escrot_verify_permissions('manage_options');

		/* if ( escrot_option( 'enable_rest_api' ) ) {
			wp_send_json_error(['message' => __('REST API functionality is disabled.', 'escrowtics')]);
		} */

		if (!current_user_can('edit_user', get_current_user_id())) {
			wp_send_json_error(['message' => __('Unauthorized', 'escrowtics')], 403);
		}

		$api_key = wp_generate_password(32, false);
		update_user_meta(get_current_user_id(), 'api_key', $api_key);

		wp_send_json_success([
			'message' => __('Key generated successfully.', 'escrowtics'),
			'key'     => $api_key,
		]);
	}

	/**
	 * Generate a set of endpoint URLs.
	 */
	public function generateRestApiUrl() {
		escrot_verify_permissions('manage_options');

		if (escrot_option( 'enable_rest_api' )) {
			wp_send_json_error(['message' => __('REST API functionality is disabled.', 'escrowtics')]);
		}

		$urls = "";
		$rest_urls = [
			'Basic Plugin data'   => 'basic-plugin-data',
			'Escrow Data'         => 'escrow-data',
			'Escrow Meta Data'    => 'escrow-meta-data',
			'User Data'           => 'user-data',
		];

		foreach ($rest_urls as $title => $slug) {
			$urls .= $title . ': ' . home_url('/wp-json/' . ESCROT_PLUGIN_NAME . '/v' . ESCROT_VERSION . '/' . $slug) . ', ' . PHP_EOL;
		}

		wp_send_json_success([
			'message' => __('URLs generated successfully.', 'escrowtics'),
			'url'     => $urls,
		]);
	}

	/**
	 * Validate the API key.
	 *
	 * @return bool|\WP_Error
	 */
	public function validateApiKey() {
		$api_key = $_SERVER['HTTP_X_API_KEY'] ?? '';

		if (empty($api_key) || $api_key !== escrot_option( 'rest_api_key' ) ) {
			return new \WP_Error('invalid_api_key', __('Invalid API key.', 'escrowtics'), ['status' => 403]);
		}

		return true;
	}
}
