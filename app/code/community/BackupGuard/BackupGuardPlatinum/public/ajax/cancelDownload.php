<?php
if(isAjax() && isset($_POST['name']))
{
	@unlink(SG_BACKUP_DIRECTORY.$_POST['name']);
    die('{"success":1}');
}
