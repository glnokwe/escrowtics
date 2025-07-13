<?php
/**
 * The options manager class of the plugin.
 * Dynamically adds all setting options, sections, and fields,
 * and creates usable option constants.
 * 
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\Base;

defined('ABSPATH') || exit;

use Escrowtics\Api\SettingsApi;
use Escrowtics\Api\callbacks\OptionsCallbacks;
use Escrowtics\Base\DefaultOptions;

class OptionsManager {

    private $settings;
    private $callbacks;

    /**
     * Register hooks, settings, sections, and fields.
     */
    public function register() {
		add_action('admin_init', [$this, 'initSettings']);
		add_action('plugins_loaded', [$this, 'defineDualOptionsConstants']);
		add_action('escrot_default_options', [$this, 'setDefaultOptions']);
		$this->registerAjaxActions(); 
    }
	
	
    /**
     * Register AJAX actions.
     */
    private function registerAjaxActions() {
        add_action('wp_ajax_escrot_exp_options', [$this, 'exportOptions']);
        add_action('wp_ajax_escrot_imp_options', [$this, 'importOptions']);
        add_action('wp_ajax_escrot_reset_options', [$this, 'resetOptions']);
        add_action('wp_ajax_escrot_options', [$this, 'sendOptionsToAjax']);
    }
	
	
	/**
     * Initialize settings, sections, and fields.
     */
    public function initSettings() {
		$this->settings  = new SettingsApi();
		$this->callbacks = new OptionsCallbacks();
		
        $this->defineSettings();
        $this->defineSections();
        $this->defineFields();
		
		$this->settings->register();
    }


    /**
     * Define plugin settings.
     */
    private function defineSettings() {
        $args = [
            [
                'option_group' => 'escrowtics_plugin_settings',
                'option_name'  => 'escrowtics_options',
                'callback'     => [$this->callbacks, 'getSanitizedInputs'],
            ],
        ];
        $this->settings->setSettings($args);
    }

    /**
     * Define settings sections.
     */
    private function defineSections() {
        $sections = array_map(function ($section) {
            return [
                'id'    => esc_attr($section['id']),
                'title' => sprintf(
                    '<div id="%s" class="form-group col-md-12"><br><label><h4>%s</h4></label></div>',
                    esc_attr($section['id']),
                    esc_html($section['title'])
                ),
                'page'  => esc_attr($section['page']),
            ];
        }, $this->callbacks->sections());

        $this->settings->setSections($sections);
    }

    /**
     * Define settings fields.
     */
    private function defineFields() {
        $args = array_map(function ($option) {
            return [
                'id'       => esc_attr($option['id']),
                'title'    => '',
                'callback' => [$this->callbacks, $option['callback']],
                'page'     => esc_attr($option['page']),
                'section'  => esc_attr($option['section']),
                'args'     => [
                    'option_name' => 'escrowtics_options',
                    'label_for'   => esc_attr($option['id']),
                    'placeholder' => esc_attr($option['placeholder']),
                    'inpclasses'  => 'ui-toggle',
                    'description' => esc_html($option['description']),
                    'divclasses'  => esc_attr($option['divclasses']),
                    'title'       => esc_html($option['title']),
                    'icon'        => esc_attr($option['icon']),
                ],
            ];
        }, $this->callbacks->fields());

        $this->settings->setFields($args);
    }
	
	
	/**
	*Convert dual options to constants with different 
	*values based on user scope (admin vs frontend)
	*/
	public function defineDualOptionsConstants() {
		$dual_options = ['interaction_mode'];
		foreach($dual_options as $option){
			$value = escrot_is_front_user() 
				? escrot_option($option.'_frontend') 
				: escrot_option($option.'_admin');
				
			$constant = strtoupper('escrot_' . $option);
			defined($constant) || define($constant, $value);
		}
	}
	

    /**
     * Retrieve saved options.
     *
     * @return array Associative array of saved options.
     */
    private function getSavedOptions() {
        return get_option('escrowtics_options', []);
    }

    /**
     * Set default options.
     */
    public function setDefaultOptions() {
        update_option( 'escrowtics_options', DefaultOptions::all() );
    }

    /**
     * Export plugin options as JSON.
     */
    public function exportOptions() {
        escrot_verify_permissions('manage_options');

        $options = $this->getSavedOptions();

        if (empty($options)) {
            wp_send_json_error(__('No options found to export.', 'escrowtics'), 404);
        }

        $sanitized_options = array_map('sanitize_text_field', $options);
        wp_send_json_success(['options' => wp_json_encode($sanitized_options), 'message' => __('Options exported successfully.', 'escrowtics')]);
    }

    /**
     * Import plugin options from a JSON file.
     */
    public function importOptions() {
        escrot_verify_permissions('manage_options');

        if (empty($_FILES['option_file']['tmp_name'])) {
            wp_send_json_error(__('No file uploaded.', 'escrowtics'), 400);
        }

        $file_contents = file_get_contents($_FILES['option_file']['tmp_name']);
        $options = json_decode($file_contents, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($options)) {
            update_option('escrowtics_options', $options);
            wp_send_json_success(__('Options imported successfully.', 'escrowtics'));
        } else {
            wp_send_json_error(__('Invalid JSON file.', 'escrowtics'), 400);
        }
    }

    /**
     * Reset plugin options to default.
     */
    public function resetOptions() {
        escrot_verify_permissions('manage_options');
        $this->setDefaultOptions();
        wp_send_json_success(__('Options restored to defaults successfully.', 'escrowtics'));
    }

    /**
     * Retrieve options and send them via AJAX.
     */
    public function sendOptionsToAjax() {
        escrot_verify_permissions('manage_options');
        wp_send_json($this->getSavedOptions());
    }

	
}
