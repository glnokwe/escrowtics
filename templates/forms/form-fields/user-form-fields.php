<?php  
        
		
$fields = [ //User Form Fields

    'Ajax Action' =>  [ 
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
    'Ajax Nonce' =>  [ 
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
    'User ID' =>  [ 
        'id' => 'EscrotUserID', 
        'name' => 'ID', 
        'type' => 'hidden',  
        'placeholder' => '',	
        'div-class' => 'col-md-12', 
        'callback' => '',
        'display' => false,
        'help-info' => '',
        'required' => false
    ],
    __('Username', 'escrowtics') => [ 
        'id' => 'EscrotUserUsername', 
        'name' => 'user_login', 
        'type' => 'text',  
        'placeholder' => __('Enter username', 'escrowtics'),	
        'div-class' => 'col-md-4', 
        'callback' => '',
        'display' => true,
        'help-info' => '', 
        'required' => true
    ],
    __('Email', 'escrowtics') => [ 
        'id' => 'EscrotUserEmail', 
        'name' => 'user_email', 
        'type' => 'text',  
        'placeholder' => __('Enter Email', 'escrowtics'),	
        'div-class' => 'col-md-4', 
        'callback' => '',
        'display' => true,
        'help-info' => '', 
        'required' => true
    ],
    __('Password', 'escrowtics') => [ 
        'id' => 'EscrotUserPass', 
        'name' => 'user_pass', 
        'type' => 'text',  
        'placeholder' => '',	
        'div-class' => 'col-md-4', 
        'callback' => '',
        'display' => $form_type == "add" ? true : false,
        'help-info' => '', 
        'required' => $form_type == "add" ? true : false,
    ],					
    __('First Name', 'escrowtics') => [ 
        'id' => 'EscrotUserFirstName', 
        'name' => 'first_name', 
        'type' => 'text',  
        'placeholder' => __('Enter First Name', 'escrowtics'),
        'div-class' => 'col-md-4', 
        'callback' => '',
        'display' => true,
        'help-info' => '', 
        'required' => true
    ],
    __('Last Name', 'escrowtics') => [ 
        'id' => 'EscrotUserLastName', 
        'name' => 'last_name', 
        'type' => 'text',  
        'placeholder' => __('Enter Last Name', 'escrowtics'),
        'div-class' => 'col-md-4', 
        'callback' => '',
        'display' => true,
        'help-info' => '', 
        'required' => true
    ],
    __('Phone', 'escrowtics') => [ 
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
    __('Company', 'escrowtics') => [ 
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
    __('Website', 'escrowtics') => [ 
        'id' => 'EscrotUserUrl', 
        'name' => 'user_url', 
        'type' => 'text',  
        'placeholder' => __('Enter Website URL', 'escrowtics'),
        'div-class' => $form_type == "add" ? 'col-md-4' : 'col-md-8', 
        'callback' => '',
        'display' => true,
        'help-info' => '', 
        'required' => false
    ],
    __('Country', 'escrowtics') => [ 
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
    __('Address', 'escrowtics') => [ 
        'id' => 'EscrotUserAddress', 
        'name' => 'address', 
        'type' => 'text',  
        'placeholder' => __('Enter Address', 'escrowtics'),
        'div-class' => 'col-md-10', 
        'callback' => '',
        'display' => true,
        'help-info' => '', 
        'required' => false
    ],	
    __('Status', 'escrowtics') => [ 
        'id' => 'EscrotUserStatus', 
        'name' => 'status', 
        'type' => 'select',  
        'placeholder' => '',
        'div-class' => 'col-md-2', 
        'callback' => [ 1 => __('Active User', 'escrowtics'), 0 => __('Inactive User', 'escrowtics') ],
        'display' => true,
        'help-info' => '', 
        'required' => false
    ],					
    __('User Bio', 'escrowtics') => [ 
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
    __('User Image', 'escrowtics') => [ 
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

if($form_type == "edit"){ //update ajax action field
	$fields['Ajax Action']['callback'] = 'escrot_update_user'; 
}
include ESCROT_PLUGIN_PATH."templates/forms/form-fields/form-fields-manager.php"; 