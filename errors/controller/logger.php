<?php
namespace Errors\Controller;

use Errors\Controller\Date;

Class Logger {

	public static $pathToLogs;

	public function __construct() {
		self::$pathToLogs = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR;
	}

	/**
 	 *	Print Variables
 	 *	@param string $str
 	 *	@param bool $file
 	 *	@return void
 	 */
 	public static function log( $str, $string = false, $filename = "errors.log" ) {
 		$path = self::$pathToLogs . $filename;
 		$date = new Date;

 		if( $string ) {
 			if( $string || is_object($str) || is_array($str) ) {
	 			file_put_contents($path, "====# " . $date->getDate() . " #====" . "\n", FILE_APPEND);
	 			file_put_contents($path, print_r($str, true) . "\n", FILE_APPEND);
	 			return;
	 		}else{
	 			file_put_contents($path, $date->getDate() . ": " . $str . "\n", FILE_APPEND);
	 			return;
	 		}
 		}
 		echo "<pre>";
 		print_r($str);
 		echo "</pre>";
 	}
}