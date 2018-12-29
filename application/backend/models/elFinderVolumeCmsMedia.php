<?php

//namespace backend\models;

use backend\models\cms\Media;

/**
 * Simple elFinder driver for MySQL.
 *
 * @author AnhDKD (dkduyanh17@gmail.com)
 **/
class elFinderVolumeCmsMedia extends \elFinderVolumeMySQL {
	
	/**
	 * Driver id
	 * Must be started from letter and contains [a-z0-9]
	 * Used as part of volume id
	 *
	 * @var string
	 **/
	protected $driverId = 'c';
	
	/**
	 * Constructor
	 * Extend options with required fields
	 *
	 * @return void
	 * @author AnhDKD (dkduyanh17@yahoo.com)
	 **/
	public function __construct() {
		$opts = array(
			'path'			=> 1, //Root dir path
			'tmbPath'       => Media::UPLOADS_DIR.'/.tmb', //Thumbnails dir path
			'tmpPath'       => Media::TEMP_DIR.'/.tmp',
			'tmbURL'		=> Media::UPLOADS_URL.'/.tmb',
			'rootCssClass'  => 'elfinder-navbar-root-sql',
			'dirMode'		=> 0755, // new dirs mode
			'fileMode'		=> 0644  // new files mode
		);
		$this->options = array_merge($this->options, $opts);
		$this->options['mimeDetect'] = 'internal';
	}
	
	/*********************************************************************/
	/*                        INIT AND CONFIGURE                         */
	/*********************************************************************/
	
