<?php
require_once(dirname(__FILE__) . '/../boot.php');
require_once(SG_BACKUP_PATH.'SGBackup.php');

$backup = new SGBackup();
$success = array('success' => 1);
$error = array('error' => 1);

if (isAjax() && count($_POST)) {
	@session_write_close();
	$res = $backup->downloadBackupArchiveFromCloud($_POST['path'], $_POST['storage'], $_POST['size']);
	if (!$res) {
		die(json_encode($error));
	}
	die(json_encode($success));
}
