<?php
require_once(SG_STORAGE_PATH.'SGStorage.php');
use Aws\S3\S3Client;

class SGAmazonStorage extends SGStorage
{
	private $client = null;
	private $bucket = '';
	private $key = '';
	private $secret = '';
	private $region = '';

	public function init()
	{
		require_once(SG_STORAGE_PATH.'SGAmazon.php');
		//check if ftp extension is loaded
		SGBoot::checkRequirement('curl');
		$this->key = SGConfig::get('SG_AMAZON_KEY');
		$this->secret = SGConfig::get('SG_AMAZON_SECRET_KEY');
		$this->region = SGConfig::get('SG_AMAZON_BUCKET_REGION');
		$this->bucket = SGConfig::get('SG_AMAZON_BUCKET');

		$this->client = S3Client::factory(array(
			'version'     => 'latest',
			'region'      => $this->region,
			'key' => $this->key,
			'secret' => $this->secret
		));
	}

	public function connect()
	{
		return $this->client->doesBucketExist($this->bucket);
	}

	public function connectOffline()
	{

	}

	public function checkConnected()
	{

	}

	public function getListOfFiles()
	{
		$listOfFiles = array();

		$objects = $this->client->listObjects(array(
			'Bucket' => $this->bucket,
			"Prefix" => SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME')."/"
		));

		for($i=1; $i<count($objects['Contents']); $i++) {
			$size = $objects['Contents'][$i]['Size'];
			$date = $this->standardizeFileCreationDate($objects['Contents'][$i]['LastModified']);
			$name = basename($objects['Contents'][$i]['Key']);

			$listOfFiles[$name] = array(
				'name' => $name,
				'size' => $size,
				'date' => $date,
				'path' => $objects['Contents'][$i]['Key']
			);
		}
		krsort($listOfFiles);
		return $listOfFiles;
	}

	public function createFolder($folderName)
	{
		$result = $this->client->putObject(array(
			'Bucket' => $this->bucket,
			'Key' => $folderName."/",
			'Body' => "",
			'ACL' => 'public-read'
		));

		return $result['ObjectURL'];
	}

	public function downloadFile($filePath, $fileSize)
	{
		@session_write_close();
		$result = array();
		if ($filePath) {
			$chunk = 1.0*1024*1024;
			$start = 0;
			$end = $chunk;

			$fd = fopen(SG_BACKUP_DIRECTORY.basename($filePath), "w");
			$result = array();
			$ret = flase;

			while (true) {
				if (!file_exists(SG_BACKUP_DIRECTORY.basename($filePath))) {
					$ret = false;
					break;
				}

				if ($start >= $fileSize) {
					$ret = true;
					break;
				}

				if ($end > $fileSize) {
					$end = $fileSize;
				}

				$result = $this->client->getObject(array(
					'Bucket' => $this->bucket,
					'Key' => $filePath,
					'Range' => "bytes=$start-$end",
				));
				$data = $result['Body'];

				if (strlen($data)) {
					fwrite($fd, $data);
				}

				$start = $end+1;
				$end += $chunk;
			}
		}

		fclose($fd);
		return $ret;
	}

	public function uploadFile($filePath)
	{
		$fileSize = realFilesize($filePath);
		$keyname = basename($filePath);
		$this->delegate->willStartUpload(1);

		$result = $this->client->createMultipartUpload(array(
			'Bucket'       => $this->bucket,
			'Key'          => SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME').'/'.$keyname
		));
		$uploadId = $result['UploadId'];

		try {
			$file = fopen($filePath, 'r');
			$parts = array();
			$partNumber = 1;
			SGPing::update();
			while (!feof($file)) {
				SGPing::update();
				$result = $this->client->uploadPart(array(
					'Bucket'     => $this->bucket,
					'Key'        => SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME').'/'.$keyname,
					'UploadId'   => $uploadId,
					'PartNumber' => $partNumber,
					'Body'       => fread($file, 5 * 1024 * 1024),
				));
				$parts[] = array(
					'ETag'       => $result['ETag'],
					'PartNumber' => $partNumber++
				);

				$progress = ftell($file)*100.0/$fileSize;
				$this->delegate->updateProgressManually($progress);
			}
			fclose($file);
		}
		catch (S3Exception $e) {
			$result = $this->client->abortMultipartUpload(array(
				'Bucket'   => $this->bucket,
				'Key'      => SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME').'/'.$keyname,
				'UploadId' => $uploadId
			));
		}

		$result = $this->client->completeMultipartUpload(array(
			'Bucket'   => $this->bucket,
			'Key'      => SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME').'/'.$keyname,
			'UploadId' => $uploadId,
			'Parts' => $parts,
		));
	}

	public function deleteFile($fileName)
	{
		$result = $this->client->deleteObject(array(
			'Bucket' => $this->bucket,
			'Key'    => SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME').'/'.$fileName
		));

		return $result;
	}

	public function deleteFolder($folderName)
	{

	}

	private function deleteFolderWithFiles($directory)
	{

	}
}
