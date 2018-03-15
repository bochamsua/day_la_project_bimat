<?php
require_once(SG_BACKUP_PATH.'SGBackup.php');
@include_once(SG_STORAGE_PATH.'SGGoogleDriveStorage.php');
@include_once(SG_STORAGE_PATH.'SGDropboxStorage.php');
@include_once(SG_STORAGE_PATH.'SGFTPStorage.php');
@include_once(SG_STORAGE_PATH.'SGAmazonStorage.php');

class SGBackupStorage implements SGIStorageDelegate
{
    private static $instance = null;
    private $actionId = null;
    private $currentUploadChunksCount = 0;
    private $totalUploadChunksCount = 0;
    private $progressUpdateInterval = 0;
    private $nextProgressUpdate = 0;
    private $backgroundMode = false;

    private function __construct()
    {
        $this->backgroundMode = SGConfig::get('SG_BACKUP_IN_BACKGROUND_MODE');
    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function listStorage($storageId)
    {
        $storage = $this->storageObjectById($storageId, $storageName);
        $listOfFiles = $storage->getListOfFiles();

        return $listOfFiles;
    }

    public function downloadBackupArchiveFromCloud($storageId, $archive, $size)
    {
        $storage = $this->storageObjectById($storageId, $storageName);
        $result = $storage->downloadFile($archive, $size);

        return $result?true:false;
    }

    public static function queueBackupForUpload($backupName, $storageId, $options)
    {
        return SGBackup::createAction($backupName, SG_ACTION_TYPE_UPLOAD, SG_ACTION_STATUS_CREATED, $storageId, json_encode($options));
    }

    public function startUploadByActionId($actionId)
    {
        $sgdb = SGDatabase::getInstance();

        $res = $sgdb->query('SELECT * FROM '.SG_ACTION_TABLE_NAME.' WHERE id=%d LIMIT 1', array($actionId));

        if (!count($res))
        {
            return false;
        }

        $row = $res[0];

        if ($row['type']!=SG_ACTION_TYPE_UPLOAD)
        {
            return false;
        }

        $this->actionId = $actionId;
        $storage = $this->storageObjectById($row['subtype'], $storageName);
        $this->startBackupUpload($row['name'], $storage, $storageName);

        return true;
    }

    public function startDownloadByActionId($actionId)
    {
        $sgdb = SGDatabase::getInstance();

        $res = $sgdb->query('SELECT * FROM '.SG_ACTION_TABLE_NAME.' WHERE id=%d LIMIT 1', array($actionId));

        if (!count($res))
        {
            return false;
        }

        $row = $res[0];

        if ($row['type']!=SG_ACTION_TYPE_UPLOAD)
        {
            return false;
        }

        $this->actionId = $actionId;
        $storage = $this->storageObjectById($row['subtype'], $storageName);

        return true;
    }

    private function storageObjectById($storageId, &$storageName = '')
    {
        $storageId = (int)$storageId;
        switch ($storageId)
        {
            case SG_STORAGE_FTP:
                if (SGBoot::isFeatureAvailable('FTP'))
                {
                    $storageName = 'FTP';
                    return new SGFTPStorage();
                }
            case SG_STORAGE_DROPBOX:
                if (SGBoot::isFeatureAvailable('DROPBOX'))
                {
                    $storageName = 'Dropbox';
                    return new SGDropboxStorage();
                }
            case SG_STORAGE_GOOGLE_DRIVE:
                if (SGBoot::isFeatureAvailable('GOOGLE_DRIVE'))
                {
                    $storageName = 'Google Drive';
                    return new SGGoogleDriveStorage();
                }
            case SG_STORAGE_AMAZON:
                if (SGBoot::isFeatureAvailable('AMAZON'))
                {
                    $storageName = 'Amazon S3';
                    return new SGAmazonStorage();
                }
        }

        throw new SGExceptionNotFound('Unknown storage');
    }

    public function shouldUploadNextChunk()
    {
        if (SGBoot::isFeatureAvailable('BACKGROUND_MODE') && $this->backgroundMode)
        {
            SGBackgroundMode::next();
        }

        $this->currentUploadChunksCount++;
        if ($this->updateProgress())
        {
            $this->checkCancellation();
        }
        return true;
    }

    public function willStartUpload($chunksCount)
    {
        $this->totalUploadChunksCount = $chunksCount;
        $this->resetProgress();
    }

    public function updateProgressManually($progress)
    {
        if (SGBoot::isFeatureAvailable('BACKGROUND_MODE') && $this->backgroundMode)
        {
            SGBackgroundMode::next();
        }

        if ($this->updateProgress($progress))
        {
            $this->checkCancellation();
        }
    }

    private function updateProgress($progress = null)
    {
        if (!$progress)
        {
            $progress = $this->currentUploadChunksCount*100.0/$this->totalUploadChunksCount;
        }

        if ($progress>=$this->nextProgressUpdate)
        {
            $this->nextProgressUpdate += $this->progressUpdateInterval;

            $progress = max($progress, 0);
            $progress = min($progress, 100);
            SGBackup::changeActionProgress($this->actionId, $progress);

            return true;
        }

        return false;
    }

    private function resetProgress()
    {
        $this->currentUploadChunksCount = 0;
        $this->progressUpdateInterval = SGConfig::get('SG_ACTION_PROGRESS_UPDATE_INTERVAL');
        $this->nextProgressUpdate = $this->progressUpdateInterval;
    }

    private function checkCancellation()
    {
        $status = SGBackup::getActionStatus($this->actionId);
        if ($status==SG_ACTION_STATUS_CANCELLING)
        {
            SGBackupLog::write('Upload cancelled');
            throw new SGExceptionSkip();
        }
        elseif ($status==SG_ACTION_STATUS_ERROR) {
            SGBackupLog::write('Upload timeout error');
            throw new SGExceptionExecutionTimeError();
        }
    }

    private function startBackupUpload($backupName, SGStorage $storage, $storageName)
    {
        $actionStartTs = time();
        SGPing::update();

        $backupPath = SG_BACKUP_DIRECTORY.$backupName;
        $filesBackupPath = $backupPath.'/'.$backupName.'.sgbp';

        if (!is_readable($filesBackupPath))
        {
            SGBackup::changeActionStatus($this->actionId, SG_ACTION_STATUS_ERROR);
            throw new SGExceptionNotFound('Backup not found');
        }

        try
        {
            @session_write_close();

            SGBackup::changeActionStatus($this->actionId, SG_ACTION_STATUS_IN_PROGRESS_FILES);

            SGBackupLog::write('-');
            SGBackupLog::writeAction('upload to '.$storageName, SG_BACKUP_LOG_POS_START);
            SGBackupLog::write('Authenticating');

            $storage->setDelegate($this);
            $storage->connectOffline();

            SGBackupLog::write('Preparing folder');

            $folderTree = SG_BACKUP_DEFAULT_FOLDER_NAME;

            if (SGBoot::isFeatureAvailable('SUBDIRECTORIES')){
                $folderTree = SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME');
            }

            //create backups container folder, if needed
            $backupsFolder = $storage->createFolder($folderTree);
            $storage->setActiveDirectory($backupsFolder);

            SGBackupLog::write('Uploading file');

            $storage->uploadFile($filesBackupPath);

            SGBackupLog::writeAction('upload to '.$storageName, SG_BACKUP_LOG_POS_END);
            SGBackupLog::write('Total duration: '.formattedDuration($actionStartTs, time()));

            SGBackup::changeActionStatus($this->actionId, SG_ACTION_STATUS_FINISHED);
        }
        catch (Exception $exception)
        {
            if ($exception instanceof SGExceptionSkip)
            {
                SGBackup::changeActionStatus($this->actionId, SG_ACTION_STATUS_CANCELLED);
            }
            else
            {
                SGBackup::changeActionStatus($this->actionId, SG_ACTION_STATUS_ERROR);

                if(!$exception instanceof SGExceptionExecutionTimeError) {//to prevent log duplication for timeout exception
                    SGBackupLog::writeExceptionObject($exception);
                }
            }

            //delete file inside storage
            $storage->deleteFile(basename($filesBackupPath));
        }
    }
}
