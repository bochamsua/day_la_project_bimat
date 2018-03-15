<?php
require_once(SG_STORAGE_PATH.'SGStorage.php');

use \Dropbox as dbx;

class SGDropboxStorage extends SGStorage
{
	private $client = null;

	public function init()
	{
		//check if curl extension is loaded
		SGBoot::checkRequirement('curl');

		$this->setActiveDirectory('/');
		@set_exception_handler(array('SGDropboxStorage', 'exceptionHandler'));
		require_once(SG_STORAGE_PATH.'SGDropbox.php');
	}

	public static function exceptionHandler($exception)
	{
		if(SG_ENV_ADAPTER == SG_ENV_WORDPRESS) {
			wp_die($exception->getMessage());
		}
		elseif (SG_ENV_ADAPTER == SG_ENV_MAGENTO) {
			die($exception->getMessage());
		}
	}

	public function connect()
	{
		if ($this->isConnected())
		{
			return;
		}

		$authCode = $this->getAuthCodeFromURL($cancel);

		if ($cancel)
		{
			throw new SGExceptionMethodNotAllowed('User did not allow access');
		}

		$this->auth($authCode);
	}

	private function auth($authCode = '')
	{
		if ($authCode)
		{
			try
			{
				//exchange authorization code for access token
				parse_str($_SERVER['QUERY_STRING'], $arr);
				list($accessToken, $userId, $urlState) = $this->getWebAuth()->finish($arr);

				$this->setAccessToken($accessToken);

				$accountInfo = $this->getClient()->getAccountInfo();
				SGConfig::set('SG_DROPBOX_CONNECTION_STRING', $accountInfo['email']);

				$this->connected = true;
				return;
			}
			catch (Exception $ex)
			{

			}
		}

		$refUrl = base64_encode($this->getRefURL());
		$authorizeUrl = $this->getWebAuth()->start($refUrl);
		header("Location: $authorizeUrl");
		exit;
	}

	public function connectOffline()
	{
		if ($this->isConnected())
		{
			return;
		}

		if (!$this->getClient())
		{
			throw new SGExceptionNotFound('Access token not found');
		}

		$this->connected = true;
	}

	public function checkConnected()
	{
		$accessToken = $this->getAccessToken();
		$this->connected = $accessToken?true:false;
	}

	public function getListOfFiles()
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		$listOfFiles = array();

		$metaData = $this->getClient()->getMetadataWithChildren($this->getActiveDirectory().SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME'));
		foreach($metaData['contents'] as $file) {
			$size = $file['bytes'];
			$date = $this->standardizeFileCreationDate($file['client_mtime']);
			$name = basename($file['path']);

			$listOfFiles[$name] = array(
				'name' => $name,
				'size' => $size,
				'date' => $date,
				'path' => $file['path'],
			);
		}
		krsort($listOfFiles);
		return $listOfFiles;
	}

	public function createFolder($folderName)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		$path = rtrim($this->getActiveDirectory(), '/').'/'.$folderName;
		$this->getClient()->createFolder($path);

