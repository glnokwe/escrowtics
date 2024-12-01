<?php

/**
 * Admin Screen Options class
 * Defines Admin Screen Options.
 * @since      1.0.0
 * @package    Escrowtics
 */
	
	namespace Escrowtics;
	
	defined('ABSPATH') or die();

    class AdminScreenOptions {
		
		
		public $admin_page = 'toplevel_page_escrowtics-escrows';

		public function register() {
			add_action( "load-$this->admin_page", [ $this, 'register_options' ] );
			add_filter( 'screen_settings', [ $this, 'show_screen_options' ], 10, 2 );
		}
		
	
		
		//Define screen options.
		public function options() {
			return [
				'earner',	
				'payer',
				'created'
			];
	    }
		
		
	   //Create an array of options/title
		private function screen_options() {
			$screen_options = [];

			foreach ( $this->options() as $option_name ) {
				$screen_options[] = [
					'option' => $option_name,
					'title'  => ucwords( strtr($option_name, ['_'=>' ']) ),
				];
			}
			return $screen_options;
		}
		
		
		
		//Register the screen options.
		public function register_options() {
			$screen = get_current_screen();

			if ( ! is_object( $screen ) || $this->admin_page !== $screen->id ) {
				return;
			}

			// Loop through all the options and add a screen option for each.
			foreach ( $this->options() as $option_name ) {
				add_screen_option( "escrot_so_$option_name", [
					'option'  => $option_name,
					'value'   => true,
				] );
			}
		}

		

		//Display a screen option.
		public function show_option( $title, $option ) {
		
		    $screen = get_current_screen();
		    $id = "escrot_so_$option";
			$checked = $screen->get_option( $id, 'value' ) ? "checked" : "";
			
			echo '<label for="'.$id.'">
			           <input type="checkbox" name="escrot_so['.$option.']" class="escrot-so" id="'.$id.'" '.$checked.'/>
					   '. __($title,   'escrowtics').'
					</label>';
		}
		
		

		//Render the screen options block.
		public function show_screen_options( $status, $args ) {
			if ( $this->admin_page !== $args->base ) {
				return $status;
			}

			ob_start();
            echo "<h4 class='text-light'>".__( 'Escrowtics Transactions Screen Options (Hide/Show Table Columns)', 'escrowtics' )."</h4>";
			foreach ( $this->screen_options() as $screen_option ) {
				$this->show_option( $screen_option['title'], $screen_option['option'] );
			}
			return ob_get_clean();
		}
		
		
    }

