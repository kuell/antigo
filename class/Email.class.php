<?php

class Email extends PHPMailer {
	public $remetente;
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

}

?>