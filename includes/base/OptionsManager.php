<?php

/**
 * The options manager class of the plugin.
 * Dynamically adds all setting options, sections, and fields,
 * and creates usable option constants.
 * @since      1.0.0
 * @package    Escrowtics
 */

namespace Escrowtics\base;

defined('ABSPATH') || exit;

use Escrowtics\api\SettingsApi;
use Escrowtics\api\callbacks\OptionsCallbacks;

class OptionsManager extends OptionFields {

    public $settings;
    public $callbacks;

    /**
     * Initialize hooks, settings, sections, and fields
     */
    public function register() {
        $this->settings = new SettingsApi();
        $this->callbacks = new OptionsCallbacks();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->register();
        self::setOptionConstants();

        add_action('wp_ajax_escrot_exp_options', [$this, 'exportOptions']);
        add_action('wp_ajax_escrot_imp_options', [$this, 'importOptions']);
        add_action('wp_ajax_escrot_reset_options', [$this, 'resetOptions']);
        add_action('wp_ajax_escrot_options', [$this, 'sendOptionsToAjax']);
    }

    /**
     * Define settings
     */
    public function setSettings() {
        $args = [
            [
                'option_group' => 'escrowtics_plugin_settings',
                'option_name'  => 'escrowtics_options',
                'callback'     => [$this->callbacks, 'getSanitizedInputs']
            ]
        ];
        $this->settings->setSettings($args);
    }

    /**
     * Define sections
     */
    public function setSections() {
        $args = [];
        foreach ($this->sections as $section) {
            $args[] = [
                'id'    => $section['id'],
                'title' => '<div id="' . esc_attr($section['id']) . '" class="form-group col-md-12"><br>
                            <label><h3>' . esc_html($section['title']) . '</h3></label>
                            </div>',
                'page'  => esc_attr($section['page'])
            ];
        }
        $this->settings->setSections($args);
    }

    /**
     * Define fields
     */
    public function setFields() {
        $args = [];
        foreach ($this->options as $option) {
            $args[] = [
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
                    'icon'        => esc_attr($option['icon'])
                ]
            ];
        }
        $this->settings->setFields($args);
    }

    /**
     * Define option constants based on saved options
     */
    public function setOptionConstants() {
      
		$values = get_option('escrowtics_options');
        
		foreach($this->options as $option) {
			
			$constant = strtoupper('escrot_'.$option['id']);
			
			$cnt_val = !isset($values[$option['id']])? $option['default'] : ( empty($values[$option['id']])? $option['default'] : $values[$option['id']]);
			
			defined($constant) || define($constant, $cnt_val);
		
		}
    }

    /**
     * Export plugin options as JSON
     */
    public function exportOptions() {
		// Check if the user has the required capability
		if (!current_user_can('manage_options')) {
			wp_send_json_error(__('You do not have permission to export options.', 'escrowtics'), 403);
		}

		// Get the options
		$options = get_option('escrowtics_options');

		// Ensure $options is an array
		if (!is_array($options)) {
			wp_send_json_error(__('No options found to export.', 'escrowtics'), 404);
		}

		// Sanitize options before exporting
		$sanitized_options = array_map('sanitize_text_field', $options);

		// Encode options to JSON
		$json_data = wp_json_encode($sanitized_options);

		// Return the JSON data
		wp_send_json_success(['options' => $json_data]);
	}


    /**
     * Import plugin options from a JSON file
     */
    public function importOptions() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('You do not have permission to import options.', 'escrowtics'), 403);
        }

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
     * Reset plugin options to default
     */
    public function resetOptions() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('You do not have permission to reset options.', 'escrowtics'), 403);
        }

        $file_contents = file_get_contents(ESCROT_PLUGIN_PATH."includes/base/default-options.json");
		$options = json_decode($file_contents, true);

		if (json_last_error() === JSON_ERROR_NONE && is_array($options)) {
            update_option('escrowtics_options', $options);
            wp_send_json_success(__('Options restored to defaults successfully.', 'escrowtics'));
        } else {
            wp_send_json_error(__('Problem Resetting, reload page & try again.', 'escrowtics'), 400);
        } 
        
    }

    /**
     * Retrieve options and send them via AJAX
     */
    public function sendOptionsToAjax() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('You do not have permission to view options.', 'escrowtics'), 403);
        }

        $options = get_option('escrowtics_options');
        wp_send_json($options);
    }
	
	
}
