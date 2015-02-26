<?php
    require_once 'model/mPedidoCompra.php';
    require_once 'aProdutoPedido.php';
    
    class aPedidoCompra extends mPedidoCompra{
        protected $sqlInsert = "INSERT INTO  `pedido_compra` (`setor`,`solicitante`,`osi`,`prioridade`,`status`,`obs`)
                                   VALUE('%s','%s','%s','%s','%s','%s')";
        protected $sqlUpdate = "UPDATE 
                                    `pedido_compra`  
                                  SET 
                                    `setor` = '%s',
                                    `solicitante` = '%s',
                                    `osi` = '%s',
                                    `prioridade` = '%s',
                                    `obs` = '%s' 
                                  WHERE 
                                    `id` = '%s'";
        protected $sqlDelete = "DELETE FROM pedido_compra WHERE id=%s";
        protected $sqlSelect = "Select 
                                    a.*,
                                    b.`setor`
                                from 
                                    pedido_compra a
                                    inner join `setor` b ON (a.`setor` = b.`id_setor`)
                                where 
                                    1 = 1 %s %s";

        public function insert(){
            $sql = sprintf($this->sqlInsert, $this->getSetor(),
                                             $this->getSolicitante(),
                                             $this->getOsi(),
                                             $this->getPrioridade(), 
                                             $this->getStatus(),
                                             $this->getObs());
            return $this->RunQuery($sql);
        }
        public function delete(){
            $produtos = new ProdutoPedido();
            
            $sql = sprintf($this->sqlDelete, $this->getId());
            $this->RunQuery($sql);
            
            return $produtos->deletePedido($this->getId());
            
        }

        public function update(){
            $sql = sprintf($this->sqlUpdate, $this->getSetor(),
                                             $this->getSolicitante(),
                                             $this->getOsi(),
                                             $this->getPrioridade(),
                                             $this->getObs(),
                                             $this->getId());

            return $this->RunQuery($sql);
            
        }
        public function select($where="", $order=""){
            $sql = sprintf($this->sqlSelect, $where, $order);
            return $this->RunSelect($sql);
        }
        public function load(){
            $rs = $this->select(sprintf(" and id = '%s'",  $this->getId()));
            
            $this->setId($rs[0]['id']);
            $this->setData($rs[0]['data']);
            $this->setSetor($rs[0]['setor']);
            $this->setSolicitante($rs[0]['solicitante']);
            $this->setPrioridade($rs[0]['prioridade']);
            $this->setObs($rs[0]['obs']);
            $this->setOsi($rs[0]['osi']);
            $this->setStatus($rs[0]['status']);
            
            return $this;
        }
        public function compraPedido(){
            $sql = "UPDATE 
                        pedido_compra 
                    SET 
                        status = 'COMPRADO'
                    WHERE
                        id = '%s'";
            $rs = sprintf($sql, $this->getId());
           $res1 = $this->RunQuery($rs);
           
           $sql2 = "UPDATE 
                        pedido_produto 
                          set 
                            status = 'COMPRADO', 
                            dataCompra = '".date('Y-m-d')."'
                         where 
                            pcId = ".$this->getId();
            
           $res2 =  $this->RunQuery($sql2);
            
            if($res1 && $res2){
                return true;
            }
            else{
                echo "Erro res1: ".$sql."<br />";
                echo "Erro res2: ".$sql2;
                die;
            }
            
        }
        public function reprovaPedido(){
            $sql = "UPDATE 
                        pedido_compra 
                    SET 
                        status = 'REPROVADO'
                    WHERE
                        id = '%s'";
            $rs = sprintf($sql, $this->getId());
            $this->RunQuery($rs);
            
            $sql2 = "UPDATE 
                        pedido_produto 
                          set 
                            status = 'COMPRADO', 
                            dataCompra = '".date('Y-m-d')."'
                         where 
                            pcId = ".$this->getId()." and status = 'REQUISITADO'";
           $this->RunQuery($sql2);
            return true;
            
        }
        public function recebePedido(){
            $sql = "UPDATE 
                        pedido_compra 
                    SET 
                        status = 'COMPRADO'
                    WHERE
                        id = '%s'";
            $rs = sprintf($sql, $this->getId());
            return $this->RunQuery($rs);
        }
        public function comprandoPedido(){
            $sql = "UPDATE 
                        pedido_compra 
                    SET 
                        status = 'COMPRANDO'
                    WHERE
                        id = '%s'";
            $rs = sprintf($sql, $this->getId());
            return $this->RunQuery($rs);
        }
        
    }
    
    

?>