	/**
	 * Prepare driver before mount volume.
	 * Connect to db, check required tables and fetch root path
	 *
	 * @return bool
	 * @author AnhDKD (dkduyanh17@yahoo.com)
	 **/
	protected function init() {
		$this->updateCache($this->options['path'], $this->_stat($this->options['path']));
		return true;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see elFinderVolumeMySQL::configure()
	 */
 	protected function configure() {
		parent::configure();
	} 
	
	/**
	 * Close connection
	 *
	 * @return void
	 * @author AnhDKD (dkduyanh17@yahoo.com)
	 **/
	public function umount() {
		return true;
	}	
	
	/**
	 * Return debug info for client
	 *
	 * @return array
	 * @author Dmitry (dio) Levashov
	 **/
	public function debug() {
		/* $debug = parent::debug();
		$debug['sqlCount'] = $this->sqlCnt;
		if ($this->dbError) {
			$debug['dbError'] = $this->dbError;
		}
		return $debug; */
	}

	/**
	 * Create empty object with required mimetype
	 *
	 * @param  string  $path  parent dir path
	 * @param  string  $name  object name
	 * @param  string  $mime  mime type
	 * @return bool
	 * @author Dmitry (dio) Levashov
	 **/
	protected function make($path, $name, $mime) {
		$media = new Media([
			'parent_id' => $path,
			'name' => $name,
			'mime' => $mime,
			'is_visible' => 1,
			'is_locked' => 0,
		]);
		return $media->save();
	}

	/*********************************************************************/
	/*                               FS API                              */
	/*********************************************************************/
	
	private function mapFields($arr){
		if(empty($arr)) return false;
		if($arr['mime'] == Media::MIME_FOLDER){
			//$ret['content'] = '';
			$arr['mime'] = 'directory';
			$arr['read'] = 1;
			$arr['write'] = 1;
			$arr['locked'] = 0;
			$arr['hidden'] = 0;
			$arr['dirs'] = !empty($arr['children'])?1:0;
		}
		else{
			//$ret['content'] = '';
			$arr['mime'] = (!empty($arr['mime'])?$arr['mime']:self::$mimetypes[strtolower($arr['extension'])]);
			$arr['read'] = 1;
			$arr['write'] = 1;
			$arr['locked'] = 0;
			$arr['hidden'] = 0;
			$arr['width'] = 300;
			$arr['height'] = 300;
			$arr['dirs'] = 0;
			$arr['content_path'] = @$arr['content_path'];
		}
		
		$arr['ts'] = @strtotime($arr['created_date']);
		//unset($arr['created_date']);
		
		return $arr;
	}
	
	/**
	 * Cache dir contents
	 *
	 * @param  string  $path  dir path
	 * @return string
	 * @author Dmitry Levashov
	 **/
	protected function cacheDir($path) {
		$this->dirsCache[$path] = array();
		
		$rows = Media::find()->where(['parent_id' => $path])->asArray()->all();
		foreach($rows as $row){
			$row = $this->mapFields($row);
			$id = $row['id'];
				
			if ($row['parent_id']) {
				$row['phash'] = $this->encode($row['parent_id']);
			}
			if ($row['mime'] == 'directory') {
				unset($row['width']);
				unset($row['height']);
			} else {
				unset($row['dirs']);
			}
			unset($row['id']);
			unset($row['parent_id']);
			if (($stat = $this->updateCache($id, $row)) && empty($stat['hidden'])) {
				$this->dirsCache[$path][] = $id;
			}
		}
		
		return $this->dirsCache[$path];
	}

	/**
	 * Recursive files search
	 *
	 * @param  string  $path   dir path
	 * @param  string  $q      search string
	 * @param  array   $mimes
	 * @return array
	 * @author Dmitry (dio) Levashov
	 **/
	protected function doSearch($path, $q, $mimes) {
		/* $dirs = array();
		$timeout = $this->options['searchTimeout']? $this->searchStart + $this->options['searchTimeout'] : 0;
		
		if ($path != $this->root) {
			$dirs = $inpath = array(intval($path));
			while($inpath) {
				$in = '('.join(',', $inpath).')';
				$inpath = array();
				$sql = 'SELECT f.id FROM %s AS f WHERE f.parent_id IN '.$in.' AND `mime` = \'directory\'';
				$sql = sprintf($sql, $this->tbf);
				if ($res = $this->query($sql)) {
					$_dir = array();
					while ($dat = $res->fetch_assoc()) {
						$inpath[] = $dat['id'];
					}
					$dirs = array_merge($dirs, $inpath);
				}
			}
		}

		$result = array();
		
		if ($mimes) {
			$whrs = array();
			foreach($mimes as $mime) {
				if (strpos($mime, '/') === false) {
					$whrs[] = sprintf('f.mime LIKE \'%s/%%\'', $this->db->real_escape_string($mime));
				} else {
					$whrs[] = sprintf('f.mime = \'%s\'', $this->db->real_escape_string($mime));
				}
			}
			$whr = join(' OR ', $whrs);
		} else {
			$whr = sprintf('f.name RLIKE \'%s\'', $this->db->real_escape_string($q));
		}
		if ($dirs) {
			$whr = '(' . $whr . ') AND (`parent_id` IN (' . join(',', $dirs) . '))';
		}
		
		$sql = 'SELECT f.id, f.parent_id, f.name, f.size, f.mtime AS ts, f.mime, f.read, f.write, f.locked, f.hidden, f.width, f.height, 0 AS dirs 
				FROM %s AS f 
				WHERE %s';
		
		$sql = sprintf($sql, $this->tbf, $whr);
		
		if (($res = $this->query($sql))) {
			while ($row = $res->fetch_assoc()) {
				if ($timeout && $timeout < time()) {
					$this->setError(elFinder::ERROR_SEARCH_TIMEOUT, $this->path($this->encode($path)));
					break;
				}
				
				if (!$this->mimeAccepted($row['mime'], $mimes)) {
					continue;
				}
				$id = $row['id'];
				if ($row['parent_id']) {
					$row['phash'] = $this->encode($row['parent_id']);
				} 
				$row['path'] = $this->_path($id);

				if ($row['mime'] == 'directory') {
					unset($row['width']);
					unset($row['height']);
				} else {
					unset($row['dirs']);
				}

				unset($row['id']);
				unset($row['parent_id']);

				if (($stat = $this->updateCache($id, $row)) && empty($stat['hidden'])) {
					$result[] = $stat;
				}
			}
		}
		
		return $result; */
	}


	/*********************** paths/urls *************************/

	/**
	 * Join dir name and file name and return full path
	 *
	 * @param  string  $dir
	 * @param  string  $name
	 * @return string
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _joinPath($dir, $name) {
		$id = Media::getIdByPath($dir, $name);
		if($id){
			$this->updateCache($id, $this->_stat($id));
			return $id;
		}
		return -1;		
	}	
	
	/***************** file stat ********************/
	/**
	 * Return stat for given path.
	 * Stat contains following fields:
	 * - (int)    size    file size in b. required
	 * - (int)    ts      file modification time in unix time. required
	 * - (string) mime    mimetype. required for folders, others - optionally
	 * - (bool)   read    read permissions. required
	 * - (bool)   write   write permissions. required
	 * - (bool)   locked  is object locked. optionally
	 * - (bool)   hidden  is object hidden. optionally
	 * - (string) alias   for symlinks - link target path relative to root path. optionally
	 * - (string) target  for symlinks - link target path. optionally
	 *
	 * If file does not exists - returns empty array or false.
	 *
	 * @param  string  $path    file path 
	 * @return array|false
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _stat($path) {
		$row = Media::find()->where(['id' => $path])->asArray()->one();
		if ($row) {
			$stat = $this->mapFields($row);
			if ($stat['parent_id']) {
				$stat['phash'] = $this->encode($stat['parent_id']);
			}
			if ($stat['mime'] == Media::MIME_FOLDER) {
				unset($stat['width']);
				unset($stat['height']);
				$stat['size'] = 0;
			} else {
				unset($stat['dirs']);
			}
			unset($stat['id']);
			unset($stat['parent_id']);
			return $stat;
		
		}
		return array();		
	}
	
	
	/**
	 * Return object width and height
	 * Usualy used for images, but can be realize for video etc...
	 *
	 * @param  string  $path  file path
	 * @param  string  $mime  file mime type
	 * @return string
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _dimensions($path, $mime) {
		return ($stat = $this->stat($path)) && isset($stat['width']) && isset($stat['height']) ? $stat['width'].'x'.$stat['height'] : '';
	}
	
	/******************** file/dir content *********************/
		
	/**
	 * Open file and return file pointer
	 *
	 * @param  string  $path  file path
	 * @param  string  $mode  open file mode (ignored in this driver)
	 * @return resource|false
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _fopen($path, $mode='rb') {
		$file = Media::findOne($path);
		if($file !== null){
			if(is_file($filepath = Media::UPLOADS_DIR.'/'.$file['content_path'])){					
				return fopen($filepath, $mode);
			} 			
			if(!empty($file['content'])){
				$fp = $this->tmbPath
					? fopen($this->getTempFile($path), 'w+')
					: tmpfile();
				fwrite($fp, $r['content']);
				rewind($fp);
				return $fp;				
			}
		}
		return false;
	}

	/**
	 * Close opened file
	 *
	 * @param  resource $fp file pointer
	 * @param string $path
	 * @return bool
	 * @author Dmitry (dio) Levashov
	 */
	protected function _fclose($fp, $path='') {
		fclose($fp);
		if ($path) {
			unlink($this->getTempFile($path));
		}
	}
	
	/********************  file/dir manipulations *************************/	
	
	/**
	 * Create dir and return created dir path or false on failed
	 *
	 * @param  string  $path  parent dir path
	 * @param string  $name  new directory name
	 * @return string|bool
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _mkdir($path, $name) {
		return $this->make($path, $name, Media::MIME_FOLDER) ? $this->_joinPath($path, $name) : false;
	}
	
	/**
	 * Copy file into another file
	 *
	 * @param  string  $source     source file path
	 * @param  string  $targetDir  target directory path
	 * @param  string  $name       new file name
	 * @return bool
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _copy($source, $targetDir, $name) {
		$this->clearcache();
		$id = $this->_joinPath($targetDir, $name);

		if($id < 0)
		{
			$src = Media::findOne($source);
			
			$trg = new Media();
			foreach($src->attributes as $attr => $val)
			{
				if($attr == 'id') continue;
				$trg->$attr = $val;
			}
			$trg->parent_id = $targetDir;
			$trg->save();
			
			//TODO: SHOULD DUPLICATE CONTENT? OR IF REUSE, CHECK BEFORE DELETE SOURCE
			
			return $trg->id;
		}
		
		return false; 
	}

	/**
	 * Move file into another parent dir.
	 * Return new file path or false.
	 *
	 * @param  string $source source file path
	 * @param $targetDir
	 * @param  string $name file name
	 * @return bool|string
	 * @internal param string $target target dir path
	 * @author Dmitry (dio) Levashov
	 */
	protected function _move($source, $targetDir, $name) {
		$media = Media::findOne($source);
		$media->parent_id = $targetDir;
		$media->name = $name;
		return $media->save();
	}
		
	/**
	 * Remove file
	 *
	 * @param  string  $path  file path
	 * @return bool
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _unlink($path) {
		$media = Media::findOne($path);
		if($media->delete()){
			if(is_file($filepath = Media::UPLOADS_DIR.'/'.$media['content_path'])){
				return @unlink($filepath);
			}
			return true;
		}
		return false;
	}

	/**
	 * Remove dir
	 *
	 * @param  string  $path  dir path
	 * @return bool
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _rmdir($path) {
		$media = Media::find()->where(['id' => $path, 'mime' => Media::MIME_FOLDER])->one();
		if($media->delete())
		{
			//TODO: UNLINK SUB-FOLDERS AND FILES RECURSIVELY
			return true;
		}
		return false;
	}
	
	/**
	 * Create new file and write into it from file pointer.
	 * Return new file path or false on error.
	 *
	 * @param  resource  $fp   file pointer
	 * @param  string    $dir  target dir path
	 * @param  string    $name file name
	 * @param  array     $stat file stat (required by some virtual fs)
	 * @return bool|string
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _save($fp, $dir, $name, $stat) {
		$this->clearcache();
		$mime = $stat['mime'];
		$w = !empty($stat['width'])  ? $stat['width']  : 0;
		$h = !empty($stat['height']) ? $stat['height'] : 0;
		
		$id = $this->_joinPath($dir, $name);
		elFinder::rewind($fp);
		$stat = fstat($fp);
		$size = $stat['size'];
		
		if (($tmpfile = tempnam($this->tmpPath, $this->id))) {
			if (($trgfp = fopen($tmpfile, 'wb')) == false) {
				unlink($tmpfile);
			} else {
				while (!feof($fp)) {
					fwrite($trgfp, fread($fp, 8192));
				}
				fclose($trgfp);
				chmod($tmpfile, 0644);
		
				//DuyAnh :: move uploaded files				
				$relFilePath = 'cms/'.date('Y').'/'.date('md').'/'.substr(md5($name), 0, 1);
				$absFilePath = Media::UPLOADS_DIR.'/'.$relFilePath;					
				if(!is_dir($absFilePath)){
					mkdir($absFilePath, 0777, true);
				}
				if(!is_file($absFilePath.'/'.$name) && !copy($tmpfile, $absFilePath.'/'.$name))
				{
					unlink($tmpfile);
					return false;
				}
				if(is_file($tmpfile)) unlink($tmpfile);
				
				//update DB
				$media = new Media();
				$media->parent_id = $dir;
				$media->name = $name;
				$media->content_path = $relFilePath.'/'.$name;
				$media->size = $size;
				$media->extension = pathinfo($name, PATHINFO_EXTENSION);
				$media->mime = $mime;
				$media->is_visible = 1;
				$media->is_locked = 0;
				$media->save();
				return $media->id;
			}
		}
		return false;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see elFinderVolumeMySQL::_getContents()
	 */
	protected function _getContents($path) {
		//return file_get_contents($path);
		return false;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see elFinderVolumeMySQL::_filePutContents()
	 */
	protected function _filePutContents($path, $content) {
		if (file_put_contents($path, $content, LOCK_EX) !== false) {
			clearstatcache();
			return true;
		}
		return false;
	}
}