<?php
namespace Errors\Controller;

Class Logger {

	/**
	 *	Print String or Array
	 *	@param String|Array $str
	 *	@return void
	 */
	public static function log( $str ) {
		echo "<pre>";
		print_r($str);
		echo "</pre>";
		return;
	}
}