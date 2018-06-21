<?php
namespace Errors\Controller;

use Errors\Controller\Logger as Log;

Class Config {

	/**
	 *	Config Path
	 */
	public $path;

	/**
	 *	constructor
	 *	Set the config path
	 */
	public function __construct() {
		$this->path = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
	}

	/**
	 *	Get config
	 *	@param string $config
	 *	@return bool void
	 */
	public function get( $config ) {
		$path = $this->path . $config . '.php';
		if( file_exists($path) ) {
			return include $path;
		}
		return false;;
	}

	public static function run() {
		return new Config;
	}
}