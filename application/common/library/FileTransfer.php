<?php

namespace app\library;

class FileTransfer
{
	protected $_prefixPath = null;
	protected $_destinationPath = null;
	protected $_targetPath = null;	
	protected $_allowedFileExts = null;
	protected $_allowedMaxFileSize = null;
	
	public function __construct($destinationPath, array $options = array())
	{
		$defaults = array(
			'prefixPath' => null,
			'allowedFileExtension' => array(),
			'allowedMaxFileSize' => $this->return_bytes(ini_get("upload_max_filesize"))
		);
		$options = array_merge($defaults, $options);

		/*check destination path*/
		$this->_destinationPath =  rtrim($destinationPath, '/');
		if(!is_dir($this->_destinationPath) || !is_writable($this->_destinationPath)){
			throw new \Exception('FileTransfer Exception: Destination directory "'.$this->_destinationPath.'" does not exist or is not writable!');	
		}
		
		/*validate prefix path*/
		$this->_prefixPath = ltrim($options['prefixPath'], '/');
		if($this->_prefixPath !== null){
			if(preg_match('/[?.*"<>|]+/i', $this->_prefixPath)){
				throw new \Exception('FileTransfer Exception: The prefix path can\'t contain any of the following characters: ? . * " < > |');	
			}
		}
		$this->_targetPath = $this->_destinationPath.'/'.$this->_prefixPath;
		
		/*build target path*/
		if(!is_dir($this->_targetPath)){
			if(!@mkdir($this->_targetPath, 0755, true)){
				throw new \Exception('FileTransfer Exception: Error occurred while creating upload dir!');	
			}
		}
		
		$this->_allowedMaxFileSize = $options['allowedMaxFileSize'];
		$this->setAllowedFileExts($options['allowedFileExtension']);
	}
	
	/**
     * Set allowed file extension.
     * @param 	(array|string)$strAllowedFileExts, 
	 			(string)$delimiter (optional - used if $strAllowedFileExts is not array)
     * @return void
     */
	public function setAllowedFileExts($strAllowedFileExts, $delimiter = ','){
		$this->_allowedFileExts = $strAllowedFileExts;
		if(!is_array($this->_allowedFileExts)){
			$this->_allowedFileExts = explode($delimiter, $this->_allowedFileExts);
		}
	}
	
	/**
     * Get target path (included both destinationPath and prefixPath)
     * @param none
     * @return string
     */
	public function getTargetPath(){
		return $this->_targetPath;
	}
	
	public function uploadMultiple(array $files, $chmod = 0755, $replace=false)
	{
		$arrFiles = array();
		foreach( $files as $key => $item ){
			foreach($item as $i => $value)
				$arrFiles[$i][$key] = $value;    
		}
		
		$arrFileInfo = array();
		foreach($arrFiles as $file){
			$arrFileInfo[] = $this->upload($file, $chmod, $replace);	
		}
		return $arrFileInfo;
	}
	
