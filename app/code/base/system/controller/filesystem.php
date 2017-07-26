<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Filesystem {

	/**
	 *	currently open file
	 */
	protected $file;

	/**
	 *	file path
	 */
	protected $path;

	/**
	 *	Create a file
	 *	@var $filename
	 *	@var $path
	 *	@return $bool
	 */
	public function create( $filename, $path  = "temp/") {
		$file = $path . $filename;
		if( file_exists($file) ) {
			return "Exist";
		}
		return "Error: something went wrong.";
	}

	/**
	 *	check if directory is writable
	 *	@var $path
	 *	@return bool
	 */
	public function writable( $path ) {
		if( is_writable($path) ) {

		}
	}
}