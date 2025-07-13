<?php

/** 
 * Renders a dispute resolution chat panel
 *
 * @since      1.0.0
 * @package    Escrowtics
**/	

defined('ABSPATH') || exit;

?>
		
		      
<div id="escrot-dispute-chat-frame">
	<div class="content">
		
		<div class="pl-3 h4 contact-profile escrot-rounded-top">
		    <i class="fas fa-comments"></i>
		    <span class="text-dark"><?= __('Dispute Chat Timeline', 'escrowtics'); ?> </span>
	    </div>

		<div id="escrot-dispute-chat-wrapper" class="escrot-chart-body">
		    <?php 
				include ESCROT_PLUGIN_PATH."templates/disputes/reload-chat.php"; 
				echo $output?? ""; 
		    ?>   
		</div>
		<?php 
			if(escrot_is_front_user()){ 
				$file_label = !escrot_option('enable_dispute_evidence')? '' : '
					<label for="escrot-dispute-chat-file-input">
						<i class="fa fa-paperclip attachment text-dark" aria-hidden="true"></i>
					</label>';
				$file_input = !escrot_option('enable_dispute_evidence')? '' : '
					<div class="mt-2">
						<div class="fileinput fileinput-new text-center" data-provides="fileinput">
							<div class="fileinput-new thumbnail img-circle"></div>
							<div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
							<div>
								<span class="btn-file">
									<span class="fileinput-new"></span>
									<span class="fileinput-exists btn btn-round btn-primary btn-file btn-sm"><i class="fa fa-fw fa-camera"></i>Change Image</span>
									<input type="file" id="escrot-dispute-chat-file-input" name="attachment"/>
								</span><br>
								<a href="javascript:;" class="btn btn-danger btn-round fileinput-exists btn-sm" data-dismiss="fileinput">
								<i class="fa fa-times"></i> Remove</a>
							</div>
						</div>
					</div>';
				$form_id = 'escrot-user-dispute-reply-form';	
			} else { 
			   $file_label = '<i class="escrot-chat-attachment fa fa-paperclip attachment text-dark" aria-hidden="true"></i>';
			   $file_input = '<input type="hidden" class="escrot-chat-attachment" name="attachment"/>';
			   $form_id = 'escrot-dispute-reply-form';
			}
		?>
		
		<div class="pl-4 pb-3 pr-3 message-input escrot-rounded-bottom">
			<div class="wrap">
			  <form class="pt-2"  id="<?= $form_id ?>" enctype="multipart/form-data">
			   <input type="hidden" name="dispute_id" value="<?= $dispute_id; ?>">
			   <input type="hidden" name="action" value="escrot_reply_dispute">
			   <?php wp_nonce_field('escrot_dispute_chat_nonce', 'nonce'); ?>
			   <input class="p-4 mt-1" type="text" name="message" id="escrot-chat-message" placeholder="<?= __('Type your reply...', 'escrowtics'); ?>" />
			    <?= $file_label ?>
			   <button type="submit" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			   <?= $file_input ?>
			   <span class="text-dark float-right well escrot-preview-chat-attach"></span>
			  </form>
			</div>
		</div>
		
	</div>
</div>