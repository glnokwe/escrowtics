 <?php
  
/**
 * Admin Menu List for Escrowtics
 * Defines escrowtics menu elements
 * 
 * @Since   1.0.0
 * @package Escrowtics
 */
 
 defined('ABSPATH') || exit;
 
$menus = [
		[
		 "li-classes" => "",  "li-id" => "EscrotDashMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-dashboard",
		 "icon" => "grip-horizontal",
		 "title" => __("Dashboard", "escrowtics"),
		 "collapse-id" => "",
		 "submenus" => []
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotEscrowMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-escrows",
		 "icon" => "filter-circle-dollar",
		 "title" => __("Escrow Orders", "escrowtics"),
		 "collapse-id" => "EscrotEscrowSubMenu",
		 "submenus" => []
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotLogMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-transaction-log",
		 "icon" => "file-invoice-dollar",
		 "title" => __("Transaction Log", "escrowtics"),
		 "collapse-id" => "EscrotEscrowSubMenu",
		 "submenus" => []
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotInvoiceMenuItem",
		 "type" => "drop-down",
		 "href" => "#EscrotInvoiceSubMenu",
		 "icon" => "user-group",
		 "title" => __("Escrow Invoices", "escrowtics"),
		 "collapse-id" => "EscrotInvoiceSubMenu",
		 "submenus" => [
						[
						  "li-classes" => "",  "li-id" => "EscrotDeposits",
						  "type" => "normal",
						  "href" => "admin.php?page=escrowtics-deposits",
						  "icon" => "coins",
						  "title" => __("Deposits", "escrowtics"),
						  "collapse-id" => "",
						  "submenus" => []
						],
						[
						  "li-classes" => "",  "li-id" => "EscrotWithdrawals",
						  "type" => "normal",
						  "href" => "admin.php?page=escrowtics-withdrawals",
						  "icon" => "coins",
						  "title" => __("Withdrawals", "escrowtics"),
						  "collapse-id" => "",
						  "submenus" => []
						]
					]	
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotUserMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-users",
		 "icon" => "user-group",
		 "title" => __("Escrow Users", "escrowtics"),
		 "collapse-id" => "EscrotUserSubMenu",
		 "submenus" => []	
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotStatsMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-stats",
		 "icon" => "chart-pie",
		 "title" => __("Metrics", "escrowtics"),
		 "collapse-id" => "",
		 "submenus" => []	
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotDBMenuItem",
		 "type" => "drop-down",
		 "href" => "#EscrotDBSubMenu",
		 "icon" => "database",
		 "title" => __("DB Backup", "escrowtics"),
		 "collapse-id" => "EscrotDBSubMenu",
		 "submenus" => [
						[
						  "li-classes" => "",  "li-id" => "EscrotMgeDBs",
						  "type" => "normal",
						  "href" => "admin.php?page=escrowtics-db-backups",
						  "icon" => "download",
						  "title" => __("Manage Backups", "escrowtics"),
						  "collapse-id" => "",
						  "submenus" => []
						],
						
						[
						  "li-classes" => "",  "li-id" => "EscrotQuikResDB",
						  "type" => "normal",
						  "href" => "#",
						  "icon" => "upload",
						  "title" => __("Quick Restore", "escrowtics"),
						  "collapse-id" => "",
						  "submenus" => []
						]
					]	
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotSupportMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-disputes",
		 "icon" => "people-arrows",
		 "title" => __("Disputes", "escrowtics"),
		 "collapse-id" => "EscrotSupportSubMenu",
		 "submenus" => []
		],
		 
		[
		 "li-classes" => "d-none d-md-block",  "li-id" => "EscrotSettMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-settings",
		 "icon" => "screwdriver-wrench",
		 "title" => __("Settings", "escrowtics"),
		 "collapse-id" => "",
		 "submenus" => []
		],
		
		[
		 "li-classes" => "d-block d-md-none",  "li-id" => "EscrotMblSettMenuItem",
		 "type" => "normal",
		 "href" => "admin.php?page=escrowtics-settings",
		 "icon" => "screwdriver-wrench",
		 "title" => __("Settings", "escrowtics"),
		 "collapse-id" => "",
		 "submenus" => []
		],
		
		[
		 "li-classes" => "",  "li-id" => "EscrotHelpMenuItem",
		 "type" => "drop-down",
		 "href" => "#EscrotHelpSubMenu",
		 "icon" => "question-circle",
		 "title" => __("Help", "escrowtics"),
		 "collapse-id" => "EscrotHelpSubMenu",
		 "submenus" => [
						[
						  "li-classes" => "",  "li-id" => "EscrotAboutUs",
						  "type" => "normal",
						  "href" => "#",
						  "icon" => "circle-info",
						  "title" => __("About Escrowtics", "escrowtics"),
						  "collapse-id" => "",
						  "submenus" => []
						],
						[
						  "li-classes" => "",  "li-id" => "EscrotShortCode",
						  "type" => "normal",
						  "href" => "#",
						  "icon" => "expand",
						  "title" => __("Shortcodes", "escrowtics"),
						  "collapse-id" => "",
						  "submenus" => []
						],
						
						[
						  "li-classes" => "",  "li-id" => "EscrotDocumentation",
						  "type" => "normal",
						  "href" => "#",
						  "icon" => "list",
						  "title" => __("Documentation", "escrowtics"),
						  "collapse-id" => "",
						  "submenus" => []
						]
					]
		]
		
		
];	