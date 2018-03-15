<?php

//Paths
define('SG_PUBLIC_PATH', realpath(dirname(__FILE__).'/../').'/');
define('SG_PUBLIC_CONFIG_PATH', SG_PUBLIC_PATH.'config/');
define('SG_PUBLIC_INCLUDE_PATH', SG_PUBLIC_PATH.'include/');
define('SG_PUBLIC_AJAX_PATH', SG_PUBLIC_PATH.'ajax/');

//Defines
define('SG_BACKUP_TYPE_FULL', 1);
define('SG_BACKUP_TYPE_CUSTOM', 2);

//Review popup states
define('SG_SHOW_REVIEW_POPUP', 1);
define('SG_NEVER_SHOW_REVIEW_POPUP', 2);

//Backup Guard Site URL
define('SG_BACKUP_SITE_URL','http://backup-guard.com');
