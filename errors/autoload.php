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
		$obj = strtolower($obj);
		$path = $this->basepath . DS . $obj . '.php';
		if( file_exists($path) ) {
			return include_once $path;
		}
		return;
	}

	/**
	 *	Start!
	 *	@return obj $this
	 */
	public static function boot() {
		return new Autoload;
	}
}
