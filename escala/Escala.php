<?php
    require_once "sm.php";
    require_once "core/Escala.php";
    require_once '../cadastros/core/Corretor.php';
    
    $escala = new Escala();
    $cor = new Corretor();
    
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['add'])){
            $sm->assign("op", "Adicionar");
        }
        if(isset($_GET['excluir'])){
            $escala->setId($_GET['id']);
            $escala->delete();
            header("Location : ?data=".$_GET['data']);
        }
        if(isset($_GET['ordem'])){
            $escala->setData($escala->dbData($_GET['data']));
            $escala->ordena($_GET['ordem'], $_GET['lote']);
            header("Location: ?data=".$_GET['data']);
        }
        if(isset($_GET['editar'])){
            $sm->assign("op","Editar");
            $escala->setId($_GET['id']);
            $escala->load();
            
            $sm->assign("data", $escala->getData());
            $sm->assign("pecuarista", $escala->getPecuarista());
            $sm->assign("c", $escala->getCorretor());
            $sm->assign("qtdBoi", $escala->getQtdBoi());
            $sm->assign("qtdVaca", $escala->getQtdVaca());
            $sm->assign("qtdNov", $escala->getQtdNov());
            $sm->assign("qtdTouro", $escala->getQtdTouro());
            $sm->assign("id", $escala->getId());
            
        }
        if(empty($_GET['data'])){
            $data = date("d/m/Y");
        }
        else{
            $data = $_GET['data'];
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] ==  "POST"){
        switch ($_POST['acao']){
            case "Adicionar":
                $escala->setData($escala->dbData($_POST['data']));
                $escala->setPecuarista($_POST['pecuarista']);
                $escala->setCorretor($_POST['corretor']);
                $escala->setQtdBoi($_POST['qtdBoi']);
                $escala->setQtdVaca($_POST['qtdVaca']);
                $escala->setQtdNov($_POST['qtdNov']);
                $escala->setQtdTouro($_POST['qtdTouro']);
                $escala->insert();
                
                $data = $_POST['data'];
                break;
            case "Editar":
                $escala->setPecuarista($_POST['pecuarista']);
                $escala->setCorretor($_POST['corretor']);
                $escala->setQtdBoi($_POST['qtdBoi']);
                $escala->setQtdVaca($_POST['qtdVaca']);
                $escala->setQtdNov($_POST['qtdNov']);
                $escala->setQtdTouro($_POST['qtdTouro']);
                $escala->setId($_POST['id']);
                $escala->update();
             
               header("Location: ?data=".$_POST['data']);
            
                break;
            default :
                header("Location: ?data=".$_POST['data']);
                break;
        }
    }
    
    $sm->assign("corretor", $cor->select("and cor_ativo = 1"));
    $sm->assign("data", $escala->dbData($data));
    $sm->assign("escala", $escala->select(" and data = '".$escala->dbData($data)."'", "order by lote" ));
    $sm->display("view/escala.tpl");
    
?>
