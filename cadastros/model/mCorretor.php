<?php
    require_once '../Connections/conn_novo.php';
    
    class mCorretor extends Conecction{
        private $corId = null;
	private $corCod = null;
	private $corNome = null;
	private $corAtivo = null;

	public function getCorId(){
		return $this->corId;
	}

	public function setCorId($corId){
		$this->corId = $corId;
	}

	public function getCorCod(){
		return $this->corCod;
	}

	public function setCorCod($corCod){
		$this->corCod = $corCod;
	}

	public function getCorNome(){
		return $this->corNome;
	}

	public function setCorNome($corNome){
		$this->corNome = $corNome;
	}

	public function getCorAtivo(){
		return $this->corAtivo;
	}

	public function setCorAtivo($corAtivo){
		$this->corAtivo = $corAtivo;
	}
    }
    
?>
