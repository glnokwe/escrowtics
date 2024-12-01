<?php


	$main_menu = [
			[
			 "li-classes" => "",  
			 "li-id" => "EscrotDashFrontNavItem",
			 "active_classes" => $active_class['dashboard'],
			 "type" => "normal",
			 "href" => $routes['dashboard'],
			 "icon" => "gauge-high",
			 "title" => __("Dashboard", "escrowtics"),
			 "collapse-id" => "",
			 "submenus" => []
			],
			
			[
			 "li-classes" => "",  
			 "li-id" => "EscrotEscrowFrontNavItem",
			 "active_classes" => $active_class['escrow_list'].$active_class['earning_list'].$active_class['view_transaction'],
			 "type" => "drop-down",
			 "href" => "javascript:;",
			 "icon" => "circle-dollar-to-slot",
			 "title" => __("Manage Escrow", "escrowtics"),
			 "collapse-id" => "EscrotManageEscrowCollapse",
			 "submenus" => [
							[
							  "li-classes" => "",  
							  "li-id" => "EscrotCreateEscrowFrontNavItem",
							  "type" => "normal",
							  "href" => $routes['escrow_list'],
							  "icon" => "user",
							  "title" => __("Create Escrow", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							],
							[
							  "li-classes" => "",  
							  "li-id" => "EscrotEscrowListFrontNavItem",
							  "type" => "normal",
							  "href" => $routes['escrow_list'],
							  "icon" => "user_group",
							  "title" => __("Escrow List", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							],
							[
							  "li-classes" => "",  
							  "li-id" => "EscrotEarnerListFrontNavItem",
							  "type" => "normal",
							  "href" => $routes['earning_list'],
							  "icon" => "user_group",
							  "title" => __("My Earning List", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							]
						]
			],
			
			[
			 "li-classes" => "",  
			 "li-id" => "EscrotLogFrontNavItem",
			 "active_classes" => $active_class['transaction_log'],
			 "type" => "normal",
			 "href" => $routes['transaction_log'],
			 "icon" => "file-invoice-dollar",
			 "title" => __("Transaction Log", "escrowtics"),
			 "collapse-id" => "",
			 "submenus" => []
			],
			
			[
			 "li-classes" => "",  
			 "li-id" => "EscrotDepositFrontNavItem",
			 "active_classes" => $active_class['deposit_history'].$active_class['deposit_payment_options'].$active_class['bitcoin_deposit_invoice'],
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
							  "href" => $routes['deposit_payment_options'],
							  "icon" => "add",
							  "title" => __("Deposit Money", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							],
							[
							  "li-classes" => "",  
							  "li-id" => "EscrotWithdrawalsFrontNavItem",
							  "type" => "normal",
							  "href" => $routes['deposit_history'],
							  "icon" => "file-invoice-dollar",
							  "title" => __("Deposit History", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							]
						]	
			],
			
			[
			 "li-classes" => "",  
			 "li-id" => "EscrotWithdrawFrontNavItem",
			 "active_classes" => $active_class['withdraw_history'].$active_class['withdraw_payment_options'].$active_class['bitcoin_withdraw_invoice'],
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
							  "href" => $routes['withdraw_payment_options'],
							  "icon" => "add",
							  "title" => __("Withdraw Money", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							],
							[
							  "li-classes" => "",  
							  "li-id" => "EscrotWithdrawalsFrontNavItem",
							  "type" => "normal",
							  "href" => $routes['deposit_history'],
							  "icon" => "file-invoice-dollar",
							  "title" => __("Withdraw History", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							]
						]	
			],
			
			
			[
			 "li-classes" => "",  
			 "li-id" => "EscrotSupportFrontNavItem",
			 "active_classes" => $active_class['support_tickets'].$active_class['view_ticket'],
			 "type" => "drop-down",
			 "href" => "javascript:;",
			 "icon" => "handshake-angle",
			 "title" => __("Support", "escrowtics"),
			 "collapse-id" => "EscrotSupportCollapse",
			 "submenus" => [
							[
							  "li-classes" => "",  
							  "li-id" => "EscrotAddTicketsFrontNavItem",
							  "type" => "normal",
							  "href" => "#",
							  "icon" => "add",
							  "title" => __("Add Ticket", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							],
							[
							  "li-classes" => "",  
							  "li-id" => "EscrotSupporTicketsFrontNavItem",
							  "type" => "normal",
							  "href" => $routes['support_tickets'],
							  "icon" => "ticket",
							  "title" => __("Support Tickets", "escrowtics"),
							  "collapse-id" => "",
							  "submenus" => []
							]
						]
			]
			
	];
	

    $user_name = strlen($user_data["username"]) > 10? substr($user_data["username"], 0, 10).'..' : $user_data["username"];
	$user_img = escrot_image($user_data["user_image"], 35, "rounded-circle");

	$profile_menu = [
					[
					 "li-classes" => "",  
					 "li-id" => "EscrotUserProfileFrontNavItem",
					 "active_classes" => $active_class['user_profile'],
					 "type" => "drop-down",
					 "href" => "javascript:;",
					 "icon" => "",
					 "title" => $user_img.'<span class="text-capitalize"> '.$user_name.'</span>',
					 "collapse-id" => "EscrotManageEscrowCollapse",
					 "submenus" => [
									[
									  "li-classes" => "",  
									  "li-id" => "EscrotMyProfileFrontNavItem",
									  "type" => "normal",
									  "href" => $routes['user_profile'],
									  "icon" => "user",
									  "title" => __("My Profile", "escrowtics"),
									  "collapse-id" => "",
									  "submenus" => []
									],
									[
									  "li-classes" => "",  
									  "li-id" => "EscrotLogOutFrontNavItem",
									  "type" => "normal",
									  "href" => "#",
									  "icon" => "sign-out",
									  "title" => __("Log out", "escrowtics"),
									  "collapse-id" => "",
									  "submenus" => []
									],
									[
									  "li-classes" => "",  
									  "li-id" => "EscrotBalanceListFrontNavItem",
									  "type" => "normal",
									  "href" => "#",
									  "icon" => "user_group", 
									  "title" => __("Balance: ", "escrowtics").$user_data["balance"].' '.ESCROT_CURRENCY,
									  "collapse-id" => "",
									  "submenus" => []
									]
								]
			        ]
			];