<?php
    require_once '../cadastros/model/mSetor.php';
    
    class aSetor extends mSetor{
        protected $sqlSelect = "Select * from setor";
        
        public function select ($where="", $order=""){
            $sql = sprintf($this->sqlSelect,$where, $order);
            return $this->RunSelect($sql);
        }
        
    }
?>
