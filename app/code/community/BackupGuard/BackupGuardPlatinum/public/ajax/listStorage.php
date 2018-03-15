<?php
require_once(dirname(__FILE__) . '/../boot.php');
require_once(SG_BACKUP_PATH.'SGBackup.php');

$backup = new SGBackup();
$success = array('success' => 1);

if (isAjax() && count($_POST)) {
	$error = array();
	$listOfFiles = $backup->listStorage($_POST['storage']);
	die(json_encode($listOfFiles));
}
