<?php
	require_once('../tNG_functions.inc.php');
	session_start();
	if (!isset($_SESSION['KT_backArr'])) {
		if(isset($_SERVER['HTTP_REFERER'])) {
			KT_redir($_SERVER['HTTP_REFERER']);
		} else {
			die('Internal Error');
		}
	} else {
		$KT_backArr = &$_SESSION['KT_backArr'];
		if (sizeof($KT_backArr) < 1) {
			$KT_backArr = array($_SESSION['KT_exBack']);
		}
	}
	$KT_back = array_pop($KT_backArr);
	KT_session_register('KT_backArr',$KT_backArr);
	$KT_exBack = $KT_back;
	KT_session_register('KT_exBack',$KT_exBack);
	if (isset($_GET['mode'])) {
		$KT_back = KT_removeParam($KT_back, 'totalRows_.*?');
		switch ($_GET['mode']) {
			case 'insert':
				break;
			case 'update':
				break;
			case 'delete':
				$KT_back = KT_removeParam($KT_back, 'pageNum_.*?');
				break;
		}
	}
	KT_redir($KT_back);
	exit;
?>
