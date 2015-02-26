<?php
    require_once '../cadastros/model/mCorretor.php';
    
    class aCorretor extends mCorretor{
        protected $sqlSelect = "Select * from corretor where 1=1 %s %s";
        
        public function select($where='', $order=""){
            $sql = sprintf($this->sqlSelect,$where, $order);
            
            return $this->RunSelect($sql);
        }
               
    }
    
?>
