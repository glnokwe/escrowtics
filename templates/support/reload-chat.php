<?php
 /**
 * Reload Ticket chat
 * @since      1.0.0
 * @package    Escrowtics
 */

$img_exts = ["jpg", "jpeg", "png", "webp"];
	  
$output .= '<div class="p-5 messages text-dark">
	<ul>';
		foreach($ticket_meta as $meta) {
									
			if($meta["author"] == "User") {
				$user_img = escrot_single_user_data('user_image', 'username', $data['user']);	
				$output .= '<li class="sent">
				'.escrot_image($user_img, '50', 'escrot-rounded').'
				<p  style="font-size: 13px !important"><span class="small text-gray"><i class="fa fa-user"></i> '.$data["user"].'</span><br><br>';
				if($meta["meta_type"] =="File"){
					$file_name = explode("/", $meta["meta_value"]);
					$file_name = end($file_name);
					$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
					if(in_array($file_ext, $img_exts)){	
					   $output .= '<img class="escrot-img-preview" src="'.$meta["meta_value"].'"/><br>
					   <span><a href="'.$meta["meta_value"].'" target="_blank">view image</a></span>';
					} elseif($file_ext == "pdf") {
						$output .= '
						<a href="'.$meta["meta_value"].'" target="_blank">'.
							escrot_image(ESCROT_PLUGIN_URL.'assets/img/pdf-file-icon.png', '50', 'rounded-0').$file_name.
						'</a>';
					} else {
						$output .= '
						<a href="'.$meta["meta_value"].'" target="_blank">'.
							escrot_image(ESCROT_PLUGIN_URL.'assets/img/file-icon.png', '50', 'rounded-0').$file_name.
						'</a>';
					}
				} else {								
					$output .= $meta["meta_value"];
				}
				$output .= '<br><br><span style="color: #87a1ac !important;" class="small"><i class="fa fa-clock"></i> '.$meta["creation_date"].'</span></p></li>';
			} else {        	
				$output .= '<li class="replies">'
					.escrot_image(ESCROT_PLUGIN_URL.'assets/img/escrowtics.png', '50', 'escrot-rounded').'
					<p style="font-size: 13px !important"><span class="small text-gray float-right"><i class="fa fa-user"></i> Admin</span><br><br>';	
					if($meta["meta_type"] =="File"){
						$file_name = explode("/", $meta["meta_value"]);
						$file_name = end($file_name);
						$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
						if(in_array($file_ext, $img_exts)){	
						   $output .= '<img class="escrot-img-preview" src="'.$meta["meta_value"].'"/><br>
						   <span><a href="'.$meta["meta_value"].'" target="_blank">view image</a></span>';
						} elseif($file_ext == "pdf") {
							$output .= '
							<a href="'.$meta["meta_value"].'" target="_blank">'.
								escrot_image(ESCROT_PLUGIN_URL.'assets/img/pdf-file-icon.png', '50', 'rounded-0').$file_name.
							'</a>';
						} else {
							$output .= '
							<a href="'.$meta["meta_value"].'" target="_blank">'.
								escrot_image(ESCROT_PLUGIN_URL.'assets/img/file-icon.png', '50', 'rounded-0').$file_name.
							'</a>';
						}
					} else {								
						$output .= $meta["meta_value"];
					}
				$output .= '<br><br><span style="color: #87a1ac !important;" class="small">
				<i class="fa fa-clock"></i> '.$meta["creation_date"].'</span></p></li>';
			}
		}										
$output .= '</ul></div>';
