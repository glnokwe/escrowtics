<?php 
/**
 * Custom REST API Action class for the plugin
 * Defines REST API Actions
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Api\RestApi;

use Escrowtics\Api\RestApi\RestApiEndpoints;

defined('ABSPATH') || exit;

class RestApiActions extends RestApiEndpoints {

	private $endpoints = ['pluginBasicDataEndpoint', 'escrowsEndpoint', 'escrowsMetaEndpoint', 'usersEndpoint'];

	/**
	 * Register hooks and REST API routes
	 */
	public function register() {

		$this->endpoints = apply_filters('escrot_rest_api_endpoints', $this->endpoints);

		if ($this->isInternalRequest() || (defined('ESCROT_ENABLE_REST_API') && ESCROT_ENABLE_REST_API)) {
			foreach ($this->endpoints as $endpoint) {
				if (method_exists($this, $endpoint)) {
					add_action('rest_api_init', [$this, $endpoint]);
				}
			}
		}

		// Register AJAX actions for REST API key & URLs generation
		add_action('wp_ajax_escrot_generate_rest_api_key', [$this, 'generateRestApiKey']);
		add_action('wp_ajax_escrot_generate_rest_api_endpoint_urls', [$this, 'generateRestApiUrl']);
	}
}
