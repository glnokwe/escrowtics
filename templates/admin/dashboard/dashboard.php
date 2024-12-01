<?php             

	defined('ABSPATH') or die();
	
	$IsStatsPage = True;
	  
	require_once(ESCROT_PLUGIN_PATH."includes/database/StatsConfig.php"); 

	require_once (ESCROT_PLUGIN_PATH."templates/admin/stats/escrow-charts-points.php"); 
	  
	$dialogs = [
	
				['id' => 'escrot-add-escrow-form-dialog',
				'data_id' => '',
				'header' => '',
				'title' => __("Add Escrow", "escrowtics"),
				'callback' => 'add-escrow-form.php',
				'type' => 'add-form'
			   ],
			   ['id' => 'escrot-db-restore-form-dialog',
				'data_id' => '',
				'header' => '',
				'title' => __("Restore Database Backup", "escrowtics"),
				'callback' => 'db-restore-form.php',
				'type' => 'restore-form'
			   ],
			   
			   ['id' => 'escrot-search-results-dialog',
				'data_id' => 'escrot-escrow-search-results-dialog-wrap',
				'header' => '',
				'title' => __("Escrow Search Results", "escrowtics"), 
				'callback' => '',
				'type' => 'data'
			   ]
		];

		escrot_callapsable_dialogs($dialogs);
		
	?>
	
		
	<div class="row">
		<?php 
		   
			$col_class= "col-md-6 d-flex align-items-stretch";
			$color    = "success"; 
			$icon     = "circle-dollar-to-slot"; 
			$title    = __("Recent Escrows", "escrowtics");
			if(ESCROT_PLUGIN_INTERACTION_MODE == "modal"){ 
				$subtitle = '<a href="admin.php?page=escrowtics-escrows" class="text-success" title="'.__("See All Escrows", "escrowtics").'"> 
								<i class="fas text-success fa-circle-dollar-to-slot"></i><span class="d-none d-md-inline">'.__("All Escrows", "escrowtics").'&nbsp;&nbsp;</span> 
							</a>
							<a href="#" class="text-success" data-toggle="modal" data-target="#escrot-add-escrow-modal" title="'.__("Add Escrow", "escrowtics").'"> 
								<i class="fas text-success fa-plus"></i> <span class="d-none d-md-inline">'.__("Add Escrow", "escrowtics").'</span> 
							</a>';	
			} else {
				 $subtitle = '<a href="admin.php?page=escrowtics-escrows" class="text-success" title="'.__("See All Escrows", "escrowtics").'"> 
								<i class="fas text-success fa-circle-dollar-to-slot"></i><span class="d-none d-md-inline">
								'.__(" All Escrows", "escrowtics").'</span> 
							</a>&nbsp;
							<a href="#" id="addEscrowDash" class="addEscrow text-success" data-toggle="collapse" data-target="#escrot-add-escrow-form-dialog" title="'.__("Add Escrow", "escrowtics").'"> 
								<i class="fas text-success fa-plus"></i> <span class="d-none d-md-inline">'.__("Add Escrow", "escrowtics").'</span> 
							</a>';
			}								 
			$type     = "table"; 
			$count    = 0;
			$id       = "tableDataDB";
			$box_ht   = "";
			echo escrot_stat_chart_tbl($col_class, $color, $icon, $title, $subtitle, $type, $count, $id, $box_ht); 
			
			$top_users_data = [
				"id"       => "escrot-stat-top-users-chart",
				"col_class"=> "col-md-6 d-flex align-items-stretch",
				"color"    => "success", 
				"icon"     => "globe", 
				"title"    => __("Top Escrow Useers", "escrowtics"),
				"subtitle" => "", 
				"box_ht"   => "",
				"tabs" => [
					"tab1" =>[
						"id"       => "escrot-stat-top-payers-chart",
						"title"	   => __("Top Escrow Payers", "escrowtics"),
						"type"     => "chart", 
						"count"    => $totalEscrowCount,
						"active"   => true,
						"selected" => "true"
					],
					"tab2" =>[
						"id"       => "escrot-stat-top-earners-chart",
						"title"	   => __("Top Escrow Earners", "escrowtics"),
						"type"     => "chart", 
						"count"    => $totalEscrowCount,
						"active"   => false,
						"selected" => "false"
					]
					
				]
			];
			echo escrot_tab_stat_chart_tbl($top_users_data);	
			
		?>
	</div>
		
		
	<div class="row">
		<?php 
			$col_class= "col-md-6 d-flex align-items-stretch";
			$color    = "info"; 
			$icon     = "chart-bar"; 
			$title    = __("Monthly Escrow Transactions", "escrowtics"); 
			$subtitle = ''; 
			$type     = "chart"; 
			$count    = $totalEscrowCount;
			$id       = "escrot-stat-monthly-escrow-chart"; 
			$box_ht   = "230px";
			echo escrot_stat_chart_tbl($col_class, $color, $icon, $title, $subtitle, $type, $count, $id, $box_ht);
		?>
		<div class='col-md-6'>
			<div class="row">
				<?php 
					
					$id       = 'escrot-stat-total-escrow-count';
					$count    = $stats->totalEscrowCount();
					$sub      = __("Escrow", "escrowtics");
					$sub_s    = __("Escrows", "escrowtics");
					$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
					$color    = "primary"; 
					$icon     = "circle-dollar-to-slot"; 
					$title    = "Total Escrows";
					echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title); 
						
					
					$id       = 'escrot-stat-recent-escrow-count';
					$count    = $stats->recentEscrowCount();
					$sub      = __("Escrow in last 24 hours", "escrowtics");
					$sub_s    = __("Escrows in last 24 hours", "escrowtics");
					$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
					$color    = "primary"; 
					$icon     = "clock"; 
					$title    = __("Recent Escrows", "escrowtics"); 
					echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title);
				?>
			</div>
			<div class="row">
				<?php 
					$id       = 'escrot-stat-total-user-count';
					$count    = $stats->totalUserCount();
					$sub      = "User";
					$sub_s    = "Users";
					$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
					$color    = "info"; 
					$icon     = "user-group"; 
					$title    = __("Total Users", "escrowtics");
					echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title);		
					
					
					$id       = 'escrot-stat-total-balance';
					$count    = $stats->totalBalance();
					$sub      = __("Combined Balance", "escrowtics");
					$sub_s    = __("Combined Balance", "escrowtics");
					$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
					$color    = "info"; 
					$icon     = "dollar-sign"; 
					$title    = __("Total Balance", "escrowtics");
					echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title);
				?>
			</div>
		</div>		
	</div>
