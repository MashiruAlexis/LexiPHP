<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Logger {

	protected $path = '';

	/**
	 *	Set Path where to log
	 *	@param string $path
	 *	@return obj $this
	 */
	public function setPath( $path ) {
		$this->path = $path;
		return $this;
	}

	/**
	 *	Log
	 *	@param 
	 */
	public function log() {
	}
}