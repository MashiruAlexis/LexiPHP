<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string    $attr    attribute name (read|write|locked|hidden)
 * @param  string    $path    absolute file path
 * @param  string    $data    value of volume option `accessControlData`
 * @param  object    $volume  elFinder volume driver object
 * @param  bool|null $isDir   path is directory (true: directory, false: file, null: unknown)
 * @param  string    $relpath file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume, $isDir, $relpath) {
	$basename = basename($path);
	return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
			 && strlen($relpath) !== 1           // but with out volume root
		? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
		:  null;                                 // else elFinder decide it itself
}

Class Dashboard_Controller_Drive extends Frontend_Controller_Action {

	protected $basePath;

	public function __construct() {
		Core::middleware("auth");

		// elFinder autoload
		require BP . DS . 'package' . DS . 'drive' . DS . 'php' . DS . 'autoload.php';
		elFinder::$netDrivers['ftp'] = 'FTP';
	}

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Drive');
		$this->setBlock("dashboard/drive");
	}

	/**
	 *	set the the drive
	 */
	public function setupDrive( $account ) {
		$file = Core::getSingleton("system/filesystem");

		# base path of the storage files
		$base = BP . DS . 'package' . DS . 'drive' . DS . 'files' . DS . $account->username . DS;
		$this->basePath = $base;

		# check if the directory already exists
		if( $file->dirExist( $base ) ) {
			return false;
		}

		# create the storage space for the user
		if(! mkdir($base) ) {
			# create a global alert message
			Core::alert([
				"type" => "error",
				"msg" => 'Something went wrong while creating your storage drive'
			]);
			return false;
		}

		# create trash directory
		if(! mkdir($base . ".trash" . DS) ) {
			# create a global alert message
			Core::alert([
				"type" => "error",
				"msg" => 'Something went wrong while creating your trash directory for your storage drive.'
			]);
			return false;
		}

		return true;
	}

	/**
	 *	Finder API gateways
	 */
	public function finderAction() {
		$this->setupDrive($_SESSION['account']);
		$opts = array(
			// 'debug' => true,
			'roots' => array(
				// Items volume
				array(
					'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
					'path'          => $this->basePath ,                 // path to files (REQUIRED)
					'URL'           => '/package/drive/files/' . $_SESSION['account']->username . '/', // URL to files (REQUIRED)
					'trashHash'     => 't1_Lw',                     // elFinder's hash of trash folder
					'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
					'uploadDeny'    => array('php'),                // All Mimetypes not allowed to upload
					'uploadAllow'   => array('*'),// Mimetype `image` and `text/plain` allowed to upload
					'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
					'accessControl' => 'access'                     // disable and hide dot starting files (OPTIONAL)
				),
				// Trash volume
				array(
					'id'            => '1',
					'driver'        => 'Trash',
					'path'          => $this->basePath . '.trash/',
					'tmbURL'        => '/package/drive/files/' . $_SESSION['account']->username . '/.trash/.tmb/',
					'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
					'uploadDeny'    => array('all'),                // Recomend the same settings as the original volume that uses the trash
					'uploadAllow'   => array('image', 'text/plain'),// Same as above
					'uploadOrder'   => array('deny', 'allow'),      // Same as above
					'accessControl' => 'access',                    // Same as above
				)
			)
		);

		// run elFinder
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
	}

	/**
	 *	Get the baseurl via api call
	 */
	public function baseurlAction() {
		Response::json([
			'url' => Core::getBaseUrl()
		]);
	}
	
}