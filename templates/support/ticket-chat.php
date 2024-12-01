<?php
 /**
 * Retrieve admin and user ticket chat
 * @since      1.0.0
 * @package    Escrowtics
 */
?>		
		
		      
<div id="escrot-ticket-chat-frame">
	<div class="content">
		
		<div class="pl-3 h4 contact-profile">
		    <i class="fas fa-comments"></i>
		    <span class="text-dark">Ticket Chat Timeline (Subject: <?= $data['subject']; ?>)</span>
	    </div>

		<div id="escrot-ticket-chat-wrapper" class="escrot-chart-body">
		    <?php 
				include ESCROT_PLUGIN_PATH."templates/support/reload-chat.php"; 
				echo $output; 
		    ?>   
		</div>
		<?php 
			if(is_escrot_front_user()){ 
				$file_label = '
					<label for="escrot-ticket-chat-file-input">
						<i class="fa fa-paperclip attachment text-dark" aria-hidden="true"></i>
					</label>';
				$file_input = '
					<div class="mt-2">
						<div class="fileinput fileinput-new text-center" data-provides="fileinput">
							<div class="fileinput-new thumbnail img-circle"></div>
							<div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
							<div>
								<span class="btn-file">
									<span class="fileinput-new"></span>
									<span class="fileinput-exists btn btn-round btn-primary btn-file btn-sm"><i class="fa fa-fw fa-camera"></i>Change Image</span>
									<input type="file" id="escrot-ticket-chat-file-input" name="attachment" accept="image/jpg,image/jpeg,image/png,image/webp"/>
								</span><br>
								<a href="javascript:;" class="btn btn-danger btn-round fileinput-exists btn-sm" data-dismiss="fileinput">
								<i class="fa fa-times"></i> Remove</a>
							</div>
						</div>
					</div>';
				$form_id = 'escrot-user-ticket-reply-form';	
			} else { 
			   $file_label = '<i class="escrot-chat-attachment fa fa-paperclip attachment text-dark" aria-hidden="true"></i>';
			   $file_input = '<input type="hidden" class="escrot-chat-attachment" name="attachment"/>';
			   $form_id = 'escrot-ticket-reply-form';
			}
		?>
		
		<div class="pl-2 pb-3 pr-3 message-input">
			<div class="wrap">
			  <form class="pt-2"  id="<?= $form_id ?>" enctype="multipart/form-data">
			   <input type="hidden" name="ticket_id" value="<?= $ticket_id; ?>">
			   <input type="hidden" name="action" value="escrot_reply_ticket">
			   <?php wp_nonce_field('escrot_ticket_chat_nonce', 'nonce'); ?>
			   <input class="p-4 mt-1" type="text" name="message" id="escrot-chat-message" placeholder="Type your reply..." />
			    <?= $file_label ?>
			   <button type="submit" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			   <?= $file_input ?>
			   <span class="text-dark float-right well escrot-preview-chat-attach"></span>
			  </form>
			</div>
		</div>
		
	</div>
</div>