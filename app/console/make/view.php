<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_make_view extends Console_Controller_Core {

	/**
	 *	Command Description
	 */
	public $description = 'Create views vies commandline.';

	/**
	 *	Command Handler Execution
	 */
	public function handler( $args = [] ) {

		// check if there are arguments passed
		if( empty($args) ) {
			$this->error("Error: this command accepts two arguments.");
			return; // exit
		}

		// syntax check
		if( strrpos('/', $args[0]) == true  or count($args) > 1 ) {
			$this->error("Error: please check your syntax.");
			return;
		}

		$this->log( $args );

		
		return;
	}
}