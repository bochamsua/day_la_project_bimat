<?php
    require_once(dirname(__FILE__).'/../boot.php');
    require_once(SG_BACKUP_PATH.'SGBackupSchedule.php');

    $error = array();
    $success = array('success'=>1);

    if(isAjax() && count($_POST)) {
        if (isset($_POST['remove'])) {
            if(isset($_POST['id'])) {
                SGBackupSchedule::remove($_POST['id']);
            }
            else {
                SGBackupSchedule::remove();
            }

            die(json_encode($success));
        }

        if(isset($_POST['checkCron'])) {
            //Check if cron available
            if(!SGSchedule::isCronAvailable()) {
                array_push($error, _t('Cron is not available on your hosting.',true));
                die(json_encode($error));
            }
            die(json_encode($success));
        }

        $options = $_POST;
        $cronOptions = array(
            'SG_BACKUP_IN_BACKGROUND_MODE' => 0,
            'SG_BACKUP_UPLOAD_TO_STORAGES' => '',
            'SG_ACTION_BACKUP_DATABASE_AVAILABLE' => 0,
            'SG_ACTION_BACKUP_FILES_AVAILABLE' => '',
            'SG_BACKUP_FILE_PATHS_EXCLUDE' => '',
            'SG_BACKUP_FILE_PATHS' => '',
        );

        //Check if cron available
        if(!SGSchedule::isCronAvailable()) {
            array_push($error, _t('Cron is not available on your hosting.',true));
            die(json_encode($error));
        }

        $scheduleIntervalDay = '';

        if ($options['scheduleInterval'] == '* * 0') {
            $scheduleIntervalDay = ' '.$options['sg-schedule-day-of-week'];
        }
        elseif($options['scheduleInterval'] == '1 * *') {
            $scheduleIntervalDay = ' '.$options['sg-schedule-day-of-month'];
        }

        $cronTab = '* '.$options['scheduleHour'].' '.$options['scheduleInterval'].$scheduleIntervalDay;

        $cronLabel = '';
        //Check if schedule name is not empaty
        if (isset($options['sg-schedule-label'])) {
            $label = trim($options['sg-schedule-label']);
            if (empty($label)) {
                array_push($error, _t('Label field is required.',true));
                die(json_encode($error));
            }
            else {
                $cronLabel = $label;
            }
        }

        //If background mode
        $isBackgroundMode = isset($options['backgroundMode'])?1:0;
        $cronOptions['SG_BACKUP_IN_BACKGROUND_MODE'] = $isBackgroundMode;

        //If cloud backup
        if(isset($options['backupCloud']) && count($options['backupStorages'])) {
            $clouds = $options['backupStorages'];
            $cronOptions['SG_BACKUP_UPLOAD_TO_STORAGES'] = implode(',', $clouds);
        }

        $cronOptions['SG_BACKUP_TYPE'] = $options['backupType'];

        if ($options['backupType'] == SG_BACKUP_TYPE_FULL) {
            $cronOptions['SG_ACTION_BACKUP_DATABASE_AVAILABLE'] = 1;
            $cronOptions['SG_ACTION_BACKUP_FILES_AVAILABLE'] = 1;
            $cronOptions['SG_BACKUP_FILE_PATHS_EXCLUDE'] = SG_BACKUP_FILE_PATHS_EXCLUDE;

            if (SG_ENV_ADAPTER != SG_ENV_MAGENTO) {
                $cronOptions['SG_BACKUP_FILE_PATHS'] = 'wp-content';
            }
            else {
                $cronOptions['SG_BACKUP_FILE_PATHS'] = SG_BACKUP_FILE_PATHS;
            }
        }
        else if ($options['backupType'] == SG_BACKUP_TYPE_CUSTOM) {
            //If database backup
            $isDatabaseBackup = isset($options['backupDatabase'])?1:0;
            $cronOptions['SG_ACTION_BACKUP_DATABASE_AVAILABLE'] = $isDatabaseBackup;

            //If files backup
            if(isset($options['backupFiles']) && count($options['directory'])) {
                $backupFiles = explode(',', SG_BACKUP_FILE_PATHS);
                $filesToExclude = @array_diff($backupFiles, $options['directory']);

                if (SG_ENV_ADAPTER != SG_ENV_MAGENTO) {
                    if (in_array('wp-content', $options['directory'])) {
                        $options['directory'] = array('wp-content');
                    }
                    else {
                        $filesToExclude = array_diff($filesToExclude, array('wp-content'));
                    }
                }

                $filesToExclude = implode(',', $filesToExclude);
                if (strlen($filesToExclude)) {
                    $filesToExclude = ','.$filesToExclude;
                }

                $cronOptions['SG_BACKUP_FILE_PATHS_EXCLUDE'] = SG_BACKUP_FILE_PATHS_EXCLUDE.$filesToExclude;
                $cronOptions['SG_ACTION_BACKUP_FILES_AVAILABLE'] = 1;
                $cronOptions['SG_BACKUP_FILE_PATHS'] = implode(',', $options['directory']);
            }
            else {
                $cronOptions['SG_ACTION_BACKUP_FILES_AVAILABLE'] = 0;
                $cronOptions['SG_BACKUP_FILE_PATHS'] = '';
            }
        }
        else {
            array_push($error, _t('Invalid backup type'));
            die(json_encode($error));
        }

        try {
            $cronTab = array(
                'cronTab' => $cronTab,
                'dayOfInterval' => $scheduleIntervalDay,
                'intervalHour' => $options['scheduleHour'],
                'interval' => $options['scheduleInterval']
            );

            if (isset($options['sg-schedule-id'])) {
                SGBackupSchedule::remove($options['sg-schedule-id']);
            }

            SGBackupSchedule::create($cronTab, $cronOptions, $cronLabel);

            die(json_encode($success));
        }
        catch(SGException $exception) {
            array_push($error, $exception->getMessage());
            die(json_encode($error));
        }
    }
