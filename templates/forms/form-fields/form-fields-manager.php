<?php  

	$output = "";
	
	foreach ($fields as $title => $field) {
		
		$id     = ($form_type == "edit")? "Edit".$field['id'] : $field['id'];
		$div_id = ($form_type == "edit")? "Edit".$field['id']."DivID" : $field['id']."DivID";
		
		//Outer Div
		if($field['display']) { 
			$output .="<div class='form-group ".$field['div-class']."' id='".$div_id."'>"; 
		} else {	
			$output .="<div class='form-group ".$field['div-class']."' id='".$div_id."' style='display: none;'>"; 
		}
			//Label	
			if($field['type'] !== "checkbox" && $field['type'] !== "subheading" && $field['type'] !== "hidden" && $field['type'] !== "image") { 
				$output .=" <label for='".$field['name']."'>".$title;
				if(!empty($field['help-info'])){ $output .="<a class='infopop' tabindex='0' data-toggle='popover' data-trigger='focus' data-placement='right' data-content='".$field['help-info']."' title='' data-original-title='Help here'>Info</a>";}
				$output .="</label>"; 
			}
			if ($field['type'] == "subheading") { $output .=" <h4 for='".$field['name']."'>".$title."</h4>"; }
			
			//inputs
								
			elseif ($field['type'] == "textarea") {
				
				$output .= "<textarea name='".$field['name']."' id='".$id."' class='form-control' rows='4' placeholder='".$field['placeholder']."' ".($field['required']? 'required' : '')."></textarea>";
				
			} elseif ($field['type'] == "select") {
				$output .= "<select name='".$field['name']."' id='".$id."' class='form-control'>";
					if(is_array($field['callback'])) {
						$keys = array_keys($field['callback']);
						
						if($keys !== array_keys($keys) ){//check if associative aaray
							foreach ($field['callback'] as $option => $title) {
								$output .= "<option value='".$option."'>".$title."</option>";
							}
						} else {	
							foreach ($field['callback'] as $option) {
								$output .= "<option value='".$option."'>".$option."</option>";
							}	
						}
					}		
				$output .= "</select>";
				
			} 
								
			elseif ($field['type'] == "radio") {
									
				$options = explode(",", $field['callback']);
				
				foreach ($options as $option) {
					$output .= "<br><input type='radio' name='".$field['name']."' value='".trim($option)."' class='form-control'><span class='text-light radio'>".trim($option)."</span>";
				} 
			
			} elseif ($field['type'] == "checkbox") {
								
				$options = $field['callback'];
					$output .= "
					<div class='togglebutton'>
						<label><span  style='color:  #06accd ;' class='title'>".$title."</span></label>
						<label> <input type='checkbox' id='".$id."' name='".$field['name']."' value='".$option."'>
						<span class='toggle'></span></label><span id='".$id."_setting_on_off'></span>
					</div>";
					
			} elseif ($field['type'] == "file") {
				
				$output .= "
			
				<div class='fileinput fileinput-new text-center' data-provides='fileinput'>
					<div class='fileinput-preview fileinput-exists thumbnail'></div>
				   <div>
					  <span class='btn btn-round escrot-btn-primary btn-file escrot-btn-sm'>
						<span class='fileinput-new'>Add File</span>
						<span class='fileinput-exists'>Change File</span>
					   <input name='".$field['name']."' class='form-control' type='file' accept='application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document'>
					  </span>
					  <br />
					  <a href='javascript:;' class='btn btn-danger btn-round fileinput-exists escrot-btn-sm' data-dismiss='fileinput'><i class='fa fa-times'></i> Remove</a>
					</div>
				  </div>";
				  
			} elseif ($field['type'] == "image") {
				
				$output .= "
				  
				  <div style='text-align: center;' class='col-md-4' style='padding-top: 15px !important;'>
				 <div class='fileinput fileinput-new text-center' data-provides='fileinput'>
				  <div class='fileinput-new thumbnail img-circle ".$id."-FilePrv'>
					<img src='".ESCROT_PLUGIN_URL."assets/img/image_placeholder.jpg' class='".$id."-PrevUpload' alt='...'>
				  </div>
				  <div class='fileinput-preview fileinput-exists thumbnail'></div>
				  <div>
					<span class='btn btn-round escrot-btn-primary btn-file escrot-btn-sm'>
					  <span class='fileinput-new ".$id." ".$id."-AddFile'>Add ".$title."</span>
					  <span class='fileinput-exists ".$id." ".$id."-ChangeFile'>Change Image</span>
					</span>
					<br>
					<a href='javascript:;' class='btn btn-danger btn-round fileinput-exists escrot-btn-sm ".$id."-dismissPic' 
					  data-avatar-url='".ESCROT_PLUGIN_URL."assets/img/image_placeholder.jpg' 
					  data-dismiss='fileinput'><i class='fa fa-times'></i> Remove Image</a>
					<input class='widefat ".$id."-FileInput' id='".$id."' name='".$field['name']."' type='hidden' value=''>
				  </div>
				  </div>
				</div>";
				  
			} else {
				
				$output .= "<input name='".$field['name']."' id='".$id."' class='form-control' type='".$field['type']."'";
				if(!empty($field['placeholder'])) { $output .= " placeholder='".$field['placeholder']."'"; }  
				if(!empty($field['callback'])) { $output .= " value='".$field['callback']."'"; }    
				if($field['type'] == "number"){ $output .= " step='any'"; } 
				
				$output .= "".($field['required']? 'required' : '')."> <div class='well text-danger' id='".$id."_notice'></div>";
			}
	
		$output .="</div><br>"; 
					
	} 
	
		
	echo $output; 