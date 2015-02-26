<?php
	session_start();

?>


<div id="menu-container">
	<ul>
         <li class="menu-main-item">
         <a href="#">Cadastro</a>
         <ul class="menu-sub-item">
               <li> <a href="../paginas/setor/setor_list.php" target="conteudo" title="setor">setor</a> </li>
			  <li> <a href="../paginas/Requisitante/resquisit_list.php" target="conteudo" title="setor">requisitante</a> </li>
              <li> <a href="../paginas/equipamento/equip_list.php" target="conteudo" title="equipamento">equipamento</a> </li>
              <li> <a href="../paginas/Empresa/empresa_list.php" target="conteudo" title="empresa">empresa</a> </li>
              <li> <a href="../paginas/servico/servico_list.php" target="conteudo" title="ação">Serviço</a> </li>
           </ul>
  		</li>
        <li class="menu-main-item"><a href="#">Movimento</a>
            <ul class="menu-sub-item">
             <li> <a href="movimentacao/mov_list.php" target="conteudo" title="Ordem Externa">Ordem Externa</a></li>
           	 <li> <a href="movimentacao/receb_list.php" target="conteudo" title="Equipamento">Receber equipamento</a> </li>
          </ul>
      </li>
      <?php if($_SESSION['kt_login_level'] == '1'){ ?>
      <li class="menu-main-item"> <a href="#" title="Lançamento">Lançamento</a>
            <ul class="menu-sub-item">
              <li> <a href="movimentacao/class_list.php" target="conteudo" title="cassificacao">Classificação</a></li>
              <li><a href="movimentacao/manutencao.php" target="conteudo">Manuten&ccedil;&atilde;o</a></li>		
			</ul>
    </li>
        <?php }; ?>
      <li class="menu-main-item"><a href="#" title="Lançamento">Listagem</a>
            <ul class="menu-sub-item">
              <li> <a href="movimentacao/listagem.php" title="Listagem de ordens externas" target="conteudo">Ordem Externa</a> </li>
			</ul>
        </li>
        <li class="menu-main-item"><a href="#">Relatorios</a>
           <ul class="menu-sub-item">
              <li><a href="report/form/geral_form.php" target="conteudo">Relatorio Geral</a></li>
              <li><a href="report/form/res_setor.php" target="conteudo">Por Setor</a></li>
              <li><a href="report/form/geral_equip.php" target="conteudo">Relatorio p/ Equipamento</a></li>
           </ul>
         </li>
         <li class="menu-main-item"><a href="#" onclick="modal('../suporte/suporte.php','700', '500')">Suporte</a></li>
        <li class="menu-main-item"><a href="../index2.php">Sair</a></li>
</ul>
</div>
