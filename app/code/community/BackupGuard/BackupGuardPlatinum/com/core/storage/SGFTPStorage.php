<?php
require_once(SG_STORAGE_PATH.'SGStorage.php');

class SGFTPStorage extends SGStorage
{
	private $connectionId = null;

	public function init()
	{
		//check if ftp extension is loaded
		SGBoot::checkRequirement('ftp');

		$this->setActiveDirectory(SGConfig::get('SG_FTP_ROOT_FOLDER'));
	}

	public function connect()
	{
		if ($this->isConnected())
		{
			return;
		}

		$host = SGConfig::get('SG_FTP_HOST');
		$port = SGConfig::get('SG_FTP_PORT');
		$user = SGConfig::get('SG_FTP_USER');
		$password = SGConfig::get('SG_FTP_PASSWORD');

		$connId = @ftp_connect($host, $port);
		if (!$connId)
		{
			throw new SGExceptionForbidden('Could not connect to the FTP server: '.$host);
		}

		$login = @ftp_login($connId, $user, $password);
		if (!$login)
		{
			throw new SGExceptionForbidden('Could not connect to the FTP server: '.$host);
		}

		SGConfig::set('SG_FTP_CONNECTION_STRING', $user.'@'.$host.':'.$port);

		$this->connectionId = $connId;
		$this->connected = true;
	}

	public function connectOffline()
	{
		$this->connect();
	}

	public function checkConnected()
	{
		$this->connected = false;
	}

	public function getListOfFiles()
	{
		$this->connect();
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		$listOfFiles = array();
		$files = ftp_nlist($this->connectionId, $this->getActiveDirectory().'/'.SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME'));

		foreach ($files as $file) {
			if ($file == '.' || $file == '..') {
				continue;
			}

			$path = $this->getActiveDirectory().'/'.SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME').'/'.$file;
			$size = ftp_size($this->connectionId, $path);
			$createDate = ftp_mdtm($this->connectionId, $path);

			$listOfFiles[$file] = array(
				'name' => $file,
				'size' => $size,
				'date' => date('Y-m-d H:i:s', $createDate),
				'path' => $path,
			);
		}
		krsort($listOfFiles);
		return $listOfFiles;
	}

	public function setActiveDirectory($directory)
	{
		parent::setActiveDirectory($directory);
		if ($this->isConnected())
		{
			if (!@ftp_chdir($this->connectionId, $directory))
			{
				throw new SGExceptionForbidden('Could not change directory');
			}
		}
	}

	public function createFolder($folderName)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		$path = rtrim($this->getActiveDirectory(), '/').'/'.$folderName;
		@ftp_mkdir($this->connectionId, $path);

		return $path;
	}

	public function downloadFile($file, $size)
	{
		$this->connect();
		@session_write_close();
		$loaclFilePath = SG_BACKUP_DIRECTORY.basename($file);
		$serverFilePath = $this->getActiveDirectory().$file;

		$result = ftp_nb_get($this->connectionId, $loaclFilePath, $serverFilePath, FTP_BINARY);

		while ($result == FTP_MOREDATA) {
			if (!file_exists($loaclFilePath)) {
				break;
			}
			$result = ftp_nb_continue($this->connectionId);
		}

		return $result == FTP_FINISHED?true:false;
	}

	public function uploadFile($filePath)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		if (!file_exists($filePath) || !is_readable($filePath))
		{
			throw new SGExceptionNotFound('File does not exist or is not readable: '.$filePath);
		}

		$path = rtrim($this->getActiveDirectory(), '/').'/'.basename($filePath);

		$fileSize = realFilesize($filePath);

		$this->delegate->willStartUpload(1);

		$fp = @fopen($filePath, 'rb');

		ftp_set_option($this->connectionId, FTP_AUTOSEEK, TRUE);

		$ret = ftp_nb_fput($this->connectionId, $path, $fp, FTP_BINARY, FTP_AUTORESUME);
		SGPing::update();

		while ($ret == FTP_MOREDATA)
		{
		    $ret = ftp_nb_continue($this->connectionId);

			$progress = ftell($fp)*100.0/$fileSize;
			$this->delegate->updateProgressManually($progress);
			SGPing::update();
		}

		@fclose($fp);

		if ($ret != FTP_FINISHED)
		{
			throw new SGExceptionServerError('The file was not uploaded correctly.');
		}
	}

	public function deleteFile($fileName)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		return @ftp_delete($this->connectionId, $fileName);
	}

	public function deleteFolder($folderName)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		return $this->deleteFolderWithFiles($folderName);
	}

	private function deleteFolderWithFiles($directory)
	{
	    if (empty($directory))
	    {
	    	return false;
	    }

	    if (!(@ftp_rmdir($this->connectionId, $directory) || @ftp_delete($this->connectionId, $directory)))
        {
            //if the attempt to delete fails, get the file listing
            $fileList = @ftp_nlist($this->connectionId, $directory);

            //loop through the file list and recursively delete the file in the list
            foreach ($fileList as $file)
            {
            	if ($file=='.' || $file=='..')
            	{
            		continue;
            	}

                $this->deleteFolderWithFiles($directory.'/'.$file);
            }

            //if the file list is empty, delete the directory we passed
            $this->deleteFolderWithFiles($directory);
        }

	    return true;
	}
}
