<?php
require ('../bibliotecas/email/class.phpmailer.php');
require ('../Connections/conect_mysqli.php');
require ('../bibliotecas/email/class.smtp.php');
require ('../class/Email.class.php');
require ('../class/Usuario.class.php');
require ('../class/Corretor.class.php');

session_start();
if (!empty($_GET['voltar'])) {
	var_dump(unlink('uploads/'.$_GET['arquivo']));
}

$usuario = new Usuario();
$user    = $usuario->getUsuario($_SESSION['kt_login_id']);

$corretor = new Corretor($_GET['cor']);

$cor         = $_GET['cor'];
$datai       = implode('_', explode('/', $_GET['datai']));
$dataf       = implode('_', explode('/', $_GET['dataf']));
$nomeArquivo = $cor.'_'.$datai.'_'.$dataf.'.pdf';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$email                   = new Email();
	$email->remetente        = $_POST['remetente'];
	$email->nomeRemetente    = $_POST['nomeRemetente'];
	$email->nomeDestinatario = $_POST['nomeDestinatario'];
	$email->destinatario     = $_POST['destinatario'];
	$email->assunto          = $_POST['assunto'];
	$email->descricao        = $_POST['message'];
	$email->addAttachment('uploads/'.$_POST['arquivo']);

	echo ($email->sendEmail());
	echo "<br /><a href='Taxa.php?rel'>Voltar</a><br />";

	unlink('uploads/'.$_POST['arquivo']);

	if ($_POST['remetente'] != $user->email) {
		$usuario->atualizaEmail($user->id_funcionario, $_POST['remetente']);

		echo "-> E-mail do remetente atualizado!<br />";
	}
	die;

}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$.get('rel_taxa.php?salvar=1', {cor: '<?php echo $cor;?>', datai: '<?php echo $_GET["datai"];?>', dataf: '<?php echo $_GET["dataf"];?>'}, function(data){
				window.console.log(data)
			});
            $('#voltar').click(function() {
                var arq = $('input[name=arquivo]').val()

                $.get('?', {voltar: 1, arquivo: arq}, function(data){
                            window.console.log(data)
                        });
                location = 'Taxa.php?rel'

            });
            $('#submit').click(function(){
                alert('Ola')
                $('#myModal').modal('show')
            })
		})

        function abre(url){
            window.open(url, 'Print', 'channelmode=true');
        }

	</script>
</head>
<body>
<h3>Enviar e-mail</h3>
<div class="col-md-10 well">
	<form class="form-horizontal" role="form" method="post" action="">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nome do Remetente</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="nomeRemetente" placeholder="Nome do Remetente" value="<?php echo $user->nome;?>">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email do Remetente</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" name="remetente" placeholder="Email do Remetente" value="<?php echo $user->email;?>">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nome destinatario</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="nomeDestinatario" placeholder="Nome do destinatario" value="<?php echo $corretor->codigo_interno.': '.$corretor->nome;?>">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Email destinatario</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="destinatario" placeholder="Email do destinatario" value="">
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Assunto</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="assunto" placeholder="Assunto" value="Taxa ref: <?php echo $_GET['datai'].' a '.$_GET['dataf'];?>">
        </div>
    </div>

    <div class="form-group">
        <label for="message" class="col-sm-2 control-label">Mensagem</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="message">Olá <?php echo $corretor->nome;?>,
Segue Anexo. </textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Arquivo:</label>
        <div class="col-sm-10">
        <a href="#" onclick="abre('uploads/<?php echo $nomeArquivo;?>')"><?php echo $nomeArquivo;
?></a>
        <input type="hidden" name="arquivo" value="<?php echo $nomeArquivo;?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <input id="submit" name="submit" type="submit" value="Enviar" class="btn btn-primary">
            <button class="btn btn-danger" id="voltar" type="button">Voltar</button>
        </div>
    </div>
</form>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Enviando e-mail</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
</body>
</html>