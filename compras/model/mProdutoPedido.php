<?php
    require_once '../Connections/conn_novo.php';
    
    class mProdutoPedido extends Conecction{
        	private $pcId = null;
	private $prodId = null;
	private $qtd = null;
	private $qtdEstoque = null;
	private $status = null;
	private $dataCompra = null;
	private $dataRecebimento = null;
        private $descProduto = null;
        
        public function getPcId(){
		return $this->pcId;
	}
	public function setPcId($pcId){
		$this->pcId = $pcId;
	}
	public function getProdId(){
		return $this->prodId;
	}
	public function setProdId($prodId){
		$this->prodId = $prodId;
	}
	public function getQtd(){
		return $this->qtd;
	}
	public function setQtd($qtd){
		$this->qtd = $qtd;
	}
	public function getQtdEstoque(){
		return $this->qtdEstoque;
	}
	public function setQtdEstoque($qtdEstoque){
		$this->qtdEstoque = $qtdEstoque;
	}
	public function getStatus(){
		return $this->status;
	}
	public function setStatus($status){
		$this->status = $status;
	}
	public function getDataCompra(){
		return $this->dataCompra;
	}
	public function setDataCompra($dataCompra){
		$this->dataCompra = $dataCompra;
	}
	public function getDataRecebimento(){
		return $this->dataRecebimento;
	}
	public function setDataRecebimento($dataRecebimento){
		$this->dataRecebimento = $dataRecebimento;
	}   
        public function setDescProduto($desc){
            $this->descProduto = $desc;
        }
        public function getDescProduto(){
            return $this->descProduto;
        }
    }

?>
