<?php
    require_once '../../Connections/conn_novo.php';
    
    class PedidoCompra extends Conecction{
       private $id = null;
	private $setor = null;
	private $solicitante = null;
	private $data = null;
	private $obs = null;
	private $osi = null;
	private $status = null;
	private $prioridade = "baixa";

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getSetor(){
		return $this->setor;
	}

	public function setSetor($setor){
		$this->setor = $setor;
	}

	public function getSolicitante(){
		return $this->solicitante;
	}

	public function setSolicitante($solicitante){
		$this->solicitante = $solicitante;
	}

	public function getData(){
		return $this->data;
	}

	public function setData($data){
		$this->data = $data;
	}

	public function getObs(){
		return $this->obs;
	}

	public function setObs($obs){
		$this->obs = $obs;
	}

	public function getOsi(){
		return $this->osi;
	}

	public function setOsi($osi){
		$this->osi = $osi;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getPrioridade(){
		return $this->prioridade;
	}

	public function setPrioridade($prioridade){
		$this->prioridade = $prioridade;
	}
 
    }
    
?>
