<?php
require ('../../../Connections/conect_mysqli.php');
require ('../../../class/Producao.php');

$producao = new Producao();

$dados = $producao->producaoAnualMes(2014);

?>
<!DOCTYPE HTML>
<html>

<head>
<script type="text/javascript" src="../../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../../js/jquery.canvasjs.min.js"></script>


  <script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      theme:"theme2",
      title:{
        text: "Rendimento"
      },
      animationEnabled: true,
      axisY :{
        includeZero: true,
        // suffix: " k",
        valueFormatString: "#,",
        suffix: "%"

      },
      toolTip: {
        shared: "false"
      },
      data: [
<?php echo $dados;?>
],
      legend:{
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
          	e.dataSeries.visible = false;
          }
          else {
            e.dataSeries.visible = true;
          }
          chart.render();
        }

      },
    });

chart.render();
}
</script>
<script type="text/javascript" src="/assets/script/canvasjs.min.js"></script>
</head>
<body>
  <div id="chartContainer" style="height: 300px; width: 100%;">
  </div>
</body>
</html>
