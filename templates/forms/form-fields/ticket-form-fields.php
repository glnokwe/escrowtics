<?php  
        
		
        $fields  = [ //Ticket Form Fields
		
			'Ajax Action'   =>  [ 
									'id' => 'EscrotTicketAjaxAction', 
									'name' => 'action', 
									'type' => 'hidden',  
									'placeholder' => '',
									'div-class' => 'col-md-12', 
									'callback' => 'escrot_insert_ticket',
									'display' => false,
									'help-info' => '', 
									'required' => false
							    ],
			'Ajax Nonce'    =>  [ 
									'id' => 'EscrotTicketAjaxNonce', 
									'name' => 'nonce', 
									'type' => 'hidden',  
									'placeholder' => '',					
									'div-class' => 'col-md-12', 
									'callback' => wp_create_nonce( 'escrot_ticket_nonce' ),
									'display' => false,
									'help-info' => '', 
									'required' => false
							    ],
			'Ticket ID'     =>  [ 
									'id' => 'EscrotTicketID', 
									'name' => 'ticket_id', 
									'type' => 'hidden',  
									'placeholder' => '',	
									'div-class' => 'col-md-12', 
									'callback' => '',
									'display' => false,
									'help-info' => '',
									'required' => false
							    ],					
			'Subject'       =>  [ 
									'id' => 'EscrotTicketSubject', 
									'name' => 'subject', 
									'type' => 'text',  
									'placeholder' => __('Enter Subject', 'escrowtics'),	
									'div-class' => 'col-md-12', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => true
								],
			'User'      	=>  [ 
									'id' => 'EscrotTicketUser', 
									'name' => 'user', 
									'type' => 'select',  
									'placeholder' => '',  
									'div-class' => 'col-md-4',
									'callback' => escrot_users(),
									'display' => is_escrot_front_user()? false : true,
									'help-info' => '', 
									'required' => true
                                        										  
							    ],						
			'Priority'      =>  [ 
									'id' => 'EscrotTicketPriority', 
									'name' => 'priority', 
									'type' => 'select',  
									'placeholder' => __('Enter Priority', 'escrowtics'),	
									'div-class' => is_escrot_front_user()? 'col-md-6' : 'col-md-4',  
									'callback' => ['Low', 'Medium', 'High'],
									'display' => true,
									'help-info' => '', 
									'required' => true
							    ],
			'Department'    =>  [ 
									'id' => 'EscrotTicketDepartment', 
									'name' => 'department', 
									'type' => 'select',  
									'placeholder' => '',
									'div-class' => is_escrot_front_user()? 'col-md-6' : 'col-md-4',  
									'callback' => ['General Support', 'Escrow Resolution'],
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],					
			'message'       =>  [ 
									'id' => 'EscrotTicketMessage', 
									'name' => 'message', 
									'type' => 'textarea',  
									'placeholder' => '',
									'div-class' =>  is_escrot_front_user()? 'col-md-12' : 'col-md-9', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],
            'Attachment'    =>  [ 
									'id' => 'EscrotAttachment', 
									'name' => 'attachment', 
									'type' => 'image',  
									'placeholder' => '', 
									'div-class' => 'col-md-3',
									'callback' => '',
									'display' =>  is_escrot_front_user()? false : true,
									'help-info' => '', 
									'required' => false											
							    ]								
        									
										
	    ];
		
		if($form_type == "edit"){ $fields['Ajax Action']['callback'] = 'escrot_update_ticket'; }//update ajax action field
		
		include ESCROT_PLUGIN_PATH."templates/forms/form-fields/form-fields-manager.php"; 