<?php
    require_once 'sm.php';
    require_once '../cadastros/core/Corretor.php';
    require_once 'core/PreEscala.php';

    $cor = new Corretor();
    $pe = new PreEscala();

//Verifica o ano    
    if(isset($_GET['ano'])){
        $ano = $_GET['ano'];
    }
    else{
        $ano = date("Y");  
    }
//Verifica o mes 
    if(isset($_GET['ref'])){
        $mes = $_GET['mes'] + ($_GET['ref']);
        if($mes == 0){
            $mes = 12;
            $ano = $ano - 1;
        }
        else if($mes >= 13){
            $mes = 1;
            $ano = $ano + 1;
        }
    }
    else{
        $mes = date('m');
    }    
    
    $total = $pe->calcAbateMes($mes, $ano);
    $uDia =  cal_days_in_month(CAL_GREGORIAN, $mes, $ano);  
    $numSemana = 0;
    
    for($i = 1; $i<= $uDia; $i++)
    {      
        $data = date("Y-m-d", strtotime($ano."/".$mes."/".$i));
        
        $semana = date('w', strtotime($data));  
        if($semana == 0){
            $numSemana ++; 
        }    
        $dia[$numSemana][$semana] = $i;
    }  
    
    
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['add'])){
            $sm->assign("op", "Adicionar");
            $sm->assign("lista", $pe->select(" and a.data = '".$_GET['data']."'"));
        }     
        if(isset($_GET['conf'])){
            $pe->setId($_GET['conf']);
            $pe->confirmar();
            
            header("Location: ?add=1&data=".$_GET['data']);
        }
        if(isset($_GET['del'])){
            $pe->setId($_GET['del']);
            $pe->delete();
            header("Location: ?add=1&data=".$_GET['data']);
        }
        if(isset($_GET['editar'])){
            $pe->setId($_GET['editar']);
            $pe->load();
            
            $sm->assign("data", $pe->getData());
            $sm->assign("pecuarista", $pe->getPequarista());
            $sm->assign("cr", $pe->getCorretor());
            $sm->assign("qtdBoi", $pe->getQtdBoi());
            $sm->assign("qtdVaca", $pe->getQtdVaca());
            $sm->assign("qtdTouro", $pe->getQtdTouro());
            $sm->assign("qtdNov", $pe->getQtdNov());
            $sm->assign("id", $pe->getId());
            $sm->assign("op", "Editar");
            
            $sm->assign("lista", $pe->select(" and a.data = '".$_GET['data']."'"));
            
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        switch ($_POST['acao']){
            case "Adicionar":
                $pe->setData($pe->dbData($_POST['data']));
                $pe->setCorretor($_POST['corretor']);
                $pe->setPequarista($_POST['pecuarista']);
                $pe->setQtdBoi($_POST['qtdBoi']);
                $pe->setQtdVaca($_POST['qtdVaca']);
                $pe->setQtdNov($_POST['qtdNov']);
                $pe->setQtdTouro($_POST['qtdTouro']);
                
                $pe->insert();
                header("Location: ?add=1&data=".$pe->dbData($_POST['data']));
                
                break;
            case "Editar":
                $pe->setData($pe->dbData($_POST['data']));
                $pe->setCorretor($_POST['corretor']);
                $pe->setPequarista($_POST['pecuarista']);
                $pe->setQtdBoi($_POST['qtdBoi']);
                $pe->setQtdVaca($_POST['qtdVaca']);
                $pe->setQtdNov($_POST['qtdNov']);
                $pe->setQtdTouro($_POST['qtdTouro']);
                $pe->setId($_POST['id']);
                
                $pe->update();
                header("Location: ?add=1&data=".$pe->dbData($_POST['data']));
                
                break;
        }
    }
    $sm->assign("cor", $cor->select(" and cor_ativo = 1","order by cor_cod"));
    $sm->assign("qtd", $total);
    $sm->assign("ano", $ano);
    $sm->assign("mes", $ano."-".$mes."-01");
    $sm->assign("mesNome", $pe->nomeMes($mes));
    $sm->assign("dia", $dia);
    $sm->display("view/pre_escala.tpl");
    
    
?>
