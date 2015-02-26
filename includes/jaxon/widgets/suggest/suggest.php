<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_Suggest_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_Suggest_uploadFileList = array(
		'../../services/service.php',
		'../../utils/json.php',
		'../../../common/KT_common.php',
		'../../../common/lib/db/KT_Db.php',
        'suggest.class.php');

	for ($KT_Suggest_i=0;$KT_Suggest_i<sizeof($KT_Suggest_uploadFileList);$KT_Suggest_i++) {
		$KT_Suggest_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_Suggest_uploadFileList[$KT_Suggest_i];
		if (file_exists($KT_Suggest_uploadFileName)) {
			require_once($KT_Suggest_uploadFileName);
		} else {
			die(sprintf($KT_Suggest_uploadErrorMsg,$KT_Suggest_uploadFileList[$KT_Suggest_i]));
		}
	}
    
?>