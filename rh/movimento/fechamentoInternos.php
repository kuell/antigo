<?php
require ("../../Connections/conect_mysqli.php");
require ("../../Connections/connect_pgsql.php");
require ("../../class/Interno.class.php");
require ('../../class/Setor.class.php');
require ("../class/Balanco.class.php");

session_start();
$i                = new Interno();
$internos         = $i->fechamentoBalanco($_GET['mes'], $_GET['ano']);
$balanco          = new Balanco(null, null);
$itens            = [1=> 'Horas Trabalhadas', 2=> 'Horas Potenciais', 3=> 'Horas Suplementares'];
$balanco->usuario = $_SESSION['kt_login_user'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8">
	<title>Fechamento Interno</title>
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
</head>
<body>
<h3 class="well">Fechamento Internos</h3>
<div >
<?php
foreach ($internos as $val) {
	$balanco->setor = $val['setor'];
	$balanco->mes   = $val['mes'];
	$balanco->ano   = $val['ano'];
	?>

			<div>Setor : <?php echo $val['setorNome'];?></div>

	<?php
	foreach ($val['item'] as $item => $valor) {
		$balanco->item  = $item;
		$balanco->valor = $valor;
		?>
						<div class="col-md-3">Item : <?php echo $itens[$item];?></div>

		<?php
		if ($balanco->saveBalancoInterno() == 1) {
			?>
			<div class="col-md-3 label-success">Atualizado</div>
			<?php
		} else {
			echo $balanco->saveBalancoInterno();
			?>
			<div>Erro na Atualização!</div>
			<?php
		}
		echo "<br/>";
	}
}
?>
</div>
</body>
</html>