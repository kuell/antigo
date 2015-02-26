<?php
    require_once '../conf/Base.class.php';
class TaxaItens extends Base {
    public function __construct($campos = array()) {
        $this->tabela = "taxaitens";
        $this->campo_pk = "id";
        
        if(sizeof($campos) < 0){
            $this->campos_valores = array(
                "idTaxa"=>NULL,
                "idItem"=>NULL,
                "qtd"=>NULL,
                "peso"=>NULL,
                "valor"=>NULL,
                "tipo"=>NULL
            );
        }
        else{
            $this->campos_valores = $campos;
        }
    }
    public function listaItens($where="", $order=""){
        $sql = "Select 
                    a.id as idTaxa,
                    a.`data` as data,
                    c.`descricao` as item,
                    b.id as idItem,
                    d.`descricao` as grupo,
                    b.`qtd` as qtd,
                    b.`peso` as peso,
                    b.`valor` as valor, 
                    b.`tipo` as tipo
                from	
                    taxa a
                    inner join `taxaitens` b on(a.`id` = b.`idTaxa`)
                    inner join `taxa_item` c on(b.`idItem` = c.`id`)
                    inner join `taxa_grupo` d on(c.`grupo` = d.`id`)
                where
                    1=1 %s %s";
        
        $rs = $this->RunSelect(sprintf($sql,$where,$order));
        
        return $rs;
    }
    
}

?>
