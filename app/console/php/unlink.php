<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Php_Unlink extends Console_Controller_Core {

	public $description = 'Unlink the file via php.';

	public function handler( $args = [] ) {
		# check if there are arguments passed.
		if(! isset($args[0]) && empty($args[0]) ) {
			$this->error("Error: no argument was passed.");
			return;
		}

		# correct the directory separator used
		# based on what the current OS
		$args[0] = str_replace("/", DIRECTORY_SEPARATOR, $args[0]);

		# file that we need to delete
		$filename = BP . DS . $args[0];
		unlink($filename);

		# check if the file still exist
		if( file_exists($filename) ) {
			$this->error("Error: unable to delete the specified file path.");
			return false;
		}

		$this->success("Success: the file has been deleted.");
		return true;
	}
}