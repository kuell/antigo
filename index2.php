<?php

if (isset($_REQUEST['funcao'])) {
	mysql_close();
	session_destroy();
	header("Location: login.php");
}

session_start();
require ("Connections/conn.php");
mysql_select_db($database_conn, $conn);
$sql = "Select * from acess_sistem where funcionario = '".$resultado = $_SESSION['kt_login_id']."'";
$qr  = mysql_query($sql) or die(mysql_error());

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="css/doc.css" rel="stylesheet" type="text/css" />

<script src="js/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<div align="center" class="dock">Ola <?php echo $_SESSION['kt_login_user'];?>, seja bem vindo!</div>
<div>Escolha o Sistema</div>

</div>
<div id="painel" class="dock">
	<div class="Sistemas" align="center">
	  <table border="0">
	    <tr>
	      <th scope="col">  <?php while ($resultado = mysql_fetch_assoc($qr)) {?>
									    <div id="itens">
									       	<a href="<?php echo $resultado['url']?>">
									       		<img width="40px" height="50px" src="img/<?php echo $resultado['icone']?>" align="absbottom" />
									       	</a>
										    <br />
										    <span>
	<?php echo $resultado['Sistema'];?>
	</span>
									    </div>
	<?php }?>
         <a href="?funcao=1">
         	<div id="itens"><img width="50px" height="50px" src="img/sair.png" align="absbottom" /><span>Sair</span></div></a>
          </th>
        </tr>
      </table>
  </div>
</div>

</body>

</html>