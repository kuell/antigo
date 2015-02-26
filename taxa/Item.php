<?php
    require_once 'class/TaxaItem.class.php';
    require_once 'class/TaxaGrupo.class.php';
    require_once '../sm.php';
    
    $item = new TaxaItem();
    $grupo = new TaxaGrupo();
    
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['add'])){
            $sm->assign("op","Adicionar");
        }
        if(isset($_GET['editar'])){
            $item->valor_pk = $_GET['editar'];
            $sm->assign("i",$item->selectAll($item));
            $sm->assign("op","Editar");
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        switch ($_POST['acao']){
            case "Adicionar":
                unset($_POST['acao']);
                unset($_POST['id']);
                
                $item->campos_valores = $_POST;
                $item->insert($item);
                header("Location: ?");
                
                break;
            case "Editar":
                unset($_POST['acao']);
                $item->valor_pk = $_POST['id'];
                unset($_POST['id']);
                
                $item->campos_valores = $_POST;
                $item->update($item);
                
                header("Location: ?");
                
                break;
        }
    }
    
    $sm->assign("grupo", $grupo->selectAll($grupo));
    $sm->assign("item", $item->listaItem());
    $sm->display("view/item.tpl");
?>
