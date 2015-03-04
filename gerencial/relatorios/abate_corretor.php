<?php
require ('../../Connections/conect_mysqli.php');
require ('../../class/AbateCorretor.class.php');

$dados = new AbateCorretor(2014);

foreach ($dados as $key  => $value) {
	foreach ($value as $key => $value) {
		$corretor .= '"'.$value->cor_nome.'",';
		$qtd .= $value->qtd.',';
		$peso .= $value->peso.',';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>teste</title>
	<script type="text/javascript" src="../../js/Chart.js"></script>
	<script type="text/javascript">
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

		var barChartData = {
			labels : [<?php echo $corretor;?>],
			datasets : [
				{
					fillColor : "rgba(110,220,220,0.5)",
					strokeColor : "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
					data : [<?php echo $qtd?>]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,0.8)",
					highlightFill : "rgba(151,187,205,0.75)",
					highlightStroke : "rgba(151,187,205,1)",
					data : [<?php echo $peso?>]
				}
			]

		}
		window.onload = function(){
			var ctx = document.getElementById("canvas").getContext("2d");
			window.myBar = new Chart(ctx).Bar(barChartData, {
				responsive : true
			});
		}

	</script>
</head>
<body>

<div style="width: 90%">
	<canvas id="canvas" height="450" width="600"></canvas>
</div>


</body>
</html>