<?php 
	session_start();
?>
<div id="menu-container">
	<ul>
         <li class="menu-main-item"><a href="#">Cadastro</a>
         <ul class="menu-sub-item">
               <li> <a href="usuario/usuario_list.php" target="conteudo" title="setor">Usuario</a> </li>
              <li> <a href="#" target="conteudo" >Sistema</a></li>
           </ul>
  		</li>
        <li class="menu-main-item"><a href="#" onclick="modal('../suporte/suporte.php','700', '500')">Suporte</a></li>
        <li class="menu-main-item"><a href="../index2.php" onclick="sair()">Sair</a></li>
</ul>
</div>
