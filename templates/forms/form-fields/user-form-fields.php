<?php  
        
		
        $fields  = [ //User Form Fields
		
			'Ajax Action'   =>  [ 
									'id' => 'EscrotUserAjaxAction', 
									'name' => 'action', 
									'type' => 'hidden',  
									'placeholder' => '',
									'div-class' => 'col-md-12', 
									'callback' => 'escrot_insert_user',
									'display' => false,
									'help-info' => '', 
									'required' => false
							    ],
			'Ajax Nonce'    =>  [ 
									'id' => 'EscrotUserAjaxNonce', 
									'name' => 'nonce', 
									'type' => 'hidden',  
									'placeholder' => '',					
									'div-class' => 'col-md-12', 
									'callback' => wp_create_nonce( 'escrot_user_nonce' ),
									'display' => false,
									'help-info' => '', 
									'required' => false
							    ],
			'User ID'       =>  [ 
									'id' => 'EscrotUserID', 
									'name' => 'user_id', 
									'type' => 'hidden',  
									'placeholder' => '',	
									'div-class' => 'col-md-12', 
									'callback' => '',
									'display' => false,
									'help-info' => '',
									'required' => false
							    ],
			'Username'      =>  [ 
									'id' => 'EscrotUserUsername', 
									'name' => 'username', 
									'type' => 'text',  
									'placeholder' => __('Enter username', 'escrowtics'),	
									'div-class' => 'col-md-4', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => true
								],
			'Email'         =>  [ 
									'id' => 'EscrotUserEmail', 
									'name' => 'email', 
									'type' => 'text',  
									'placeholder' => __('Enter Email', 'escrowtics'),	
									'div-class' => 'col-md-4', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => true
							    ],
		    'Password'      =>  [ 
									'id' => 'EscrotUserPass', 
									'name' => 'password', 
									'type' => 'text',  
									'placeholder' => '',	
									'div-class' => 'col-md-4', 
									'callback' => '',
									'display' => $form_type == "add" ? true : false,
									'help-info' => '', 
									'required' => $form_type == "add" ? true : false,
							    ],					
            'First Name'    =>  [ 
									'id' => 'EscrotUserFirstName', 
									'name' => 'firstname', 
									'type' => 'text',  
									'placeholder' => __('Enter First Name',	'escrowtics'),
									'div-class' => 'col-md-4', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => true
							    ],
			'Last Name'     =>  [ 
									'id' => 'EscrotUserLastName', 
									'name' => 'lastname', 
									'type' => 'text',  
									'placeholder' => __('Enter Last Name', 'escrowtics'),
									'div-class' => 'col-md-4', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => true
							    ],
			'Phone'         =>  [ 
									'id' => 'EscrotUserPhone', 
									'name' => 'phone', 
									'type' => 'text',  
									'placeholder' => __('Enter Phone Number', 'escrowtics'),
									'div-class' => 'col-md-4', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],
            'Company'       =>  [ 
									'id' => 'EscrotUserCompany', 
									'name' => 'company', 
									'type' => 'text',  
									'placeholder' => __('Enter Company', 'escrowtics'),
									'div-class' => 'col-md-4', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],
			'Website URL'   =>  [ 
									'id' => 'EscrotUserUrl', 
									'name' => 'website', 
									'type' => 'text',  
									'placeholder' => __('Enter Website URL', 'escrowtics'),
									'div-class' => $form_type == "add" ? 'col-md-4' : 'col-md-8', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],
			'Country'       =>  [ 
									'id' => 'EscrotUserCountry', 
									'name' => 'country', 
									'type' => 'select',  
									'placeholder' => '',
									'div-class' => 'col-md-4', 
									'callback' => escrot_countries(),
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],	
			'Address'       =>  [ 
									'id' => 'EscrotUserAddress', 
									'name' => 'address', 
									'type' => 'text',  
									'placeholder' => __('Enter Address', 'escrowtics'),
									'div-class' => 'col-md-12', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],					
			'User Bio'      =>  [ 
									'id' => 'EscrotUserBio', 
									'name' => 'bio', 
									'type' => 'textarea',  
									'placeholder' => __('Enter Short Bio', 'escrowtics'),
									'div-class' => 'col-md-10', 
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => false
							    ],
            'User Image'    =>  [ 
									'id' => 'EscrotUserImg', 
									'name' => 'user_image', 
									'type' => 'image',  
									'placeholder' => '', 
									'div-class' => 'col-md-2',
									'callback' => '',
									'display' => true,
									'help-info' => '', 
									'required' => false											
							    ]	
        									
										
	    ];
		
		if($form_type == "edit"){ $fields['Ajax Action']['callback'] = 'escrot_update_user'; }//update ajax action field
		
		include ESCROT_PLUGIN_PATH."templates/forms/form-fields/form-fields-manager.php"; 