		return $path;
	}

	private $fd = null;
	private $filePath = '';

	public function downloadFile($file, $size)
	{
		@session_write_close();
		$metadata = array();
		if (!$file) {
			return $metadata;
		}
		$this->filePath = SG_BACKUP_DIRECTORY.basename($file);
		$this->fd = fopen(SG_BACKUP_DIRECTORY.basename($file), "wb");

		$client = $this->getClient();
        $url = $client->buildUrlForGetOrPut(
            $client->contentHost,
            $client->appendFilePath("1/files", $file),
            array("rev" => null)
        );

        $curl = $client->mkCurl($url);
        $metadataCatcher = new Dropbox\DropboxMetadataHeaderCatcher($curl->handle);
        $streamRelay = new Dropbox\CurlStreamRelay($curl->handle, $this->fd);

        $curl->set(CURLOPT_WRITEFUNCTION, array($this, 'callback'));

        $response = $curl->exec();
        fclose($this->fd);

        if ($response->statusCode === 404) return true;

        if ($response->statusCode !== 200) {
        	return false;
        }

        $metadata = $metadataCatcher->getMetadata();
		return $metadata?true:false;
	}

	public function callback ($ch, $data)
	{
    	if (!file_exists($this->filePath)) {
    		return -1;
    	}
    	fwrite($this->fd, $data);
    	return strlen($data);
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

		$client = $this->getClient();

		$chunkSizeBytes = 2.0 * 1024 * 1024;

		//Note: Because PHP's integer type is signed and many platforms use 32bit integers,
		//some filesystem functions may return unexpected results for files which are larger than 2GB.
		$fileSize = realFilesize($filePath);

		$this->delegate->willStartUpload((int)ceil($fileSize/$chunkSizeBytes));

		$handle = fopen($filePath, "rb");

		$data = fread($handle, $chunkSizeBytes);
		$uploadId = $client->chunkedUploadStart($data);
		$byteOffset = strlen($data);
		SGPing::update();

		while (!feof($handle))
		{
			$data = fread($handle, $chunkSizeBytes);
			$client->chunkedUploadContinue($uploadId, $byteOffset, $data);
			$byteOffset += strlen($data);

			if (!$this->delegate->shouldUploadNextChunk())
	        {
	        	fclose($handle);
	            return;
	        }
	        SGPing::update();
		}

		$path = rtrim($this->getActiveDirectory(), '/').'/'.basename($filePath);

		$result = $client->chunkedUploadFinish($uploadId, $path, dbx\WriteMode::force());

		fclose($handle);

		return $result;
	}

	public function deleteFile($fileName)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		return $this->getClient()->delete($fileName);
	}

	public function deleteFolder($folderName)
	{
		return $this->deleteFile($folderName);
	}

	private function getAppInfo()
	{
		$key = SG_STORAGE_DROPBOX_KEY;
		$secret = SG_STORAGE_DROPBOX_SECRET;

		$appInfo = new dbx\AppInfo($key, $secret);
		return $appInfo;
	}

	private function getAccessToken()
	{
		return SGConfig::get('SG_DROPBOX_ACCESS_TOKEN');
	}

	private function setAccessToken($accessToken)
	{
		SGConfig::set('SG_DROPBOX_ACCESS_TOKEN', $accessToken, true);
	}

	private function getClient()
	{
		if (!$this->client)
		{
			$accessToken = $this->getAccessToken();
			if (!$accessToken)
			{
				return false;
			}

			$appInfo = $this->getAppInfo();
			return new dbx\Client($accessToken, SG_STORAGE_DROPBOX_CLIENT_ID, null, $appInfo->getHost());
		}

		return $this->client;
	}

	private function getWebAuth()
	{
		$appInfo = $this->getAppInfo();
		$redirectUri = SG_STORAGE_DROPBOX_REDIRECT_URI;
		$csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
		return new dbx\WebAuth($appInfo, SG_STORAGE_DROPBOX_CLIENT_ID, $redirectUri, $csrfTokenStore, null);
	}

	private function getCurrentURL()
	{
		$http = isset($_SERVER['HTTPS'])?'https':'http';
		$url = $http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $url;
	}

	private function getRefURL()
	{
		$refUrl = $this->getCurrentURL();
		if (!$_SERVER['QUERY_STRING'])
		{
			$refUrl .= '?';
		}
		else
		{
			$refUrl .= '&';
		}

		return $refUrl;
	}

	private function getAuthCodeFromURL(&$cancel = false)
	{
		$query = $_SERVER['QUERY_STRING'];
		if (!$query) return '';

		$query = explode('&', $query);
		$code = '';
		foreach ($query as $q)
		{
			$q = explode('=', $q);
			if ($q[0]=='code')
			{
				$code = $q[1];
			}
			else if ($q[0]=='cancel' && $q[1]=='1')
			{
				$cancel = true;
				break;
			}
		}

		return $code;
	}
}
