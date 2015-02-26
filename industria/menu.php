<?php 
		session_start(); 
?>
<div id="menu-container">
	<ul>
         <li class="menu-main-item">
         <a href="#">Cadastro</a>
         <ul class="menu-sub-item">
               <li> <a href="cadastro/produto_list.php" target="pagina">Produtos Produção</a></li>
               <li><a href="cadastro/fat_prod_l.php" target='pagina'>Produtos faturamento</a></li>
           </ul>
	  </li>
        <li class="menu-main-item"><a href="#">Movimento</a>
            <ul class="menu-sub-item">
             <li> <a href="movimento/producao_busca.php" target="pagina">Digitação de Produção</a></li>
             <li> <a href="movimento/fat_busca.php" target="pagina">Digitação do Faturamento</a></li>
          </ul>
      </li>
        <li class="menu-main-item"><a href="#">Relatorios</a>
          <ul class="menu-sub-item">
             <li><a href="relatorio/forms/formGerProd.php" target="pagina">Gerencial da produção</a></li>
             <li><a href="relatorio/forms/formGerFat.php" target="pagina">Gerencial do Faturamento</a></li>
           </ul>
      </li>
         <li class="menu-main-item"><a href="#" onclick="modal('../suporte/suporte.php','700', '500')">Suporte</a></li>
        <li class="menu-main-item"><a href="../index2.php">Sair</a></li>
</ul>
</div>