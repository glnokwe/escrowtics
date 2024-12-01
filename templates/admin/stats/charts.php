<script>

window.onload = function () {

<?php 
	
	if ($IsStatsPage && $totalEscrowCount > 0) { 
	
		$pie_charts =[
		   "Top Payers" => [
		        "title" =>  __("Top Escrow Payers", "escrowtics"),
				"id" => "escrot-stat-top-payers-chart",
				"data_points" => $top_payers_data_points
		   
		   ],
		   "Top Earners" => [
		        "title" =>  __("Top Escrow Earners", "escrowtics"),
				"id" => "escrot-stat-top-earners-chart",
				"data_points" => $top_earners_data_points
		   
		   ]
		];
		
		
		foreach ($pie_charts as $chart){
?>
 
			var chart = new CanvasJS.Chart("<?php echo $chart['id']; ?>", {
				animationEnabled: true,
				exportEnabled: false,
				backgroundColor: "transparent",
				
				axisX:{
			   labelFontColor: "#029b61"
				  },
				 
				title:{
				text: "<?php echo $chart['title']; ?>",
					fontColor: "#06accd",
					fontFamily: "jost",
					fontSize: "18",
				},
				axisY:{
					includeZero: true,
					labelFontColor: "red"
				},
				data: [{
					type: "doughnut", //change type to bar, line, area, pie, etc
					innerRadius: 45,
					radius: "75%",
					indexLabel: "{label} ({y}%)",
					indexLabelFontColor: "#06accd",
					indexLabelFontSize: "12.2",
					indexLabelPlacement: "outside",   
					dataPoints: <?php echo json_encode($chart['data_points'], JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

        <?php } ?>
	

		    //Escrow Stats spline graph 
		    var chart = new CanvasJS.Chart("escrot-stat-monthly-escrow-chart", {
				animationEnabled: true,
				exportEnabled: false,
				backgroundColor: "transparent",
				
				axisX:{
			   labelFontColor: "#029b61"
				  },
				 
				title:{
				text: "Escrows: <?php echo date('Y'); ?> vs <?php echo date('Y')-1; ?>",
					fontColor: "#06accd",
					fontFamily: "jost",
				},
				axisY:{
					includeZero: true,
					labelFontColor: "#029b61"
				},
				legend:{
					fontColor: "#05ccce",
				},
				data: [{
					type: "spline", //change type to bar, line, area, pie, etc
					 name: "<?php echo date('Y')-1; ?>",        
					showInLegend: true,  
					dataPoints: <?php echo json_encode($monthly_escrow_data_points_last_yr, JSON_NUMERIC_CHECK); ?>
				},
				
				{
					type: "spline", //change type to bar, line, area, pie, etc
					 name: "<?php echo date('Y'); ?>",        
					showInLegend: true,  
					dataPoints: <?php echo json_encode($monthly_escrow_data_points_this_yr, JSON_NUMERIC_CHECK); ?>
				},
				]
			});
		    chart.render();

   <?php } ?>


	function toggleDataSeries(e) {
		if(typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else {
			e.dataSeries.visible = true;            
		}
		chart.render();
	}

}

</script> 