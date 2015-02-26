<?php

require_once '../Connections/conn_novo.php';

abstract class Crud extends Conecction {

    public function insert($obj) 
    {
        $sql = "Insert into " . $obj->tabela . " (";
        //Pega os campos
        for ($i = 0; $i < count($obj->campos_valores); $i++) {
            $sql .= key($obj->campos_valores).", ";
            
            next($obj->campos_valores);
        }
        reset($obj->campos_valores);
            
        $sql .= "usuario_inclusao, data_inclusao)";
        
        $sql.= " values(";
        //Pega os valores
        for ($i = 0; $i < count($obj->campos_valores); $i++) {
            $sql .= is_numeric($obj->campos_valores[key($obj->campos_valores)]) ?
                    $obj->campos_valores[key($obj->campos_valores)].", " :
                    "'" . $obj->campos_valores[key($obj->campos_valores)] . "', ";
            next($obj->campos_valores);
        }
        $sql .= "'".$this->getUsuario()."', ".$this->getData().")";
        
        //die($sql);
        return $this->RunQuery($sql);
    }

    public function update($obj) 
    {
        $sql = "UPDATE " . $obj->tabela . " SET ";
        //Pega os campos
        for ($i = 0; $i < count($obj->campos_valores); $i++) {
            $sql .= key($obj->campos_valores) . " = ";

            $sql .= is_numeric($obj->campos_valores[key($obj->campos_valores)]) ?
                    $obj->campos_valores[key($obj->campos_valores)].", " :
                    "'" . $obj->campos_valores[key($obj->campos_valores)] . "', ";
            next($obj->campos_valores);
        }
        
        $sql .= "usuario_alteracao = '".$this->getUsuario()."', data_alteracao = ".$this->getData()."";
        
        $sql.= " WHERE " . $obj->campo_pk . " = ";
        if (is_numeric($obj->valor_pk)) {
            $sql .= $obj->valor_pk;
        } else {
            $sql .= "'" . $obj->valor_pk . "'";
        }
        //die($sql);
        return $this->RunQuery($sql);
    }
    
    public function delete($obj)    
    {
        $sql = "DELETE FROM ".$obj->tabela." WHERE ".$obj->campo_pk." = " ;
        if(is_numeric($obj->valor_pk)){
            $sql .= $obj->valor_pk;
        }
        else{
            $sql .= "'".$obj->valor_pk."'";
        }
        //die($sql);
        return $this->RunQuery($sql);
    }
    
    public function selectAll($obj)
    {
        
        $sql = "SELECT * FROM ".$obj->tabela." ";
        
        if(!empty($obj->valor_pk)){
            $sql .= "WHERE ".$obj->campo_pk." = ".  $this->sqlNumero($obj->valor_pk);
        }
        
        if($obj->etc != null){
           $sql .= $obj->etc; 
        }
        //echo ($sql);
        
        return $this->RunSelect($sql);
    }
    
    public function selectCampos($obj)
    {
        $sql = "SELECT ";
        
        $campos = array_keys($obj->campos_valores);
        
        for($i=0; $i < (count($obj->campos_valores)); $i++){
            
            $sql .=  $campos[$i];
            
            if($i != (count($obj->campos_valores) - 1)){
                $sql .= ", ";
            }
            else{
                $sql .= "  FROM ".$obj->tabela;
            }
            
        }
        
        if($obj->etc != null){
            $sql .=" ". $obj->etc; 
        }
        return $this->RunSelect($sql);
    }
}

?>
