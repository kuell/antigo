<?php

class Email extends PHPMailer {
	public $nomeRemetente;
	public $remetente;
	public $nomeDestinatario;
	public $destinatario;
	public $anexos;
	public $assunto;
	public $descricao;

	public function __construct() {
		$this->isSMTP();// Set mailer to use SMTP
		$this->Host       = 'smtp.frizelo.com.br';// Specify main and backup SMTP servers
		$this->SMTPAuth   = true;// Enable SMTP authentication
		$this->Username   = 'sig@frizelo.com.br';// SMTP username
		$this->Password   = 'frimais12*';// SMTP password
		$this->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted
		$this->Port       = 587;
	}

	public function sendEmail() {
		$this->From     = $this->remetente;
		$this->FromName = $this->nomeRemetente;
		$this->addAddress($this->destinatario, $this->nomeDestinatario);// Add a recipient
		//$this->addAddress('ellen@example.com');// Name is optional

		$this->Subject = $this->assunto;
		$this->Body    = $this->descricao;
		$this->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if (!$this->send()) {
			echo '<h2>A mensagem não pode ser enviada.<br />';
			echo 'Descrição do erro: '.$this->ErrorInfo;
		} else {
			echo 'E-mail enviado com sucesso!</h1>';
		}

	}

}

?>