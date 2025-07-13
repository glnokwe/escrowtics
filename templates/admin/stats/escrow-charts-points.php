<?php
/**
 * Defines all Escrow stats chart points.
 *
 * @since      1.0.0
 * @package    Escrowtics
 */

defined('ABSPATH') || exit;

$stats = new StatsDBManager();
$totalEscrowCount = $stats->getTotalEscrowCount(); 

if ($IsStatsPage) {//Make Sure its a Stats Page.


	//Create Top Users Chart points
	$divisor = $totalEscrowCount !== 0? $totalEscrowCount : 1; //Ensure division is non-zero
	
	$top_payers_data_points = [];
	$top_earners_data_points = [];
	
	$top_payers  = $stats->topEscrowPayers(); //Top 10 Escrow Payers (Payer vs freq)
	$top_earners = $stats->topEscrowEarners(); //Top 10 Escrow Earners (Earner vs freq)
	 
	foreach ($top_payers  as $data) {
		if(empty($data['payer'])) continue;
		$payer_quota = round($data['count(*)']/$divisor * 100, 2);
		$top_payers_data_points[] = ["y"=> $payer_quota, "label"=> ucfirst($data['payer'])];//Add points to pie chart
	}
	
	foreach ($top_earners as $data) {
		if(empty($data['earner'])) continue;
		$earner_quota = round($data['count(*)']/$divisor * 100, 2);
		$top_earners_data_points[] = ["y"=> $earner_quota, "label"=> ucfirst($data['earner'])];
	}
	
	

	//Create Monthly Escrows Chart points
	$yr = date('Y');
	$last_yr = date('Y')-1;
	
	$months = [ "Jan"=>1, "Feb"=>2, "Mch"=>3, "Apr"=>4, "May"=>5, "Jun"=>6,"Jul"=>7, "Aug"=>8, "Sep"=>9, "Oct"=>10,   
				"Nov"=>11, "Dec"=>12 ];
	
	$monthly_escrow_data_points_this_yr = [];
	$monthly_escrow_data_points_last_yr = [];
	
	foreach($months as $month => $month_num){
		$monthly_escrow_data_points_this_yr[] = ["y"=> $stats->monthlyEscrowsPerYr($month_num, $yr), "label"=> $month];
		$monthly_escrow_data_points_last_yr[] = ["y"=> $stats->monthlyEscrowsPerYr($month_num, $last_yr), "label"=> $month];
	}
		
}
   


	
	
	
    