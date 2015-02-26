<?php
    require_once '../conf/Base.class.php';

class TaxaItem extends Base{
    public function __construct($campos = array()) {
        $this->tabela = "taxa_item";
        $this->campo_pk = "id";
        
        if(sizeof($campos) < 0){
            $this->campos_valores = array(
                "descricao"=>NULL,
                "grupo"=>NULL                
            );
        }
        else{
            $this->campos_valores = $campos;
        }
        
    }
    
    public function listaItem($where="", $order="") {
        $sql = "Select 
                    a.*,
                    b.`descricao` as `descGrupo`
                from
                        `taxa_item` a
                    inner join taxa_grupo b ON(a.`grupo` = b.`id`)
                where
                    1=1 %s %s";
        $rs = $this->RunSelect(sprintf($sql,$where,$order));
        
        return $rs;
    }

    
}

?>
