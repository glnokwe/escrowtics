<?php
	
	
//Escrow Info Form Fields
 $fields = [
    __('Escrow Title', 'escrowtics') => [
        'id' => 'EscrotEscrowTtl',
        'name' => 'title',
        'type' => 'text',
        'placeholder' => __('Enter Escrow Title', 'escrowtics'),
        'div-class' => escrot_is_front_user() ? 'col-md-8' : 'col-md-12',
        'callback' => '',
        'display' => true,
        'help-info' => '',
        'required' => true,
    ],
    __('Amount', 'escrowtics') => [
        'id' => 'EscrotEscrowAmt',
        'name' => 'amount',
        'type' => 'number',
        'placeholder' => __('Enter Transaction Amount', 'escrowtics'),
        'div-class' => escrot_is_front_user() ? 'col-md-4' : 'col-md-6',
        'callback' => '',
        'display' => true,
        'help-info' => '',
        'required' => true,
    ],
    __('Escrow Status', 'escrowtics') => [
        'id' => 'EscrotEscrowST',
        'name' => 'status',
        'type' => 'select',
        'placeholder' => '',
        'div-class' => escrot_is_front_user() ? 'col-md-4' : 'col-md-6',
        'callback' => ['Pending', 'Completed'],
        'display' => escrot_is_front_user() ? false : true,
        'help-info' => '',
        'required' => true,
    ],
    __('Details', 'escrowtics') => [
        'id' => 'EscrotEscrowDetails',
        'name' => 'details',
        'type' => 'textarea',
        'placeholder' => __('Enter Escrow Details', 'escrowtics'),
        'div-class' => 'col-md-12',
        'callback' => '',
        'display' => true,
        'help-info' => '',
        'required' => true,
    ],
];

include ESCROT_PLUGIN_PATH."templates/forms/form-fields/form-fields-manager.php";