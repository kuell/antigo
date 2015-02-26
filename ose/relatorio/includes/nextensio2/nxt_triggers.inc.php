<?php
define(KT_WRONG_CREDENTIALS,-1);
define(KT_WRONG_CREDENTIALS_MSG,'You don\'t have the credentials to perform this operation!');

/*
	NAME:
	KT_TriggerBEFORE_checkCredentials
	DESCRIPTION:
		Checks user credentials - and forbids the execution of the transaction, if these credentials are not good
	PARAMETERS:
		&$tNG - reference to caller tNG Object
		$sitename - site name (in which is valid the authentication)
		$reqLevels - levels array - on ly if the user that is logged in has its level in this array can the transaction execute
	RETURN:
	 - none
*/
function KT_TriggerBEFORE_checkCredentials(&$tNG, $sitename, $reqLevels=array()) {
	//define global variables
	global $_SESSION, $_COOKIE, $_SERVER;
	$KT_authFailedURL=$failedUrl;
	$KT_grantAccess=false;
	//construct the session variables names
	$USER_VAR = LOGIN_USER_VAR . $sitename;
	$PASSWORD_VAR = LOGIN_PASSWORD_VAR . $sitename;
	$ID_VAR = LOGIN_ID_VAR . $sitename;
	$LEVEL_VAR = LOGIN_LEVEL_VAR . $sitename;
	if (sizeof($reqLevels) == 0) {
		return true;
	} else {
		if (!in_array($_SESSION[$LEVEL_VAR], $reqLevels)) {
			$tNG->setError(KT_WRONG_CREDENTIALS, KT_WRONG_CREDENTIALS_MSG);
			return true;
		}
	}
}
?>