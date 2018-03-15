<?php
$m = new Mage();
$version = $m->getVersion();

define('SG_ENV_WORDPRESS', 'Wordpress');
define('SG_ENV_MAGENTO', 'Magento');
define('SG_ENV_VERSION', $version);
define('SG_ENV_ADAPTER', SG_ENV_MAGENTO);
define('SG_ENV_DB_PREFIX', (string)Mage::getConfig()->getTablePrefix());

require_once(dirname(__FILE__).'/config.php');

define('SG_ENV_CORE_TABLE', SG_MAGENTO_CORE_TABLE);

//Database
define('SG_DB_ADAPTER', SG_ENV_ADAPTER);
define('SG_DB_NAME', (string)Mage::getConfig()->getNode('global/resources/default_setup/connection/dbname'));

$dbExcludes = array(
	SG_ACTION_TABLE_NAME,
	SG_CONFIG_TABLE_NAME,
	SG_SCHEDULE_TABLE_NAME,
	SG_ENV_DB_PREFIX."log_summary",
	SG_ENV_DB_PREFIX."log_visitor_online",
	SG_ENV_DB_PREFIX."log_summary_type",
	SG_ENV_DB_PREFIX."log_customer",
	SG_ENV_DB_PREFIX."log_visitor",
	SG_ENV_DB_PREFIX."log_visitor_info",
	SG_ENV_DB_PREFIX."log_url",
	SG_ENV_DB_PREFIX."log_url_info",
	SG_ENV_DB_PREFIX."log_quote",
	SG_ENV_DB_PREFIX."report_viewed_product_index",
	SG_ENV_DB_PREFIX."report_compared_product_index",
	SG_ENV_DB_PREFIX."report_event",
	SG_ENV_DB_PREFIX."catalog_compare_item"
);
define('SG_BACKUP_DATABASE_EXCLUDE', implode(',', $dbExcludes));

//Mail
define('SG_MAIL_BACKUP_TEMPLATE', 'backupguard_backup');
define('SG_MAIL_RESTORE_TEMPLATE', 'backupguard_restore');

//Backup
define('SG_APP_ROOT_DIRECTORY', Mage::getBaseDir().'/');

$excludes = array(
	'app/code/community/BackupGuard/',
	'app/etc/modules/BackupGuard_BackupGuardFree.xml',
	'app/etc/modules/BackupGuard_BackupGuard.xml',
    'app/etc/local.xml',
	'app/design/adminhtml/default/default/layout/backupguardfree.xml',
	'app/design/adminhtml/default/default/layout/backupguard.xml',
	'app/design/adminhtml/default/default/template/backupguardfree/',
	'app/design/adminhtml/default/default/template/backupguard/',
	'app/locale/en_US/template/email/backupguard_backup_fail.html',
	'app/locale/en_US/template/email/backupguard_backup_success.html',
	'app/locale/en_US/template/email/backupguard_restore_fail.html',
	'app/locale/en_US/template/email/backupguard_restore_success.html',
	'media/sg_symlinks/',
	'skin/adminhtml/base/default/css/BackupGuardFree/',
	'skin/adminhtml/base/default/css/BackupGuard/',
	'skin/adminhtml/base/default/js/BackupGuardFree/',
	'skin/adminhtml/base/default/js/BackupGuard/',
	'skin/adminhtml/base/default/media/BackupGuardFree/',
	'skin/adminhtml/base/default/media/BackupGuard/',
	'var/'
);
define('SG_BACKUP_FILE_PATHS_EXCLUDE', implode(',', $excludes));
define('SG_BACKUP_DIRECTORY', SG_APP_PATH.'../sg_backups/'); //backups will be stored here

define('SG_PING_FILE_PATH', SG_BACKUP_DIRECTORY.'ping.json');

define('SG_SYMLINK_URL', Mage::getBaseUrl('media').'sg_symlinks/');
define('SG_SYMLINK_PATH', Mage::getBaseDir('media').'/sg_symlinks/');

//Storage
define('SG_STORAGE_UPLOAD_CRON', '');

define('SG_BACKUP_FILE_PATHS', 'app,js,lib,media,skin'); //fix this after development