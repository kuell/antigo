<?php
    require_once 'class/TaxaGrupo.class.php';
    require_once '../sm.php';
    
    $gp = new TaxaGrupo();
    
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['add'])){
            $sm->assign("op", "Adicionar");
            $sm->assign("grupo", array());
        }
        if(isset($_GET['editar'])){
            $gp->valor_pk = $_GET['editar'];
            
            $sm->assign("grupo", $gp->selectAll($gp));
            $sm->assign("op", "Editar");
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        switch ($_POST['acao']){
            case "Adicionar":
                unset($_POST['acao']);
                unset($_POST['id']);
                
                $gp->campos_valores = $_POST;
                $gp->insert($gp);
                break;
            case "Editar":
                unset($_POST['acao']);
                $gp->valor_pk = $_POST['id'];
                unset($_POST['id']);
                
                $gp->campos_valores = $_POST;
                $gp->update($gp);
                header("Location: ?");
                break;
        }
        
    }
    $sm->assign("grupo", $gp->selectAll($gp));
    $sm->display("view/grupo.tpl");
?>
