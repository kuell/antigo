<?php
require ('Connections/conect_mysqli.php');
require ('class/Usuario.class.php');

if (!empty($_REQUEST['funcao']) && $_REQUEST['funcao'] == 'logout') {
	mysql_close();
	session_destroy();
	header("Location: login.php");

} else if ($_SESSION['kt_login_id']) {
	session_destroy();
	header("Location: login.php");
} else {
	session_start();
}

$usuario = new Usuario($_SESSION['kt_login_id']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Untitled Document</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="bibliotecas/ionicons/css/ionicons.min.css">
<script src="https://code.jquery.com/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<style type="text/css">
	body {
	  padding-top: 70px;
	}
	img{
		width: 90px;
		height: 90px;
	}
	.col-md-2{
		border: solid 1px #888;
		text-align: center;
	}
	.col-md-2:hover{
		background: #66CCFF;
		border: solid 1px #FFF;
		text-align: center;
	}
</style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top success">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index2.php">Painel Administrativo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
	        <ul class="nav navbar-nav navbar-right">
	            <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				    <i class= "glyphicon glyphicon-user">
					</i>
<?php echo $usuario->usuario->nome;?>
</button>
			    <ul class="dropdown-menu" role="menu">
			      <li><a href="?funcao=logout">
			      <i class= "glyphicon glyphicon-log-out"></i>
			      Sair</a></li>
			    </ul>
			  </div>
	        </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<div class="content">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Sistemas</h3>
	</div>
<div class="panel-body">

<?php foreach ($usuario->getSistemas() as $sistema) {
	?>

						<div class="col-sm-4 col-md-2 thumbnail">
						  <img src="img/<?php echo $sistema->icone?>">
						  <div class="caption">
						    <h4></h4>
						    <p><?php echo strtolower(lcfirst(utf8_decode($sistema->nome)))?></p>
						    <p>
						    	<a href="<?php echo $sistema->url?>" class="btn btn-info col-md-12" role="button">
						    		Acessar
						    		<i class="glyphicon glyphicon-share-alt" ></i>
						    	</a>
						    </p>
						  </div>

						</div>

	<?php }?>

</div>
<div class="panel-footer">

</div>
</div>
</div>
</body>

</html>