<?php
function prepareDownload($dName, $folder, $sufix, $idValue, $fileName, $relpath) {
	global $_SESSION;
	$uniqueId = $dName . '_' . $idValue;
	$sourceName = 'source_' . $uniqueId;
	$destName = 'dest_' . $uniqueId;
	
	KT_session_register($sourceName,'../' . $folder . $idValue . '__' . $sufix);
	KT_session_register($destName,$fileName);
	echo $relpath . 'tNG/download.php?id=' . $idValue . '&dname=' . $dName;
}
?>