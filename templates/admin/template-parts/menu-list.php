  <?php
  
  
        $menus = [
                [
                 "li-classes" => "",  "li-id" => "EscrotDashMenuItem",
				 "type" => "normal",
				 "href" => "admin.php?page=escrowtics-dashboard",
				 "icon" => "grip-horizontal",
				 "title" => "Dashboard",
				 "collapse-id" => "",
				 "submenus" => []
                ],
				
				[
                 "li-classes" => "",  "li-id" => "EscrotEscrowMenuItem",
				 "type" => "normal",
				 "href" => "admin.php?page=escrowtics-escrows",
				 "icon" => "circle-dollar-to-slot",
				 "title" => "Escrow Orders",
				 "collapse-id" => "EscrotEscrowSubMenu",
				 "submenus" => []
                ],
				
				[
                 "li-classes" => "",  "li-id" => "EscrotLogMenuItem",
				 "type" => "normal",
				 "href" => "admin.php?page=escrowtics-transaction-log",
				 "icon" => "file-invoice-dollar",
				 "title" => "Transaction Log",
				 "collapse-id" => "EscrotEscrowSubMenu",
				 "submenus" => []
                ],
				
				[
                 "li-classes" => "",  "li-id" => "EscrotInvoiceMenuItem",
				 "type" => "drop-down",
				 "href" => "#EscrotInvoiceSubMenu",
				 "icon" => "user-group",
				 "title" => "Escrow Invoices",
				 "collapse-id" => "EscrotInvoiceSubMenu",
				 "submenus" => [
				                [
                                  "li-classes" => "",  "li-id" => "EscrotDeposits",
				                  "type" => "normal",
				                  "href" => "admin.php?page=escrowtics-deposits",
				                  "icon" => "coins",
				                  "title" => "Deposits",
				                  "collapse-id" => "",
								  "submenus" => []
				                ],
								[
                                  "li-classes" => "",  "li-id" => "EscrotWithdrawals",
				                  "type" => "normal",
				                  "href" => "admin.php?page=escrowtics-withdrawals",
				                  "icon" => "coins",
				                  "title" => "Withdrawals",
				                  "collapse-id" => "",
								  "submenus" => []
				                ]
							]	
                ],
				
				[
                 "li-classes" => "",  "li-id" => "EscrotUserMenuItem",
				 "type" => "drop-down",
				 "href" => "#EscrotUserSubMenu",
				 "icon" => "user-group",
				 "title" => "Escrow Users",
				 "collapse-id" => "EscrotUserSubMenu",
				 "submenus" => [
				                [
                                  "li-classes" => "",  "li-id" => "EscrotMgeUsers",
				                  "type" => "normal",
				                  "href" => "admin.php?page=escrowtics-users",
				                  "icon" => "gears",
				                  "title" => "Manage Users",
				                  "collapse-id" => "",
								  "submenus" => []
				                ]
							]	
                ],
				
				[
                 "li-classes" => "",  "li-id" => "EscrotStatsMenuItem",
				 "type" => "drop-down",
				 "href" => "#EscrotStatSubMenu",
				 "icon" => "chart-pie",
				 "title" => "Statistics",
				 "collapse-id" => "EscrotStatSubMenu",
				 "submenus" => [
				                [
                                  "li-classes" => "",  "li-id" => "EscrotAllStat",
				                  "type" => "normal",
				                  "href" => "admin.php?page=escrowtics-stats",
				                  "icon" => "chart-bar",
				                  "title" => "See All Stats",
				                  "collapse-id" => "",
								  "submenus" => []
				                ]
							]	
                ],
				
				[
                 "li-classes" => "",  "li-id" => "EscrotDBMenuItem",
				 "type" => "drop-down",
				 "href" => "#EscrotDBSubMenu",
				 "icon" => "database",
				 "title" => "DB Backup",
				 "collapse-id" => "EscrotDBSubMenu",
				 "submenus" => [
				                [
                                  "li-classes" => "",  "li-id" => "EscrotMgeDBs",
				                  "type" => "normal",
				                  "href" => "admin.php?page=escrowtics-db-backups",
				                  "icon" => "download",
				                  "title" => "Manage Backups",
				                  "collapse-id" => "",
								  "submenus" => []
				                ],
								
								[
                                  "li-classes" => "",  "li-id" => "EscrotQuikResDB",
				                  "type" => "normal",
				                  "href" => "#",
				                  "icon" => "upload",
				                  "title" => "Quick Restore",
				                  "collapse-id" => "",
								  "submenus" => []
				                ]
							]	
                ],
				
				[
                 "li-classes" => "",  "li-id" => "EscrotSupportMenuItem",
				 "type" => "drop-down",
				 "href" => "#EscrotSupportSubMenu",
				 "icon" => "handshake-angle",
				 "title" => "Support",
				 "collapse-id" => "EscrotSupportSubMenu",
				 "submenus" => [
				                [
                                  "li-classes" => "",  "li-id" => "EscrotSupporTickets",
				                  "type" => "normal",
				                  "href" => "admin.php?page=escrowtics-support-tickets",
				                  "icon" => "ticket",
				                  "title" => "Support Tickets",
				                  "collapse-id" => "",
								  "submenus" => []
				                ]
							]
                ],
				
			/* 	[
                 "li-classes" => "",  "li-id" => "EscrotHelpMenuItem",
				 "type" => "drop-down",
				 "href" => "#EscrotHelpSubMenu",
				 "icon" => "question-circle",
				 "title" => "Plugin Info",
				 "collapse-id" => "EscrotHelpSubMenu",
				 "submenus" => [
								[
                                  "li-classes" => "",  "li-id" => "EscrotAboutUs",
				                  "type" => "normal",
				                  "href" => "#",
				                  "icon" => "circle-info",
				                  "title" => "About Escrowtics",
				                  "collapse-id" => "",
								  "submenus" => []
				                ],
								[
                                  "li-classes" => "",  "li-id" => "EscrotShortCode",
				                  "type" => "normal",
				                  "href" => "#",
				                  "icon" => "expand",
				                  "title" => "Shortcodes",
				                  "collapse-id" => "",
								  "submenus" => []
				                ],
								
								[
                                  "li-classes" => "",  "li-id" => "EscrotDocumentation",
				                  "type" => "normal",
				                  "href" => "#",
				                  "icon" => "list",
				                  "title" => "Documentation",
				                  "collapse-id" => "",
								  "submenus" => []
				                ]
							]
                ],
				 */
				[
                 "li-classes" => "d-none d-md-block",  "li-id" => "EscrotSettMenuItem",
				 "type" => "normal",
				 "href" => "admin.php?page=escrowtics-settings",
				 "icon" => "screwdriver-wrench",
				 "title" => "Settings",
				 "collapse-id" => "",
				 "submenus" => []
                ],
				
				[
                 "li-classes" => "d-block d-md-none",  "li-id" => "EscrotMblSettMenuItem",
				 "type" => "normal",
				 "href" => "admin.php?page=escrowtics-settings",
				 "icon" => "screwdriver-wrench",
				 "title" => "Settings",
				 "collapse-id" => "",
				 "submenus" => []
                ],
				
				
	    ];	