<?php
//Version
define('SG_VERSION', '1.1.1');

//Paths
define('SG_APP_PATH', realpath(dirname(__FILE__).'/../').'/');
define('SG_CONFIG_PATH', SG_APP_PATH.'config/');
define('SG_CORE_PATH', SG_APP_PATH.'core/');
define('SG_DATABASE_PATH', SG_CORE_PATH.'database/');
define('SG_LOG_PATH', SG_CORE_PATH.'log/');
define('SG_STORAGE_PATH', SG_CORE_PATH.'storage/');
define('SG_EXCEPTION_PATH', SG_CORE_PATH.'exception/');
define('SG_BACKUP_PATH', SG_CORE_PATH.'backup/');
define('SG_LIB_PATH', SG_APP_PATH.'lib/');
define('SG_MAIL_PATH', SG_CORE_PATH.'mail/');
define('SG_SCHEDULE_PATH', SG_CORE_PATH.'schedule/');

//Log
define('SG_LOG_LEVEL_ALL', 0);
define('SG_LOG_LEVEL_HIGH', 1);
define('SG_LOG_LEVEL_MEDIUM', 2);
define('SG_LOG_LEVEL_LOW', 4);
define('SG_BACKUP_LOG_POS_START', 1);
define('SG_BACKUP_LOG_POS_END', 2);

define('SG_DB_PREFIX_REPLACEMENT', '%%sg_db_prefix%%');

define('SG_SHCEDULE_STATUS_INACTIVE', 0);
define('SG_SHCEDULE_STATUS_PENDING', 1);

//Number of backups to keep on server by default
define('SG_NUMBER_OF_BACKUPS_TO_KEEP', 100);

//Backup timeout in seconds
define('SG_BACKUP_TIMEOUT', 180);

//Ping data update frequency
define('SG_PING_DATE_UPDATE_FREQUENCY', 3);

//Backup file extension
define('SGBP_EXT', 'sgbp');

define('SG_NOTICE_EXECUTION_TIMEOUT', 'timeoutError');

define('SG_WORDPRESS_CORE_TABLE', SG_ENV_DB_PREFIX.'options');
define('SG_MAGENTO_CORE_TABLE', SG_ENV_DB_PREFIX.'core_config_data');

//Backup file default prefix
define('SG_BACKUP_FILE_NAME_DEFAULT_PREFIX', 'sg_backup_');

//Default folder name for storage upload
define('SG_BACKUP_DEFAULT_FOLDER_NAME', 'sg_backups');

//Schedule action name prefix
define('SG_SCHEDULE_ACTION', 'backup_guard_schedule_action');

define('SG_SCHEDULER_DEFAULT_ID', 1);

//one day in seconds
define('SG_ONE_DAY_IN_SECONDS', 24*60*60);

//Backup
define('SG_ACTION_STATUS_CREATED', 0);
define('SG_ACTION_STATUS_IN_PROGRESS_DB', 1);
define('SG_ACTION_STATUS_IN_PROGRESS_FILES', 2);
define('SG_ACTION_STATUS_FINISHED', 3);
define('SG_ACTION_STATUS_FINISHED_WARNINGS', 4);
define('SG_ACTION_STATUS_CANCELLING', 5);
define('SG_ACTION_STATUS_CANCELLED', 6);
define('SG_ACTION_STATUS_ERROR', 7);
define('SG_ACTION_TYPE_BACKUP', 1);
define('SG_ACTION_TYPE_RESTORE', 2);
define('SG_ACTION_TYPE_UPLOAD', 3);
define('SG_ACTION_PROGRESS_UPDATE_INTERVAL', 3); //in %
define('SG_BACKUP_DATABASE_INSERT_LIMIT', 10000);
define('SG_BACKUP_DOWNLOAD_TYPE_SGBP', 1);
define('SG_BACKUP_DOWNLOAD_TYPE_BACKUP_LOG', 2);
define('SG_BACKUP_DOWNLOAD_TYPE_RESTORE_LOG', 3);

//Mail
define('SG_MAIL_BACKUP_SUCCESS_SUBJECT', 'Backup Succeeded');
define('SG_MAIL_BACKUP_FAIL_SUBJECT', 'Backup Failed');
define('SG_MAIL_RESTORE_SUCCESS_SUBJECT', 'Restore Succeeded');
define('SG_MAIL_RESTORE_FAIL_SUBJECT', 'Restore Failed');

//Storage
define('SG_STORAGE_FTP', 1);
define('SG_STORAGE_DROPBOX', 2);
define('SG_STORAGE_GOOGLE_DRIVE', 3);
define('SG_STORAGE_AMAZON', 4);

define('SG_STORAGE_GOOGLE_DRIVE_CLIENT_ID', '1030123017859-vfdlqkjhiuuu5n36pbov93v9ruo6jpj5.apps.googleusercontent.com');
define('SG_STORAGE_GOOGLE_DRIVE_SECRET', 'oUcZwC17q5ZSbYahnQkGYpyH');
define('SG_STORAGE_GOOGLE_DRIVE_REDIRECT_URI', 'https://backup-guard.com/gdrive/');
define('SG_STORAGE_DROPBOX_KEY', 'n3yhajm64h88m9t');
define('SG_STORAGE_DROPBOX_SECRET', 's8crjkls7f9wqtd');
define('SG_STORAGE_DROPBOX_CLIENT_ID', 'backup-guard');
define('SG_STORAGE_DROPBOX_REDIRECT_URI', 'https://backup-guard.com/dropbox/');

//The following constants can be modified at run-time
define('SG_ACTION_BACKUP_FILES_AVAILABLE', 1);
define('SG_ACTION_BACKUP_DATABASE_AVAILABLE', 1);
define('SG_BACKUP_IN_BACKGROUND_MODE', 0);
define('SG_BACKUP_UPLOAD_TO_STORAGES', ''); //list of storage ids separated by commas

//Database tables
define('SG_ACTION_TABLE_NAME', SG_ENV_DB_PREFIX.'sg_action');
define('SG_CONFIG_TABLE_NAME', SG_ENV_DB_PREFIX.'sg_config');
define('SG_SCHEDULE_TABLE_NAME', SG_ENV_DB_PREFIX.'sg_schedule');
