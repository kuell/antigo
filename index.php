<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8; no-cache" />
<title>SIG - Sistema Interno de Gerenciamento</title>
<link rel="shortcut icon" href="http://10.1.1.3/img/favicon.ico" />
<link rel="icon" href="http://10.1.1.3/img/favicon.ico" />
<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<style type="text/css">
*{
   margin:0;
   padding:0;
}
h1{
	font:italic 3em Georgia, "Times New Roman", Times, serif;
	text-align:center;
	margin:0 0 0 0;
	background:#111;
	color:#fff;
	padding:15px 5px;
	letter-spacing:-0.04em;
	text-shadow:1px 1px 5px #fff;
}
</style>
</head>
<body style="overflow:hidden">
	<div style="float:left;"><img src="logo/Logo.png" width="140" height="84" /></div><div><h1>SIG - Frizelo Frigorificos Ltda.</h1></div>
<div id="conteudo">
	<div>
		<a class="btn" href="#" id="ajuda">
			Precisa de Ajuda?
		</a>
	</div>
  <iframe width="100%" height="100%" name="paginas" src="login.php" frameborder="0" ></iframe>
</div>

<script type="text/javascript">
	$(function(){
		$('#ajuda').bind('click', function(){
			window.open('http://10.1.1.248:81', 'Ajuda', 'width=400px, height=300px')
		})
	})
</script>

</body>
</html>