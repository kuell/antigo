<?php
    require_once 'Crud.class.php';

abstract class Base extends Crud {
    #### PROPRIEDADES ###
    public $tabela = null;
    public $campos_valores = array();
    public $campo_pk = null;
    public $valor_pk = null;
    public $etc = null;

    ### METODOS  ###

    public function addCampo($campo = null, $valor = null) {
        if ($campo != null) {
            $this->campos_valores[$campo] = $valor;
        }
    }//fim addcampo

    public function delCampo($campo = null) {
        if (array_key_exists($campo, $this->campos_valores)) {
            unset($this->campos_valores[$campo]);
        }
    }//fim delCampo

    public function setValor($campo = null, $valor = null) {
        if($campo!= null && $valor != null){
            $this->campos_valores[$campo] = $valor;
        }
    }//fim setValor
    public function getValor($campo=null){
        if($campo != null && array_key_exists($campo, $this->campos_valores)){
          return $this->campos_valores[$campo];
        }
        else{
            return false;
        }
    }//fim getValor    
}

?>
