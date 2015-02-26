<?php
    require_once '../Connections/conn_novo.php';
    
    class mSetor extends Conecction{
        private $idSetor = null;
	private $setor = null;
	private $encarregado = null;
	private $rh = null;
	private $ordemRh = null;
	private $tipoCusto = null;

	public function getIdSetor(){
		return $this->idSetor;
	}

	public function setIdSetor($idSetor){
		$this->idSetor = $idSetor;
	}

	public function getSetor(){
		return $this->setor;
	}

	public function setSetor($setor){
		$this->setor = $setor;
	}

	public function getEncarregado(){
		return $this->encarregado;
	}

	public function setEncarregado($encarregado){
		$this->encarregado = $encarregado;
	}

	public function getRh(){
		return $this->rh;
	}

	public function setRh($rh){
		$this->rh = $rh;
	}

	public function getOrdemRh(){
		return $this->ordemRh;
	}

	public function setOrdemRh($ordemRh){
		$this->ordemRh = $ordemRh;
	}

	public function getTipoCusto(){
		return $this->tipoCusto;
	}

	public function setTipoCusto($tipoCusto){
		$this->tipoCusto = $tipoCusto;
	}
    }
?>
