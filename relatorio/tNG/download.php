<?php
session_start();
$uniqueId = $_GET['dname'] . '_' . $_GET['id'];
$sourceName = 'source_' . $uniqueId;
$destName = 'dest_' . $uniqueId;
if 	((!isset($_SESSION[$destName])) || 
		(!isset($_SESSION[$sourceName]))) {
	die('Error downloading file!');
}
if (!@fopen($_SESSION[$sourceName], "rb")) {
	die('Error downloading file!');
}
define('MAX_READ',131072);
$mime_type = (function_exists('mime_content_type'))? mime_content_type($_SESSION[$sourceName]): 'application/octet-stream';
header('Content-type: '.$mime_type);
header('Cache-control: private');
header('Content-Length: ' . filesize($_SESSION[$sourceName]));
header('Content-disposition: attachment; filename="' . $_SESSION[$destName] . '";');
//header('Content-disposition: filename="' . $_SESSION[$destName] . '";');
if (!readfile($_SESSION[$sourceName])) {
	header('Status-code: 404');
	die ('Error reading file!');
}
?>