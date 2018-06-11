<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Boot extends Frontend_Controller_Action {

	protected $errors = [];

	// let do check if before anything else!
	public function __construct() {
		$file = Core::getSingleton("system/filesystem");



		// default config path
		$confPath = BP . DS . "app" . DS . "config" . DS;
		// lets check for config files
		$configs = [
			"system.php",
			"database.php"
		];

		foreach( $configs as $config ) {
			if(! $file->exists( $confPath . $config ) ) {
				$this->errors[] = $config . " was missing.";
			}
		}

		// check if the htaccess is in place.
		if(! $file->exists(".htaccess") ) {
			$this->errors[] = ".htaccess was missing.";
		}


	}

	/**
	 *	Get the errors while booting
	 */
	public function getErrors() {
		return $this->errors;
	}
}