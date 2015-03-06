<?php

require ('../Connections/conect_mysqli.php');
session_start();

print_r($_POST);

if(function_exists($_POST['funcao'])){
    call_user_func($_POST['funcao']);
}

function ajuste($id){
    $qtd = str_replace(',','.', $_POST['qtd']);
    $peso = str_replace(',','.', $_POST['peso']);
    $valor = str_replace(',', '.', $_POST['valor']);
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $usuario = $_SESSION['kt_login_user'];

    $sql = sprintf("update
                taxaitens
                    set
                        qtd = %s,
                        valor = %s,
                        peso = %s,
                        tipo = '%s',
                        data_alteracao = now(),
                        usuario_alteracao = '%s'
                where
                    id = %s", $qtd, $valor, $peso, $tipo, $usuario, $id);
    $con = new Connect();

    return $con->executeSql($sql);
}


?>