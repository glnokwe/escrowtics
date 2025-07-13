<?php    

/**
 * Admin Dashboard.
 *
 * @package Escrowtics
 * @since   1.0.0
 */         

defined('ABSPATH') || exit;

$IsStatsPage = True;
  
require_once(ESCROT_PLUGIN_PATH."includes/Database/StatsDBManager.php"); 

require_once (ESCROT_PLUGIN_PATH."templates/admin/stats/escrow-charts-points.php"); 
  
$dialogs = [

			['id' => 'escrot-add-escrow-form-dialog',
			'data_id' => '',
			'header' => '',
			'title' => __("Add Escrow", "escrowtics"),
			'callback' => 'add-escrow-form.php',
			'type' => 'add-form'
		   ]
	];
	escrot_callapsable_dialogs($dialogs);
	
?>

	
<div class="row">
	<?php 
	   
		$col_class= "col-md-6 d-flex align-items-stretch";
		$color    = "info"; 
		$icon     = "filter-circle-dollar"; 
		$title    = __("Recent Escrows", "escrowtics");
		if(ESCROT_INTERACTION_MODE == "modal"){ 
			$subtitle = '<a href="admin.php?page=escrowtics-escrows" class="escrot-text-info" title="'.__("See All Escrows", "escrowtics").'"> 
							<i class="fas escrot-text-info fa-filter-circle-dollar"></i><span class="d-none d-md-inline">'.__("All Escrows", "escrowtics").'&nbsp;&nbsp;</span> 
						</a>
						<a href="#" class="escrot-text-info" data-toggle="modal" data-target="#escrot-add-escrow-modal" title="'.__("Add Escrow", "escrowtics").'"> 
							<i class="fas escrot-text-info fa-plus"></i> <span class="d-none d-md-inline">'.__("Add Escrow", "escrowtics").'</span> 
						</a>';	
		} else {
			 $subtitle = '<a href="admin.php?page=escrowtics-escrows" class="escrot-text-info" title="'.__("See All Escrows", "escrowtics").'"> 
							<i class="fas escrot-text-info fa-filter-circle-dollar"></i><span class="d-none d-md-inline">
							'.__(" All Escrows", "escrowtics").'</span> 
						</a>&nbsp;
						<a href="#" id="addEscrowDash" class="addEscrow escrot-text-info" data-toggle="collapse" data-target="#escrot-add-escrow-form-dialog" title="'.__("Add Escrow", "escrowtics").'"> 
							<i class="fas escrot-text-info fa-plus"></i> <span class="d-none d-md-inline">'.__("Add Escrow", "escrowtics").'</span> 
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
			"color"    => "info", 
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
				$count    = $stats->getTotalEscrowCount();
				$sub      = __("Escrow", "escrowtics");
				$sub_s    = __("Escrows", "escrowtics");
				$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
				$color    = "info"; 
				$icon     = "filter-circle-dollar"; 
				$title    = "Total Escrows";
				echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title); 
					
				
				$id       = 'escrot-stat-recent-escrow-count';
				$count    = $stats->recentEscrowCount();
				$sub      = __("Escrow in last 24 hours", "escrowtics");
				$sub_s    = __("Escrows in last 24 hours", "escrowtics");
				$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
				$color    = "info"; 
				$icon     = "clock"; 
				$title    = __("Recent Escrows", "escrowtics"); 
				echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title);
			?>
		</div>
		<div class="row">
			<?php 
				$id       = 'escrot-stat-total-user-count';
				$count    = $stats->getTotalUserCount();
				$sub      = "User";
				$sub_s    = "Users";
				$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
				$color    = "info"; 
				$icon     = "user-group"; 
				$title    = __("Total Users", "escrowtics");
				echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title);		
				
				
				$id       = 'escrot-stat-total-balance';
				$count    = $stats->totalAmtInEscrowsTransactions();
				$sub      = __("Total Sum in all escrows", "escrowtics");
				$sub_s    = __("Total Sum in all escrows", "escrowtics");
				$col_class= "col-lg-6 col-md-6 col-sm-6 d-flex align-items-stretch";
				$color    = "info"; 
				$icon     = "dollar-sign"; 
				$title    = __("Escrows Sum", "escrowtics");
				echo escrot_stat_box($id, $count, $sub, $sub_s, $col_class, $color, $icon, $title);
			?>
		</div>
	</div>		
</div>
