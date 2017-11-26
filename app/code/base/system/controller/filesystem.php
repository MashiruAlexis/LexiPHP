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

	/**
	 *	Check if we have permission on this path
	 *	@var string $path
	 *	@return bool
	 */
	public function isAccessable( $path ) {
		if( file_exists($path) ) {

		}
	}

}