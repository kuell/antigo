<?php
	session_start();
?>
<div id="menu-container">
	<ul>
         <li class="menu-main-item"><a href="#">Cadastro</a>
         <ul class="menu-sub-item">
               <li> <a href="../paginas/setor/setor_list.php" target="conteudo" title="setor">Setor</a> </li>
              <li> <a href="../paginas/equipamento/equip_list.php" target="conteudo" >Equipamento</a></li>
              <li> <a href="../paginas/servico/servico_list.php" target="conteudo" title="ação">Serviço</a> </li>
              <li> <a href="../paginas/Requisitante/resquisit_list.php" target="conteudo" title="ação">Requisitante/Responsavel</a> </li>
           </ul>
  		</li>
        <li class="menu-main-item"><a href="#">Movimento</a>
            <ul class="menu-sub-item">
             <li> <a href="movimentacao/mov_list.php" target="conteudo" title="Ordem Externa">Ordem Interna</a> </li>
          </ul>
      </li>
      <?php if($_SESSION['kt_login_level'] !== '2') { ?>
         <li class="menu-main-item"><a href="#" title="Baixa">Baixar</a>
          <ul class="menu-sub-item">
            <li> <a href="movimentacao/conclui/mov_list_conc.php" title="Listagem de ordens externas" target="conteudo">Ordem Interna </a></li>
		  </ul>
      </li>
      <li class="menu-main-item"><a href="#">Relatorios</a>
          <ul class="menu-sub-item">
              <li><a href="relatorio/forms/geral_status.php" target="conteudo">Por Status</a></li>
              <li><a href="#">Por Setor</a></li>
              <li><a href="#">Por Solicitante</a></li>
           </ul>
         </li>
      <?php }; ?>  
    <li class="menu-main-item"><a href="#" onclick="modal('../suporte/suporte.php','700', '500')">Suporte</a></li>
        <li class="menu-main-item"><a href="../index2.php" onclick="sair()">Sair</a></li>
</ul>
</div>
