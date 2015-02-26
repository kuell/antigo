<?php

require_once '../sm.php';
require_once 'class/Taxa.class.php';
require_once 'class/TaxaItem.class.php';
require_once '../cadastros/core/Corretor.php';
require_once 'class/TaxaGrupo.class.php';
require_once 'class/TaxaItens.class.php';

$tx = new Taxa();
$cor = new Corretor();
$gr = new TaxaGrupo();
$txi = new TaxaItens();
$item = new TaxaItem();

if (isset($_GET['datai']) && isset($_GET['dataf'])) {
    $data = "and a.data between '" . $tx->dbData($_GET['datai']) . "' and '" . $tx->dbData($_GET['dataf']) . "'";
} else {
    $data = " and a.data = now() ";
}
!empty($_GET['cor']) ? $c = " and corretor = " . $_GET['cor'] : $c = "";

$sm->assign("cor", $cor->select(" and cor_ativo = 'SIM'"));

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['rel'])) {
		$sm->assign("cor", $cor->select("order by cor_nome"));
        $sm->display("view/rel_taxas.tpl");
        
		die;
    }
    if (isset($_GET['excluirItem'])) {
        $txi->valor_pk = $_GET['item'];
        $txi->delete($txi);
        header("Location: ?addItem&idTaxa=" . $_GET['idTaxa'] . "&g=" . $_GET['g']);
    }
    if (isset($_GET['add'])) {
        $sm->assign("op", "Adicionar");
    }
    if (isset($_GET['edit'])) {
        $tx->valor_pk = $_GET['edit'];

        $tax = $tx->selectAll($tx);

        $sm->assign("t", $tax[0]);
        $sm->assign("op", "Editar");
    }
    if (isset($_GET['grupo'])) {
        $txi->campo_pk = "idTaxa";
        $txi->valor_pk = $_GET['grupo'];

        $sm->assign("item", $txi->listaItens("and a.id =" . $_GET['grupo']));
        $sm->assign("grupo", $gr->selectAll($gr));
        $sm->display("view/taxaGrupo.tpl");
        die;
    }
    if (isset($_GET['addItem'])) {
        $item->campo_pk = "grupo";
        $item->valor_pk = $_GET['g'];

        //   print_r($item->selectAll($item));

        $sm->assign("item", $item->selectAll($item));
        $sm->assign("taxaItem", $txi->listaItens(" and a.id = " . $_GET['idTaxa']));
        $sm->assign("taxa", $tx->listaTaxa(" and a.id = " . $_GET['idTaxa']));
        $sm->display("view/taxaItem.tpl");
        die;
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	switch ($_POST['acao']) {
        case "Adicionar";
            unset($_POST['acao']);
            unset($_POST['id']);

            $_POST['data'] = $tx->dbData($_POST['data']);

            $tx->campos_valores = $_POST;
            $id = $tx->insert($tx);

           header("Location: ?edit=" . $id['id']);
        	    
	break;
        case "Editar";
            unset($_POST['acao']);
            
            $tx->valor_pk = $_POST['id'];

            unset($_POST['id']);

            $_POST['data'] = $tx->dbData($_POST['data']);

            $tx->campos_valores = $_POST;
            $id = $tx->update($tx);
            header("Location: ?edit=" . $id['id']);
            break;
        case "Incluir":
            unset($_POST['acao']);
            $_POST['qtd'] = $txi->dbNum($_POST['qtd']);
            $_POST['peso'] = $txi->dbNum($_POST['peso']);
            $_POST['valor'] = $txi->dbNum($_POST['valor']);

            $txi->campos_valores = $_POST;

            $txi->insert($txi);
            header("Location: ?addItem&idTaxa=" . $_POST['idTaxa'] . "&g=" . $_GET['g']);
            break;
        case "buscar":

            echo $tx->buscaCor($_POST['cor'], $_POST['data']);
            die;
            break;
        case "delete":
            
            $tx->valor_pk = $_POST['id'];
            $tx->campo_pk = "id";
            unset($_POST['acao']);
            $tx->valor_pk = $_POST['id'];
            $tx->delete($_POST);
            
            die;
            break;
        default:
            header("Location: ?data=" . $_POST['data']);
            break;
    }
}

$sm->assign("grupo", $gr->selectAll($gr));
$sm->assign("taxa", $tx->listaTaxa($data . $c, " order by a.id"));
$sm->display("view/taxa.tpl");
?>
