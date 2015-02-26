<?php
    require_once 'core/PedidoCompra.php';  
    require_once 'core/ProdutoPedido.php';
    require_once '../cadastros/core/Setor.php';
    require_once 'sm.php';
   
    $pedido = new PedidoCompra();
    $produto = new ProdutoPedido();
    
    $sm->assign("pedidos", $pedido->select(" and status = 1","order by prioridade desc, data"));
    $sm->assign("listaSetor", $pedido->RunSelect("Select * from setor"));
    
    
    if($_SERVER['REQUEST_METHOD'] === "GET"){
       if(isset($_GET['editar'])){
            $pedido->setId($_GET['id']);
            $pedido->load();
            
            $sm->assign("setor", $pedido->getSetor());
            $sm->assign("prioridade", $pedido->getPrioridade());
            $sm->assign("solicitante", $pedido->getSolicitante());
            $sm->assign("setor", $pedido->getSetor());
            $sm->assign("id", $pedido->getId());
            $sm->assign("osi", $pedido->getOsi());
            $sm->assign("obs", $pedido->getObs());
            
            $sm->display("view/pedido_form.html");
        }     
       elseif(isset($_GET['excluir'])){
           $pedido->setId($_GET['id']);
           $pedido->delete();
           header("Location: ?");
       }
       elseif(isset($_GET['visualizar'])){

            $pedido->setId($_GET['id']);
            $prod = $produto->select(sprintf(" and pcId = '%s' group by b.`PRO_ID`", $_GET['id']));
            $pedido->load();

            $sm->assign("produtos", $prod );
            $sm->assign("id", $pedido->getId());
            $sm->assign("data", $pedido->dataHora($pedido->getData()));
            $sm->assign("solicitante", $pedido->getSolicitante());
            $sm->assign("setor", $pedido->getSetor());
            $sm->assign("osi", $pedido->getOsi());
            $sm->assign("obs", $pedido->getObs());

            $sm->display("view/visualiza.html");
        }
       elseif(isset($_GET['Incluir'])){
            $sm->display("view/pedido_form.html");
            
            }
       elseif(isset($_GET['Comprar'])){
                $pedido->setId($_GET['id']);
                $pedido->compraPedido();
             header("Location: ?compraPedido");
            }
       elseif(isset($_GET['Reprovar'])){
                $pedido->setId($_GET['id']);
                $pedido->reprovaPedido();
             header("Location: ?compraPedido");
            }
       elseif(isset($_GET['compraPedido'])){
            $sm->assign("pedidos", $pedido->select(" and status = 1"));
            $sm->display("view/comprar_pedido.html");          
        }
       else{       
            $sm->display("view/pedido_list.html");
        }
    }
    
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){        
       if($_POST['acao'] == "Salvar"){
        
            $pedido->setSetor($_POST['setor']);
            $pedido->setPrioridade($_POST['prioridade']);
            $pedido->setSolicitante($_POST['solicitante']);
            $pedido->setObs($_POST['obs']);

            $id = $pedido->insert();
            header("Location: ?editar&id=".$id['id']);
        } 
       elseif($_POST['acao'] == "Editar"){
            $pedido->setSetor($_POST['setor']);
            $pedido->setPrioridade($_POST['prioridade']);
            $pedido->setSolicitante($_POST['solicitante']);
            $pedido->setOsi($_POST['osi']);
            $pedido->setObs($_POST['obs']);
            $pedido->setId($_POST['id']);
            
            $pedido->update();
            header("Location: ?editar&id=".$pedido->getId());
        }
        elseif($_POST['acao'] == 'Buscar'){
            !empty($_POST['idPedido']) ? $p = " and a.id = ".$_POST['idPedido']: $p = "";
            !empty($_POST['osi']) ? $o = " and a.osi = ".$_POST['osi']: $o = "";

            $sm->assign("pedidos",$pedido->select($p.$o));
            $sm->display("view/".$_POST['template']);
        }
        else{
            header("Location: ?");
        }
    } 
    

?>
