<?php
if (isset($_GET['KT_back'])) {
	//check if the session is allready open
	if (!session_id()) {
	session_start();
	}
	if (!isset($_SESSION['KT_backArr'])) {
		$KT_backArr = array();
		KT_session_register('KT_backArr',$KT_backArr);
	} else {
		$KT_backArr = &$_SESSION['KT_backArr'];
	}
	array_push($KT_backArr, $_GET['KT_back']);
	KT_session_register('KT_backArr',$KT_backArr);
	KT_redir(addReplaceParam($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], "KT_back"));
	exit;
}
?>