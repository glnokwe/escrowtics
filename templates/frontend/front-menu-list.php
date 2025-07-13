<?php

/**
 * Frontend navbar Menu List
 * Defines frontend navbar menu elements
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */
 
 defined('ABSPATH') || exit;


// Main Menu
$main_menu = [

    [
        "li-classes" => "",
        "li-id" => "EscrotDashFrontNavItem",
        "active_classes" => esc_attr($active_class['dashboard']),
        "type" => "normal",
        "href" => esc_url($routes['dashboard']),
        "icon" => "gauge-high",
        "title" => __("Dashboard", "escrowtics"),
        "collapse-id" => "",
        "submenus" => [],
    ],
    [
        "li-classes" => "",
        "li-id" => "EscrotEscrowFrontNavItem",
        "active_classes" => esc_attr($active_class['escrow_list'] . $active_class['earning_list'] . $active_class['view_escrow']),
        "type" => "drop-down",
        "href" => "javascript:;",
        "icon" => "filter-circle-dollar",
        "title" => __("Manage Escrow", "escrowtics"),
        "collapse-id" => "EscrotManageEscrowCollapse",
        "submenus" => [
            [
                "li-classes" => "",
                "li-id" => "EscrotCreateEscrowFrontNavItem",
                "type" => "normal",
                "href" => "#",
                "icon" => "add",
                "title" => __("Add Escrow", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
            [
                "li-classes" => "",
                "li-id" => "EscrotEscrowListFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['escrow_list']),
                "icon" => "user-group",
                "title" => __("Escrow List", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
            [
                "li-classes" => "",
                "li-id" => "EscrotEarnerListFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['earning_list']),
                "icon" => "user-group",
                "title" => __("My Earning List", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
        ],
    ],
    [
        "li-classes" => "",
        "li-id" => "EscrotLogFrontNavItem",
        "active_classes" => esc_attr($active_class['transaction_log']),
        "type" => "normal",
        "href" => esc_url($routes['transaction_log']),
        "icon" => "file-invoice-dollar",
        "title" => __("Transaction Log", "escrowtics"),
        "collapse-id" => "",
        "submenus" => [],
    ],
    
	[
        "li-classes" => "",
        "li-id" => "EscrotDepositFrontNavItem",
        "active_classes" => esc_attr($active_class['deposit_history'] . $active_class['deposit_payment_options'] . $active_class['bitcoin_deposit_invoice']),
        "type" => "drop-down",
        "href" => "javascript:;",
        "icon" => "coins",
        "title" => __("Deposit", "escrowtics"),
        "collapse-id" => "EscrotInvoiceCollapse",
        "submenus" => [
            [
                "li-classes" => "",
                "li-id" => "EscrotDepositsFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['deposit_payment_options']),
                "icon" => "add",
                "title" => __("Deposit Money", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
            [
                "li-classes" => "",
                "li-id" => "EscrotWithdrawalsFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['deposit_history']),
                "icon" => "file-invoice-dollar",
                "title" => __("Deposit History", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
        ],
    ],
    [
        "li-classes" => "",
        "li-id" => "EscrotWithdrawFrontNavItem",
        "active_classes" => esc_attr($active_class['withdraw_history'] . $active_class['withdraw_payment_options'] . $active_class['bitcoin_withdraw_invoice']),
        "type" => "drop-down",
        "href" => "javascript:;",
        "icon" => "coins",
        "title" => __("Withdraw", "escrowtics"),
        "collapse-id" => "EscrotInvoiceCollapse",
        "submenus" => [
            [
                "li-classes" => "",
                "li-id" => "EscrotWithdrawsFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['withdraw_payment_options']),
                "icon" => "add",
                "title" => __("Withdraw Money", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
            [
                "li-classes" => "",
                "li-id" => "EscrotWithdrawalsFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['withdraw_history']),
                "icon" => "file-invoice-dollar",
                "title" => __("Withdraw History", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
        ],
    ],
    [
        "li-classes" => "",
        "li-id" => "EscrotDisputeFrontNavItem",
        "active_classes" => esc_attr($active_class['my_disputes']. $active_class['disputes_against_me'] . $active_class['view_dispute']),
        "type" => "drop-down",
        "href" => "javascript:;",
        "icon" => "people-arrows",
        "title" => __("Disputes", "escrowtics"),
        "collapse-id" => "EscrotDisputeCollapse",
        "submenus" => [
            [
                "li-classes" => "",
                "li-id" => "EscrotAddDisputesFrontNavItem",
                "type" => "normal",
                "href" => "#",
                "icon" => "add",
                "title" => __("Open New Dispute", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
            [
                "li-classes" => "",
                "li-id" => "EscrotDisputesFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['my_disputes']),
                "icon" => "arrow-left",
                "title" => __("My Disputes", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
			[
                "li-classes" => "",
                "li-id" => "EscrotDisputesFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['disputes_against_me']),
                "icon" => "arrow-right",
                "title" => __("Disputes Against Me", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
        ],
    ],
	
];

// User Profile Menu
$user_name = strlen($user_data["user_login"]) > 10 ? substr(esc_html($user_data["user_login"]), 0, 10) . '..' : esc_html($user_data["user_login"]);
$user_img = escrot_image($user_data["user_image"], 35, "rounded-circle");

$profile_menu = [
    [
        "li-classes" => "",
        "li-id" => "EscrotUserProfileFrontNavItem",
        "active_classes" => esc_attr($active_class['user_profile']),
        "type" => "drop-down",
        "href" => "javascript:;",
        "icon" => "",
        "title" => $user_img . '<span class="text-capitalize"> ' . $user_name . '</span>',
        "collapse-id" => "EscrotManageEscrowCollapse",
        "submenus" => [
            [
                "li-classes" => "",
                "li-id" => "EscrotMyProfileFrontNavItem",
                "type" => "normal",
                "href" => esc_url($routes['user_profile']),
                "icon" => "user",
                "title" => __("My Profile", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
            [
                "li-classes" => "",
                "li-id" => "EscrotLogOutFrontNavItem",
                "type" => "normal",
                "href" => "#",
                "icon" => "sign-out",
                "title" => __("Log out", "escrowtics"),
                "collapse-id" => "",
                "submenus" => [],
            ],
            [
                "li-classes" => "",
                "li-id" => "EscrotBalanceListFrontNavItem",
                "type" => "normal",
                "href" => "#",
                "icon" => "user_group",
                "title" => __("Balance: ", "escrowtics") . esc_html($user_data["balance"]) . ' ' . escrot_option('currency'),
                "collapse-id" => "",
                "submenus" => [],
            ],
        ],
    ],
	
];
