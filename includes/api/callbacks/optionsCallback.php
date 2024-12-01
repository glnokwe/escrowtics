<?php 
/**Options Input Callback class for the plugin
 * Defines all input fields & sanitizations as callbacks
 * @since      1.0.0
 * @package    Escrowtics
 */
	
	namespace Escrowtics\api\callbacks;
	
	defined('ABSPATH') or die();
 
    use Escrowtics\base\OptionFields;
 

    class OptionsCallbacks extends OptionFields {
		
		//Option Field Sanitizer
	    public function getSanitizedInputs( $input ) {
			
		    $output = array();

		    foreach ( $this->options as $option ) {
				
				if($option['callback'] == "checkboxField"){
			        $output[$option['id']] = isset($input[$option['id']]) ? ($input[$option['id']] ? true : false) : false;
				 } elseif ( $option['callback'] == "multSelectField" ) {
					if ( isset( $input[$option['id']] ) && is_array( $input[$option['id']] ) ) {
						$output[$option['id']] = array_map( 'sanitize_text_field', $input[$option['id']] );
					} else {
						$output[$option['id']] = [];
					}
				} else{
					 $output[$option['id']] = isset($input[$option['id']])? sanitize_text_field($input[$option['id']]) : "";
				}
				
		    }
		    return $output;
	    }
	  
		
		
		//Checkbox Manager 
	    public function checkboxField( $args ) {
			
		    $name = $args['label_for'];
			$icon = $args['icon'];
			$option_title = $args['title'];
		    $inpclasses = $args['inpclasses'];
		    $option_name = $args['option_name'];
			$description = $args['description'];
			$divclasses = $args['divclasses'];
		    $checkbox = get_option( $option_name ); 
			$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
			if($checked){ 
			   $status = "checked";
			   $toggContent = '<b class="toggleOn">ON</b>';
			} else {
				$status = "";
				$toggContent = '<b class="toggleOff">OFF</b>';
			}
			
			echo '<div class="text-light ' . $divclasses . '">
				<div class="togglebutton">
					<label>
						<span class="text-light">
							<i class="' . ($icon == "paypal" ? "fa-brands" : "fas") . ' fa-' . $icon . ' sett-icon"></i>&nbsp;' . $option_title . '
						</span>
						<a class="infopop" tabindex="0" data-toggle="popover" data-trigger="focus" 
						   data-placement="right" data-content="' . $description . '" 
						   title="" data-original-title="Help here">Info</a>
					</label>
					<label class="float-right">
						<input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" ' . $status . '>
						<span id="' . $name . '_on_off" class="toggle">' . $toggContent . '</span>
					</label>
				</div>
			 </div>';
	    }
		
		
		
		//Select Field Manager 
	    public function selectField( $args ) {
			
		    $name = $args['label_for'];
			$icon = $args['icon'];
			$option_title = $args['title'];
		    $inpclasses = $args['inpclasses'];
		    $option_name = $args['option_name'];
			$description = $args['description'];
			$divclasses = $args['divclasses'];
		    $value = get_option( $option_name );
	
		    echo ' <div class="'.$divclasses.'">	
                    <label>
					  <span class="text-light"> 
					     <i class="fas fa-'.$icon.' sett-icon"></i>&nbsp; '.$option_title.'
					  </span>
					  <a class="infopop" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="right" 
					data-content="'.$description.'" title="" data-original-title="Help here">Info</a>
				    </label>
	                <select class="form-control" id="'.$name.'" name="'.$option_name.'['.$name.']">';
						    if($name == "timezone"){ $this->timezoneList(); }
						    if($name == "currency"){ $this->currencyList(); }
						    if($name == "theme_class"){ $this->themeColorSchemes(); }
						    if($name == "auto_db_freq"){ $this->dbBackupFreq(); }
						    if($name == "plugin_interaction_mode"){ $this->settingPanelModes(); }
						    if($name == "access_role"){ $this->wpAccessRoles(); }
							if($name == "refid_xter_type"){ $this->refIDXters(); }
							if($name == "admin_nav_style"){ $this->adminNavStyles(); }
							if($name == "escrow_form_style"){ $this->escrowFormStyles(); }
							if($name == "escrot_rest_api_data"){ $this->restApiData(); }
		    echo '  </select>
			       </div>';
	    }
		
		
		//Multiple Select Field Manager 
	    public function multSelectField( $args ) {
			
		    $name = $args['label_for'];
			$icon = $args['icon'];
			$option_title = $args['title'];
		    $inpclasses = $args['inpclasses'];
		    $option_name = $args['option_name'];
			$description = $args['description'];
			$divclasses = $args['divclasses'];
		    $value = get_option( $option_name );
	
		    echo '<div class="'.$divclasses.'">	
                    <label>
					  <span class="text-light"> 
					     <i class="fas fa-'.$icon.' sett-icon"></i>&nbsp; '.$option_title.'
					  </span>
					  <a class="infopop" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="right" 
					data-content="'.$description.'" title="" data-original-title="Help here">Info</a>
				    </label>
	                <select class="form-control" id="' . esc_attr( $name ) . '" name="' . esc_attr( $option_name ) . '[' . esc_attr( $name ) . '][]" multiple>';
							if($name == "escrot_rest_api_data"){ $this->restApiData(); }
		    echo '  </select>
			       </div>';
	    }
		
		
		//Text Field Manager 
		public function textField($args) {
			
			$name = $args['label_for'];
			$icon = $args['icon'];
			$option_title = $args['title'];
		    $inpclasses = $args['inpclasses'];
		    $option_name = $args['option_name'];
			$description = $args['description'];
			$divclasses = $args['divclasses'];
		    $value = get_option( $option_name );
			$placeholder = $args['placeholder'];
			
			echo '<div class="'.$divclasses.'">
                    <label>
				     <span class="text-light"> <i class="fas fa-'.$icon.' sett-icon"></i>&nbsp;  '.$option_title.'</span>
					 <a class="infopop" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="right" 
					data-content="'.$description.'" title="" data-original-title="Help here">Info</a>';
					
					$btns = ["escrot_rest_api_key", "escrot_rest_api_enpoint_url"];
					foreach($btns as $btn){
						$end = explode("_", $btn);
						$tle = end($end);
						if($name == $btn) { echo'		
							<a type="button" id="'.$btn.'_generator" class="btn btn-round btn-outline-info escrot-btn-sm w-auto ml-3 upper-case">Generate '.$tle.'</a>
							</span>'; 
						}
					}	
					
		    echo '</label> 					
	                <input type="text" id="'.$name.'" class="form-control" id="'.esc_attr( $name ).'" name="'.esc_attr( $option_name ).'['.esc_attr( $name ).']" placeholder="'.$placeholder.'" value="'.($value[$name] ?? "").'">
					<div class="well text-danger" id="'.$name.'_notice"></div>';
				if($name == "blockonomics_api_key") { echo'		
					<br><br><span class="text-light">Do not have a key? .. Please get it here &nbsp;<a class="btn btn-round btn-primary escrot-btn-sm" href="https://www.blockonomics.co/api/" target="_blank">Get API Key</a>
			        </span>'; }
				
					
			echo '</div>';
	    }
		
		
		//Color Field Manager 
		public function colourField($args) {
			
			$name = $args['label_for'];
			$icon = $args['icon'];
			$option_title = $args['title'];
		    $inpclasses = $args['inpclasses'];
		    $option_name = $args['option_name'];
			$description = $args['description'];
			$divclasses = $args['divclasses'];
		    $value = get_option( $option_name );
			$placeholder = $args['placeholder'];
			
			echo '<div class="'.$divclasses.'">
                    <label>
				     <span class="text-light"> <i class="fas fa-'.$icon.' sett-icon"></i>&nbsp;   '.$option_title.'</span>
					 <a class="infopop" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="right" 
					data-content="'.$description.'" title="" data-original-title="Help here">Info</a>
		            					
	                <input type="text" id="'.$name.'_val" class="ml-2 border w-25 well float-right" placeholder="#ffffff" value="'.($value[$name] ?? "").'">
					
					<input type="color" id="'.$name.'" class="border float-right"  name="'.$option_name.'['.$name.']" value="'.($value[$name] ?? "").'">
					</label> 
					<div class="well text-danger" id="'.$name.'_notice"></div></div>';
	    }
		
		
		//Text Area Field Manager 
		public function textareaField($args) {
			
			$name = $args['label_for'];
			$icon = $args['icon'];
			$option_title = $args['title'];
		    $inpclasses = $args['inpclasses'];
		    $option_name = $args['option_name'];
			$description = $args['description'];
			$divclasses = $args['divclasses'];
		    $value = get_option( $option_name );
			$plceholder = $args['placeholder'];
			
			$output = '<div class="'.$divclasses.'">
			           <label>
				       <span class="text-light"> <i class="fas fa-'.$icon.' sett-icon"></i>&nbsp; '.$option_title.'</span>
					   <a class="infopop" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="right" 
					    data-content="'.$description.'" title="" data-original-title="Help here">Info</a>
				        </label> 
					  <textarea class="form-control pl-4" id="'.esc_attr( $name ).'" name="'.esc_attr( $option_name ).'['.esc_attr( $name ).']" placeholder="'.$plceholder.'" rows="10">' . ($value[$name] ?? ""). 
			          '</textarea>
				       </div>';
			echo $output;		   
	    }
		
		
		//File Field Manager 
		public function fileField($args) {
			
			$name = $args['label_for'];
			$icon = $args['icon'];
			$option_title = $args['title'];
		    $inpclasses = $args['inpclasses'];
		    $option_name = $args['option_name'];
			$description = $args['description'];
			$divclasses = $args['divclasses'];
		    $value = get_option( $option_name );
			
			echo '<div class="'.$divclasses.'">	
					     <label for="'.$name.'">
						   <span class="text-light"><i class="fas fa-'.$icon.' sett-icon"></i>&nbsp; '.$option_title.'</span>
						   <a class="infopop" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="right" 
					        data-content="'.$description.'" title="" data-original-title="Help here">Info</a>
					     </label> 
					     <div style="text-align: center;" class="col-md-4" style="padding-top: 15px !important;">
                         <div class="fileinput fileinput-new text-center">
                          <div class="fileinput-new thumbnail img-circle '.$name.'-FilePrv">
                            <img class="'.$name.'-PrevUpload" sac="" alt="...">
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail"></div>
                          <div>
                            <span class="btn btn-round btn-primary btn-file btn-sm">
                              <span class="fileinput-new '.$name.' '.$name.'-AddFile">Add Logo</span>
                              <span class="fileinput-exists '.$name.' '.$name.'-ChangeFile">Change Image</span>
                            </span>
                            <br>
                            <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists btn-sm '.$name.'-dismissPic" 
							data-dismiss="fileinput"><i class="fa fa-times"></i> Remove Image</a>
						    <input class="widefat '.$name.'-FileInput" id="'.esc_attr( $name ).'" name="'.esc_attr( $option_name ).'['.esc_attr( $name ).']" type="hidden" value="' . ($value[$name] ?? "").'">
                          </div>
                          </div>
                        </div>
                        </div>';
	    }
		
		
		
		
		
		public function timezoneList() {
			$zones = escrot_timezones();
		 	foreach ($zones as $zone => $title) {
				echo "<option value='".$zone."'>".$title."</option>";
			}
			
		}	
		
		
		public function currencyList() {
		 	$currencies = escrot_currencies();
		 	foreach ($currencies as $currency => $title) {
				echo "<option value='".$currency."'>".$title."</option>";
			}	
			
		}
		
		
		public function wpPages() {
			
		 	do_action('escrot_wp_pages_list');	
			
		}
		
		
		public function themeColorSchemes() {
			
		 	echo '<option style="color: gray !important;" value="dark-edition">Dark Theme (Default)</option>
				 <option style="color: white !important;" value="light-edition">Light Theme </option>';
			
		}
		
		
		public function dbBackupFreq() {
			
		 	echo '<option value="monthly">Monthly</option>
				  <option value="weekly">Weekly</option>
				  <option value="daily">Daily</option>
				  <option value="twicedaily">Twice Daily</option>
				  <option value="hourly">Hourly</option>';
		}
		
		
		public function settingPanelModes() {
			
		 	echo ' <option value="page">Pages & Collapsable Dialogs</option>
			       <option value="modal">Sleek Modal Popups</option>';
				 
		}
		
		
		public function wpAccessRoles() {
			
		 	echo '<option value="administrator">Administrator</option>
				  <option value="editor">Editor</option>
				  <option value="author">Author</option>
				  <option value="contributor">Contributor</option>';
		}
		
		
		public function refIDXters() {
			
		 	echo '<option value="0123456789">Numeric (0123456789)</option>
				  <option value="abcdefghijklmnopqrstuvwxyz">Alpha Lowercase (abcdefghijklmnopqrstuvwxyz)</option>
				  <option value="ABCDEFGHIJKLMNOPQRSTUVWXYZ">Alpha Uppercase (ABCDEFGHIJKLMNOPQRSTUVWXYZ)</option>
				  <option value="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ">
				       Alpha (abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ)
				  </option>
				  <option value="0123456789abcdefghijklmnopqrstuvwxyz">
				       Alphanumeric Lowercase(0123456789abcdefghijklmnopqrstuvwxyz)
				  </option>
				  <option value="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ">
				       Alphanumeric Uppercase(0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ)
				  </option>
				  <option value="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUV    ">
				      Alphanumeric (0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ)
				  </option>';
		}
		
		
		public function adminNavStyles() {
			
		 	echo '<option value="sidebar">Vertical Navigation (Left Sidebar)</option>
			      <option value="top-menu">Horizontal Navigation(Top Menu)</option>
				  <option value="no-menu">No Navigation(Use WP Menu)</option>';
		}
		
		
		public function escrowFormStyles() {
			
		 	echo '<option value="normal">Single Thread</option>
			      <option value="tab">Modern Tabs</option>';
		}
		
		
		public function restApiData() {
			
		 	echo '<option value="plugin_version">Plugin Version</option>
			      <option value="plugin_name">Plugin Name</option>
				  <option value="plugin_developer">Plugin Developer</option>
				  <option value="escrows">Total Escrows</option>
				  <option value="users">Total Users</option>
				  <option value="earners">Total Earners</option>
				  <option value="payers">Total Payers</option>';
		}
		
		
		
		
    }