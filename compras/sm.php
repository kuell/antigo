<?php
    require_once '../includes/smarty/libs/Smarty.class.php';
    $sm = new Smarty();
    
    $sm->template_dir = "view/";    
    $sm->compile_dir = "templates_c";
    $sm->debug_tpl = true;
    $sm->assign("charset","UTF-8");
?>
