<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

/**
 *	Filesytem manipulation url
 *	@link http://php.net/manual/en/function.file-get-contents.php
 */
Class System_Controller_Filesystem {

	protected $extension = [
		".php",
		".txt"
	];

	/**
	 *	Create directory
	 *	@param string $path
	 *	@return bool $result
	 */
	public function mkdir( $path ) {
		if( $this->dirExist( $path ) ) {
			return false;
		}
		mkdir($path);
		return true;
	}

	/**
	 *	Check if directory exists
	 *	@param string $path
	 *	@return bool $result
	 */
	public function dirExist( $path ) {
	    // Get canonicalized absolute pathname
		$path = realpath($path);

		// If it exist, check if it's a directory
		return ($path !== false AND is_dir($path)) ? $path : false;
	}

	/** 
	 *	Create A File
	 */
	public function create( $filename, $content = false, $path, $extension = "php" ) {
		if(! $this->isAccessable( $path ) ) {
			return false;
		}

	}

	/**
	 *	Check if we have permission on this path
	 *	@var string $path
	 *	@return bool
	 */
	public function isAccessable( $path ) {
		if( file_exists($path) ) {
			if( is_writable($path) ) {
				return true;
			}
		}
		return false;
	}
}