<?php
    require_once 'model/mProdutoPedido.php';
    require_once 'aPedidoCompra.php';
    
    class aProdutoPedido extends mProdutoPedido{
        protected $sqlInsert = "INSERT INTO `pedido_produto`(`pcId`,`prodId`,`qtdEstoque`,`qtd`,`status`)
                                        VALUE('%s','%s','%s','%s','%s')";
        protected $sqlDelete = "DELETE FROM pedido_produto WHERE pcId='%s' and prodId='%s'";
        protected $sqlDeletePedido = "DELETE FROM pedido_produto WHERE pcId = %s";
        protected $sqlSelect = "Select 
                                    a.*,
                                    b.`PRO_DESCRICAO` as produto,
                                    c.`UM_DESCRICAO` as unidade ,
                                    d.osi,
                                    d.`prioridade`,
                                    d.data,
                                    d.solicitante,
                                    e.setor
                                from 
                                    pedido_produto a
                                    inner join `produto` b on(a.`prodId` = b.`PRO_ID`)
                                    inner join `unidade_medida` c on(b.`PRO_UNIDADE` = c.`UM_ID`)
                                    inner join pedido_compra d on(a.pcId = d.id)
                                    inner join setor e on(d.setor = e.id_setor)
                                where 
                                    1=1 %s %s";
        
        public function insert(){
            $sql = sprintf($this->sqlInsert, $this->getPcId(), 
                                             $this->getProdId(), 
                                             $this->getQtdEstoque(), 
                                             $this->getQtd(), 
                                             $this->getStatus());
            return $this->RunQuery($sql);
        }
        public function delete(){
            $sql = sprintf($this->sqlDelete, $this->getPcId(), $this->getProdId());
            return $this->RunQuery($sql);
        }
        public function deletePedido($idPedido=null){
            if($idPedido == NULL){
                return false;
            }
            else{
                $sql = sprintf($this->sqlDeletePedido, $idPedido);
                return $this->RunQuery($sql);
            }
        }
        public function select($where="", $order=""){
            $sql = sprintf($this->sqlSelect, $where, $order);
            
            return $this->RunSelect($sql);
        }
        public function loadProduto(){
            $rs = $this->select(sprintf(" and pcId = '%s' and prodId='%s'", $this->getPcId(), $this->getProdId()));
            
            $this->setPcId($rs[0]['pcId']);
            $this->setProdId($rs[0]['prodId']);
            $this->setQtdEstoque($rs[0]['qtdEstoque']);
            $this->setQtd($rs[0]['qtd']);
            $this->setDescProduto($rs[0]['produto']);
            
            return $this;
            
        }
        public function editaProduto(){
            $sql = "UPDATE `pedido_produto` SET  `qtd` = '%s' WHERE pcId = '%s' and prodId = '%s'";
            $res = sprintf($sql, $this->dbNum($this->getQtd()), $this->getPcId(), $this->getProdId());
            
            return $this->RunQuery($res);
        }
        public function comprarProduto(){
            $sql = "UPDATE `pedido_produto` SET status = 'COMPRADO', dataCompra = '%s' WHERE pcId = '%s' and prodId = '%s'";
            $res = sprintf($sql, $this->getDataCompra(), $this->getPcId(), $this->getProdId());
            
            $this->RunQuery($res);
            return $this->verifica();
        }
        public function receberProduto(){
            $sql = "UPDATE `pedido_produto` SET status = 'RECEBIDO', dataRecebimento = '%s' WHERE pcId = '%s' and prodId = '%s'";
            $res = sprintf($sql, $this->getDataRecebimento(), $this->getPcId(), $this->getProdId());
            
            $this->RunQuery($res);
            return $this->verifica();
        }
        public function verifica(){
            
            $recebidos = $this->RunSelect("Select count(*) as rec from pedido_produto where status = 'RECEBIDO' and status <> 'REPROVADO' and pcId = '".$this->getPcId()."'");
            $comprados = $this->RunSelect("Select count(*) as comp from pedido_produto where status = 'COMPRADO' and status <> 'REPROVADO' and pcId = '".$this->getPcId()."'");
            $requisit = $this->RunSelect("Select count(*) as req from pedido_produto where status = 'REQUISITADO' and status <> 'REPROVADO' and pcId = '".$this->getPcId()."'");
            
            $rec = $recebidos[0]['rec'];
            $comp = $comprados[0]['comp'];
            $req = $requisit[0]['req'];
            
            $pedido = new PedidoCompra();
            
            
            if($rec == 0 && $comp == 0){
                return true;               
            }
            elseif($rec != 0 && $comp == 0 && $req ==0){
                $sql = "UPDATE 
                                        pedido_compra 
                                    SET 
                                        status = 'RECEBIDO'
                                    WHERE
                                        id = '%s'";
                            $rs = sprintf($sql, $this->getPcId());
                           return $this->RunQuery($rs);
            }
            elseif($rec != 0 && $comp != 0 && $req == 0){
                            $sql = "UPDATE 
                                        pedido_compra 
                                    SET 
                                        status = 'COMPRADO'
                                    WHERE
                                        id = '%s'";
                            $rs = sprintf($sql, $this->getPcId());
                           return $this->RunQuery($rs);
            }
            elseif($rec == 0 && $comp != 0 && $req == 0){
                $pedido->setId($this->getPcId());
                return $pedido->compraPedido();
            }
            elseif($rec == 0 && $comp != 0 && $req != 0){
               $pedido->setId($this->getPcId());
               return $pedido->comprandoPedido();
            }
            else{
                echo "Erro !!!";
                           
            }
 
        }
        public function verificaProduto(){
            $sql = "Select 
                            count(*) as resultado
                    from
                            `pedido_produto` a
                    where
                        a.`status` <> 'RECEBIDO' and
                        a.`status` <> 'REPROVADO' and
                        a.`prodId` = '%s'";
            $rs = sprintf($sql, $this->getProdId());
            return $this->RunSelect($rs);
        }
    }

?>
