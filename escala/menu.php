<?php
// Iniciando a session
//session_start();
//session_register("numero");
// Verificando se a variavel est� setada
if (isset($numero)) {
    print($numero);
}
?>
<div id="menu-container">
    <ul>
        <li class="menu-main-item"><a href="#">Digitac&atilde;o</a>
            <ul class="menu-sub-item">
                <li><a href="PreEscala.php" target="conteudo">Pre-Escala</a></li>
                <li><a href="Escala.php" target="conteudo">Escala de abate</a></li>
            </ul>
        </li>
            
        <li class="menu-main-item"><a href="../index2.php">Sair</a></li>
    </ul>
</div>