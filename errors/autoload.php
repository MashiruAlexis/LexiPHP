<?php
namespace Errors;

/**
 *	Auto Error namespace
 */
Class Autoload {
	
	protected $basepath;

	/**
	 * constructor
	 */	
	public function __construct() {
		$this->basepath = dirname(dirname(__FILE__));
		spl_autoload_register([$this, 'autoloader']);
	}

	/**
	 *	autoload handler
	 *	@param string $obj
	 *	@return void
	 */
	public function autoloader( $obj ) {

		# make the path is compatible with the current OS
		$obj = str_replace("\\", DIRECTORY_SEPARATOR, $obj);

		# lower the character since linux is very sensitive
		$obj = strtolower($obj);

		# set the basepath
		$path = $this->basepath . DIRECTORY_SEPARATOR . $obj . '.php';

		# check if the error controller exist before we load it
		if( file_exists($path) ) {
			return include_once $path;
		}

		return false;
	}

	/**
	 *	Start!
	 *	@return obj $this
	 */
	public static function boot() {
		return new Autoload;
	}
}
