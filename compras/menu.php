<?php
    session_start();
?>
<div id="menu-container">
    <ul>
        <li class="menu-main-item"><a href="#">Cadastro</a>
            <ul class="menu-sub-item">
                <li><a href="../paginas/Produto/pro_list.php" target="conteudo">Produto</a></li>
                <li><a href="../paginas/setor/setor_list.php" target="conteudo">Setor</a></li>
                <li><a href="../paginas/Requisitante/resquisit_list.php" target="conteudo">Solicitante</a></li>
                <li><a href="../paginas/unidade/unidade.php" target="conteudo">Unidade de medida</a></li>
            </ul>
        </li>
        <li class="menu-main-item"><a href="#">Digitac&atilde;o</a>
            <ul class="menu-sub-item">
                <li><a href="PedidoCompra.php" target="conteudo">Pedido</a></li>
            </ul>
        </li>
        <?php if ($_SESSION['kt_login_level'] == 1) { ?>
            <li class="menu-main-item"><a href="#">Comprar</a>	
                <ul class="menu-sub-item">
                    <li><a href="ProdutoPedido.php?comprarProduto" target="conteudo">Por Produto</a></li>
                    <li><a href="PedidoCompra.php?compraPedido" target="conteudo">Por Pedido</a></li>
                </ul>
            </li>
        <?php } ?>
        <li class="menu-main-item"><a href="#">Receber</a>
            <ul class="menu-sub-item">
                <li><a href="ProdutoPedido.php?receberProduto" target="conteudo">Por produto</a></li>
       <!--         <li><a href="" target="conteudo">Por Pedido</a></li> -->
            </ul>
        </li>
        <li class="menu-main-item"><a href="#">Relatorios</a>
            <ul class="menu-sub-item">
                <li><a href="ProdutoPedido.php?relStatus" target="conteudo">Por Status</a></li>
                <li><a href="ProdutoPedido.php?relFreq" target="conteudo">Frequencia</a></li>
            </ul>
        </li>
        <li class="menu-main-item"><a href="../index2.php">Sair</a></li>
    </ul>
</div>