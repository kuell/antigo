<?php
    require_once 'model/mPreEscala.php';
    require_once 'core/Escala.php';
    
    class aPreEscala extends mPreEscala{
        protected $sqlInsert = "INSERT INTO `escala_pre`(`data`,  `corretor`,  `pecuarista`,  `qtdBoi`,  `qtdvaca`,
                                                        `qtdNov`, `qtdTouro`, `situacao`, `usuario_inclusao`, `data_inclusao`) 
                                                  VALUE ('%s', %s, '%s', %s, %s, %s, %s, 'pe', '%s', current_timestamp)";
        protected $sqlUpdate = "UPDATE `escala_pre`
                                               set
                                                    `data` = '%s',
                                                    `corretor` = '%s',
                                                    `pecuarista` = '%s',
                                                    `qtdBoi` = '%s',
                                                    `qtdVaca` = '%s',
                                                    `qtdNov` = '%s',
                                                    `qtdTouro` = '%s',
                                                    usuario_alteracao = '%s', 
                                                    data_alteracao = current_timestamp
                                                where
                                                    id = '%s'";
        protected $sqlDelete = "DELETE FROM escala_pre WHERE id = %s";
        protected $sqlSelect = 'Select 
                                    a.*,
                                    b.*
                                from
                                        escala_pre a 
                                    inner join corretor b ON(a.`corretor` = b.`cor_id`)
                                where 
                                    1 = 1 %s %s';
        
        public function insert(){
            $sql = sprintf($this->sqlInsert, $this->getData(), 
                                             $this->getCorretor(),
                                             $this->getPequarista(),
                                             $this->getQtdBoi(),
                                             $this->getQtdVaca(),
                                             $this->getQtdNov(),
                                             $this->getQtdTouro(),
                                             $this->getUsuario());
            return $this->RunQuery($sql);
        }
        public function update()
        {
            $sql = sprintf($this->sqlUpdate, $this->getData(),
                                             $this->getCorretor(),
                                             $this->getPequarista(),
                                             $this->getQtdBoi(),
                                             $this->getQtdVaca(),
                                             $this->getQtdNov(),
                                             $this->getQtdTouro(),
                                             $this->getUsuario(),
                                             $this->getId()
                                             );           
            return $this->RunQuery($sql);
            
            
        }
        public function delete()
        {
            $sql = sprintf($this->sqlDelete, $this->getId());
            return $this->RunQuery($sql);
        }
        public function select($where="", $order="")
        {
            $sql = sprintf($this->sqlSelect, $where, $order); 
            return $this->RunSelect($sql);
        }
        public function load()
        {
            $rs = $this->select(sprintf(" and a.id = '%s'", $this->getId()));
            
            $this->setId($rs[0]['id']);
            $this->setData($rs[0]['data']);
            $this->setPequarista($rs[0]['pecuarista']);
            $this->setCorretor($rs[0]['corretor']);
            $this->setQtdNov($rs[0]['qtdNov']);
            $this->setQtdTouro($rs[0]['qtdTouro']);
            $this->setQtdVaca($rs[0]['qtdVaca']);
            $this->setQtdBoi($rs[0]['qtdBoi']);
            return $this;
        }   
        public function calcAbateMes($mes="", $ano="")
        {            
            $sql = "Select 
                        day(a.`data`) as dia, 
                        sum(a.`qtdBoi` + a.`qtdvaca` + a.`qtdTouro` + a.`qtdNov`) as total
                    from
                            escala_pre a
                    where
                        month(a.data) = '%s' and year(a.data) = '%s'
                    group by 
                            a.`data`";
            $rs = sprintf($sql, $mes, $ano);
            $r = $this->RunSelect($rs);
            
            $result = null;
            foreach ($r as $key){
                $result[$key['dia']] = $key['total'];
            }
                        
            return $result;
        }
        public function confirmar()
        {
           $sql = "UPDATE 
                        escala_pre 
                            set 
                                situacao = 'e',
                                usuario_alteracao = '%s',
                                data_alteracao = current_timestamp
                            where 
                                id = %s";
       
           $rs = sprintf($sql, $this->getUsuario(), $this->getId());
           
           $esc = new Escala();
           
           $pe = $this->load();
           
           $esc->setData($this->getData());
           $esc->setPecuarista($this->getPequarista());
           $esc->setCorretor($this->getCorretor());
           $esc->setQtdBoi($this->getQtdBoi());
           $esc->setQtdVaca($this->getQtdVaca());
           $esc->setQtdNov($this->getQtdNov());
           $esc->setQtdTouro($this->getQtdTouro());
           $esc->setPreEscala($pe->getId());
           
           $esc->insert();
           return $this->RunQuery($rs);
           
        }
    }
?>
