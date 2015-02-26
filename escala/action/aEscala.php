<?php
    require_once 'model/mEscala.php';
    require_once 'core/PreEscala.php';
    
    class aEscala extends mEscala{
        
        protected $sqlInsert = "INSERT INTO `escala` (`data`, `corretor`, `pecuarista`, `lote`, pre_escala,`qtdBoi`, `qtdVaca`, `qtdNov`, `qtdTouro`,`duracao`, `usuario_inclusao`, `data_inclusao`) 
                                            value('%s', %s, '%s', %s, %s , %s,%s,%s,%s,%s,'%s',current_timestamp)";
        protected $sqlUpdate = "UPDATE `escala`  
                                  SET `corretor` = %s, `pecuarista` = '%s', `qtdBoi` = %s, 
                                      `qtdVaca` = %s, `qtdNov` = %s, `qtdTouro` = %s, 
                                      `duracao` = %s, `usuario_alteracao` = '%s', 
                                      `data_alteracao` = current_timestamp 
                                  WHERE `id` = %s";
        protected $sqlDelete = "DELETE FROM `escala` WHERE `id` = %s";
        protected $sqlSelect = "Select
                                    a.*,
                                    b.*
                                FROM
                                    `escala` a
                                    inner join corretor b on(a.`corretor` = b.`cor_id`)
                                where 
                                    1=1 %s %s";
        
        public function insert()
        {           
            $sql = sprintf($this->sqlInsert, $this->getData(),
                                             $this->getCorretor(),
                                             $this->getPecuarista(),
                                             $this->getLote(),
                                             $this->getPreEscala(),
                                             $this->getQtdBoi(),
                                             $this->getQtdVaca(),
                                             $this->getQtdNov(),
                                             $this->getQtdTouro(),
                                             $this->getDuracao(),
                                             $this->getUsuario());   
                                    
            return $this->RunQuery($sql);
        }
        
        public function update()
        {
           $sql = sprintf($this->sqlUpdate,    $this->getCorretor(),
                                               $this->getPecuarista(),
                                               $this->getQtdBoi(),
                                               $this->getQtdVaca(),
                                               $this->getQtdNov(),
                                               $this->getQtdTouro(),
                                               $this->getDuracao(),
                                               $this->getUsuario(),
                                               $this->getId());

           return $this->RunQuery($sql);
                   
        }
        
        public function delete()
        {
          // Gera Sql de remoção da escala de abate
          $sql = sprintf($this->sqlDelete, $this->getId());
          // Carrega o lote da escala excluida
          $this->load();
          // Executa sql de remoção da escala
          $this->RunQuery($sql);
          
          // Gera sql para obter o ultimo lote da escala de abate
          $sqlOrdem = "Select max(lote) as max from escala where data='%s'";
            $r = sprintf($sqlOrdem, $this->getData());
            
            $result = $this->RunSelect($r);
          // Atualiza lista dos lotes de abate após a exclusão
                for($i = $this->getLote(); $i < $result[0]['max']; $i++){
                    $this->ordena(-1, $i);
                } 
          // Retorna para pre escala
              $sqlPe = "UPDATE 
                            escala_pre 
                           SET 
                            usuario_alteracao = '%s', 
                            data_alteracao = current_timestamp,
                            situacao = 'pe' 
                           where 
                            id = %s ";
              $rs = sprintf($sqlPe, $this->getUsuario(), $this->getPreEscala());
              
              $this->RunQuery($rs);
             
        }
        
        public function select($where="",$order="")
        {
            $sql = sprintf($this->sqlSelect, $where, $order);
            return $this->RunSelect($sql);
            
        }
        
        public function load()
        {
            $rs = $this->select(sprintf(" and id = %s", $this->getId()));
 
            $this->setCorretor($rs[0]['corretor']);
            $this->setData($rs[0]['data']);
            $this->setPecuarista($rs[0]['pecuarista']);
            $this->setQtdBoi($rs[0]['qtdBoi']);
            $this->setQtdVaca($rs[0]['qtdVaca']);
            $this->setQtdNov($rs[0]['qtdNov']);
            $this->setQtdTouro($rs[0]['qtdTouro']);
            $this->setLote($rs[0]['lote']);
            $this->setPreEscala($rs[0]['pre_escala']);
                        
            return $this;
        }
        
        public function ordena($ordem, $lote)
        {
             $sobe = $lote - $ordem;
             $desce = $lote;
             
             $sql = "UPDATE escala set lote = %s where lote = %s and data = '%s'";
                
             $r1 = sprintf($sql, 0, $sobe, $this->getData());
             $r2 = sprintf($sql, $sobe,$desce, $this->getData());
             $r3 = sprintf($sql, $desce, 0, $this->getData());
             
             // echo $r1."<br />".$r2."<br />".$r3;
             
             $this->RunQuery($r1);
             $this->RunQuery($r2);      
             $this->RunQuery($r3);
             
        }
    }
    
    

?>