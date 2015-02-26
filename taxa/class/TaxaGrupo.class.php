<?php
    require_once '../conf/Base.class.php';

class TaxaGrupo extends Base {
    function __construct($campos = array()) {
        $this->tabela = "taxa_grupo";
        $this->campo_pk = "id";
        if(sizeof($campos) < 0){
            $this->campos_valores = array(
                "descricao"=>null                
            );
        }
        else{
            $this->campos_valores = $campos;
        }
    }

}

?>