	/**
     * Upload sing file to target path
     * @param 	(array) $file: array contains the uploaded file information
	 			(int)$chmod (optional - default 0755), 
	 			(bool)$replace (optional - default false): TRUE means replace the name of uploaded file to avoid overwriting existed file
     * @return string
     */
	public function upload(array $file, $chmod = 0755, $replace=false){		
		$arrFileInfo = array();
		/*upload article images*/
		if(isset($file["error"]) && $file["error"] == UPLOAD_ERR_OK) {
			
			/*get uploaded file info*/
			$tempFile = $file["tmp_name"];
			$fileName = $this->sanitize($file['name']);
			$fileSize = $file['size'];
			$fileType = $file['type'];
			$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

			/*check file size is allowed to upload?*/
			if(!empty($this->_allowedMaxFileSize) && $fileSize > $this->_allowedMaxFileSize){
				@unlink($tempFile);
				throw new \Exception("FileTransfer Exception: '$fileName' is too large");
			}

			/*check file extension is allowed to upload?*/			
			if(!empty($this->_allowedFileExts) && !in_array($fileExtension, $this->_allowedFileExts)){
				@unlink($tempFile);
				throw new \Exception("FileTransfer Exception: Extension '$fileExtension' is not allowed to upload");
			}
			
			/*Check uploaded file path*/
			$fileNamePrefix = '';
			$filePath = $this->_targetPath.'/'.$fileName;
			if(file_exists($filePath)){
				if($replace == false){
					$fileNamePrefix = time().'_';
					$filePath = $this->_targetPath.'/'.$fileNamePrefix.$fileName;
				} else {
					@unlink($filePath);
				}
			}
			
			/*move file to server*/
			if (@is_uploaded_file($tempFile) && @move_uploaded_file($tempFile, $filePath)){
				/*Set permissions on filename*/
				@chmod($filePath, $chmod);
				/*set file info*/
				$arrFileInfo = array('error'=>$file["error"],
									 'filename'=>$fileName, 
									 'extension'=>$fileExtension, 
									 'size'=>round($fileSize/1024, 2), /*KB*/
									 'type'=>$fileType, 
									 'path'=>$this->_prefixPath.'/'.$fileNamePrefix.$fileName);
			}
			return $arrFileInfo;
		}
		
		/*Exceptions*/
		if($file["error"] == UPLOAD_ERR_INI_SIZE) throw new \Exception('The uploaded file exceeds the upload_max_filesize directive in php.ini');
		if($file["error"] == UPLOAD_ERR_FORM_SIZE) throw new \Exception('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form');
		if($file["error"] == UPLOAD_ERR_PARTIAL) throw new \Exception('The uploaded file was only partially uploaded');
		if($file["error"] == UPLOAD_ERR_NO_FILE) throw new \Exception('No file was uploaded');
		if($file["error"] == UPLOAD_ERR_NO_TMP_DIR) throw new \Exception('Missing a temporary folder');
		if($file["error"] == UPLOAD_ERR_CANT_WRITE) throw new \Exception('Failed to write file to disk');
		if($file["error"] == UPLOAD_ERR_EXTENSION) throw new \Exception('A PHP extension stopped the file upload');
	}

	public function downloadFromUrl($url, $chmod = 0644, $rename=true){
		$arrFileInfo = array();
		try{
			if (filter_var($url, FILTER_VALIDATE_URL) === false) {
				throw new \Exception("{$url} is not a valid URL");
			}
			
			/*get downloaded file info*/
			$parts = explode('/', parse_url($url, PHP_URL_PATH));
			$fileName = $this->sanitize(end($parts));
			$fileSize = '0';
			$fileType = '';
			$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			
			/*check file is allowed to download?*/			
			if(!empty($this->_allowedFileExts) && !in_array($fileExtension, $this->_allowedFileExts)){
				throw new \Exception("extension '$fileExtension' is not allowed to download");
			}
			
			/*Check uploaded file path*/
			$fileNamePrefix = '';
			$filePath = $this->_targetPath.'/'.$fileName;
			if(file_exists($filePath)){
				if($rename == true){
					$fileNamePrefix = time().'_';
					$filePath = $this->_targetPath.'/'.$fileNamePrefix.$fileName;
				} else {
					@unlink($filePath);
				}
			}
			
			/*move file to server*/
			if(@copy($url, $filePath)){
				/*Set permissions on filename*/
					@chmod($filePath, $chmod);
					/*set file info*/
					$arrFileInfo = array('filename'=>$fileName, 
										 'extension'=>$fileExtension, 
										 'size'=>round($fileSize/1024, 2), /*KB*/
										 'type'=>$fileType, 
										 'path'=>$this->_prefixPath.'/'.$fileNamePrefix.$fileName);
			}
			return $arrFileInfo;
			
		} catch(\Exception $ex){
			throw new \Exception($ex->getMessage());	
		}
	}

	//deprecated function!
	public static function rearrangeGlobalFilesArray(array $files) {
		//check if uploading multi files?
		if(isset($files['error']) && is_array($files['error'])){
			$new = array();
			foreach( $files as $key => $item ){
				foreach($item as $i => $value)
					$new[$i][$key] = $value;    
			}
			return $new;
		}
		else{
			return $files;	
		}
	}
	
	protected function sanitize($fileName, $length=0){
		$fileName = preg_replace('/(-{2,})|(\.{2,})+/', '-', strtolower(trim(preg_replace('/[^\w.]|[|_]+/', '-', $fileName), '-')));
		if(is_int($length) && $length > 0 && mb_strlen($fileName, "UTF-8") > $length) 
		{
			$fileName = mb_substr($fileName, 0, $length, "UTF-8");
		}
		return $fileName;
	}
	
	protected function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}
}