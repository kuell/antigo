<?php
require_once 'sm.php';
require_once 'core/ProdutoPedido.php';
require_once 'core/PedidoCompra.php';

$pedido  = new PedidoCompra();
$produto = new ProdutoPedido();
$prod    = $produto->RunSelect("Select * from produto order by PRO_DESCRICAO");
$setor   = $produto->RunSelect("Select * from setor");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
	if (isset($_GET['incluir'])) {
		$produto->setPcId($_GET['id']);

		$sm->assign("prodPed", $produto->select(sprintf(" and pcId = '%s'", $produto->getPcId())));

		$sm->assign("idPedido", $produto->getPcId());
		$sm->assign("produtos", $prod);
		$sm->display("view/produto_pedido.html");
	}
	if (isset($_GET['editar'])) {
		$produto->setPcId($_GET['idPedido']);
		$produto->setProdId($_GET['idProduto']);
		$produto->loadProduto();

		$sm->assign("idPedido", $produto->getPcId());
		$sm->assign("idProduto", $produto->getProdId());
		$sm->assign("produto", $produto->getProdId());
		$sm->assign("qtdEstoque", $produto->getQtdEstoque());
		$sm->assign("produto", $produto->getDescProduto());
		$sm->assign("qtd", $produto->getQtd());

		$sm->display("view/produto_pedido.html");

	}
	if (isset($_GET['excluirProduto'])) {
		$produto->setPcId($_GET['idPedido']);
		$produto->setProdId($_GET['idProduto']);
		$produto->delete();

		header("Location: ?incluir&id=".$produto->getPcId());
	}
	if (isset($_GET['comprarProduto'])) {
		if (isset($_GET['Comprar'])) {
			$produto->setPcId($_GET['idPedido']);
			$produto->setProdId($_GET['idProduto']);
			$produto->setDataCompra(date('Y-m-d'));

			$produto->comprarProduto();
		}

		$sm->assign("produtos", $produto->select(" and a.status = 'REQUISITADO'", "group by b.`PRO_ID` order by d.prioridade desc, a.pcId"));
		$sm->display("view/comprar_produtos.html");
	}
	if (isset($_GET['receberProduto'])) {
		$sm->assign("produtos", $produto->select(" and a.status = 'COMPRADO'", "group by b.`PRO_ID` order by d.prioridade desc"));
		$sm->display("view/receber_list.html");
	}
	if (isset($_GET['Receber'])) {
		$produto->setPcId($_GET['idPedido']);
		$produto->setProdId($_GET['idProduto']);
		$produto->setDataRecebimento(date('Y-m-d'));

		$produto->receberProduto();
		header("Location: ?receberProduto");
	}
	if (isset($_GET['relFreq'])) {
		$sm->assign("setor", $setor);
		$sm->display("view/rel_frequencia.html");
	}
	if (isset($_GET['relStatus'])) {
		$sm->assign("setor", $setor);
		$sm->assign("produtos", $prod);
		$sm->display("view/rel_status.html");
	}
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	if ($_POST['acao'] == "Incluir") {
		$produto->setPcId($_POST['idPedido']);
		$produto->setProdId($_POST['produto']);
		$produto->setQtd($produto->dbNum($_POST['qtd']));
		$produto->setQtdEstoque($produto->dbNum($_POST['estoque']));
		$produto->setStatus("REQUISITADO");

		$produto->insert();

		header("Location: ?incluir&id=".$produto->getPcId());
	}
	if ($_POST['acao'] == "Editar") {
		$produto->setPcId($_POST['idPedido']);
		$produto->setProdId($_POST['idProduto']);
		$produto->setQtd($_POST['qtd']);

		$produto->editaProduto();

		header("Location: ?incluir&id=".$produto->getPcId());
	}
	if ($_POST['acao'] == "Buscar") {
		!empty($_POST['pedido'])?$pedId = " and pcId ='".$_POST['pedido']."'":$pedId = "";
		!empty($_POST['osi'])?$osi      = "and osi = '".$_POST['osi']."'":$osi      = "";
		!empty($_POST['prod'])?$p       = " and b.`PRO_DESCRICAO` like '%".$_POST['prod']."%'":$p       = "";

		$sm->assign("produtos", $produto->select(" and a.status = 'REQUISITADO' $pedId $osi $p", "order by d.prioridade desc"));

		$sm->display("view/".$_POST['template']);

	}
	if ($_POST['acao'] == 'verifica') {
		$produto->setProdId($_POST['prodId']);
		$res = $produto->verificaProduto();

		echo "\n".$res[0]['resultado'];
	}
}

?>
