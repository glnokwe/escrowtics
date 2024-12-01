<?php 
/**
 * Custom REST API Endpoint class for the plugin
 * Defines REST API endpoints to export specific data
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\api\RestApi;

defined('ABSPATH') || exit;

class RestApi {

    /**
     * Register hooks and REST API routes
     */
    public function register() {
        // Check if REST API is enabled
        if (defined('ESCROT_ENABLE_REST_API') && ESCROT_ENABLE_REST_API) {
            // Register REST API routes
            add_action('rest_api_init', [$this, 'registerRoutes']);
        }

        // Register AJAX actions for API key generation if API Key is enabled
        if (defined('ESCROT_ENABLE_REST_API_KEY') && ESCROT_ENABLE_REST_API_KEY) {
            add_action('wp_ajax_generate_escrot_rest_api_key', [$this, 'generateRestApiKey']);
            add_action('wp_ajax_generate_escrot_rest_api_enpoint_url', [$this, 'generateRestApiUrl']);
        }
    }

    /**
     * Register REST API routes
     */
    public function registerRoutes() {
        register_rest_route(ESCROT_PLUGIN_NAME, '/escrowtics-endpoint-data', [
            'methods'  => \WP_REST_Server::READABLE,
            'callback' => [$this, 'getEscrowticsEndpointData'],
            'permission_callback' => [$this, 'validateApiKey'], // Validate API key
        ]);
    }

    /**
     * Retrieve data for the REST API endpoint
     * 
     * @param \WP_REST_Request $request The REST API request object.
     * @return array|\WP_Error The response data or an error.
     */
    public function getEscrowticsEndpointData(\WP_REST_Request $request) {
        $data = [
            'plugin_name'    => ESCROT_PLUGIN_NAME,
            'plugin_version' => ESCROT_VERSION,
            'plugin_cat'     => 'Economics & Finance',
            'downloads'      => 500,
        ];

        // Filter allowed data keys
        $allowed_keys = ESCROT_REST_API_DATA;
        $data = array_filter($data, function ($key) use ($allowed_keys) {
            return in_array($key, $allowed_keys, true);
        }, ARRAY_FILTER_USE_KEY);

        return rest_ensure_response($data);
    }

    /**
     * Generate a new REST API key for the current user
     */
    public function generateRestApiKey() {
        // Ensure API Key functionality is enabled
        if (!(defined('ESCROT_ENABLE_REST_API_KEY') && ESCROT_ENABLE_REST_API_KEY)) {
            wp_send_json_error(['message' => __('API Key functionality is disabled.', 'escrowtics')], 403);
        }

        // Ensure the request is valid
        if (!current_user_can('edit_user', get_current_user_id())) {
            wp_send_json_error(['message' => __('Unauthorized', 'escrowtics')], 403);
        }

        $api_key = wp_generate_password(32, false); // Generate a secure API key
        update_user_meta(get_current_user_id(), 'api_key', $api_key); // Store the API key in user meta

        wp_send_json_success([
            'message' => __('Key generated successfully.', 'escrowtics'),
            'key'     => $api_key,
        ]);
    }

    /**
     * Generate a REST API endpoint URL
     */
    public function generateRestApiUrl() {
        // Ensure API Key functionality is enabled
        if (!(defined('ESCROT_ENABLE_REST_API_KEY') && ESCROT_ENABLE_REST_API_KEY)) {
            wp_send_json_error(['message' => __('API Key functionality is disabled.', 'escrowtics')], 403);
        }

        // Ensure the request is valid
        if (!current_user_can('edit_user', get_current_user_id())) {
            wp_send_json_error(['message' => __('Unauthorized', 'escrowtics')], 403);
        }

        $url = home_url('/wp-json/' . ESCROT_PLUGIN_NAME . '/escrowtics-endpoint-data?api_key=');
        wp_send_json_success([
            'message' => __('URL generated successfully.', 'escrowtics'),
            'url'     => $url,
        ]);
    }

    /**
     * Validate the API key for REST API requests
     * 
     * @param \WP_REST_Request $request The REST API request object.
     * @return bool|\WP_Error True if valid, or WP_Error otherwise.
     */
    public function validateApiKey(\WP_REST_Request $request) {
        // Ensure API Key functionality is enabled
        if (!(defined('ESCROT_ENABLE_REST_API_KEY') && ESCROT_ENABLE_REST_API_KEY)) {
            return new \WP_Error('api_key_disabled', __('API key functionality is disabled.', 'escrowtics'), ['status' => 403]);
        }

        $api_key = $request->get_header('X-API-Key');

        if (empty($api_key)) {
            return new \WP_Error('missing_api_key', __('API key is required.', 'escrowtics'), ['status' => 403]);
        }

        $user_query = get_users([
            'meta_key'   => 'api_key',
            'meta_value' => $api_key,
            'number'     => 1,
            'fields'     => 'ID',
        ]);

        if (empty($user_query)) {
            return new \WP_Error('invalid_api_key', __('Invalid API key.', 'escrowtics'), ['status' => 403]);
        }

        return true;
    }
}
