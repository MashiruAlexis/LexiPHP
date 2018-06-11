<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_lexi_setup extends Console_Controller_Core {

	public $description = 'Setup project';

	// this is the setting in this framework
	public $baseUrl = "";
	public $siteName = "";

	/**
	 *	Default handler
	 */
	public function handler( $args = [] ) {
		$file = Core::getSingleton("system/filesystem");
		$defaultBaseUrl = 'http://localhost/LexiPHP/';
		$defaultSiteName = 'LexiPHP';

		// set the template path
		$tempPath = $this->getConsolePath() . "make" . DS . "template"  . DS . "system.txt";

		// htaccess template
		$htaccess = $this->getConsolePath() . "make" . DS . "template"  . DS . "htaccess.txt";


		// set the destination path
		$dest = BP . DS . "app" . DS . "config" .  DS . "system.php";

		// if the system config already exist let load them the values
		if( $file->exists($dest) ) {
			$config = include_once $dest;
			$defaultBaseUrl = $config['baseUrl'];
			$defaultSiteName = $config['siteName'];
		}
		
		// extract the data passed on this command
		$args = $this->extract( $args );

		// set the properties of this class
		if( $args ) {
			foreach( $args as $argK => $argV ) {
				if( property_exists($this, $argK) ) {
					$this->{$argK} = $argV;
				}else{
					$this->warning("unknown argument: " . $argK);
				}
			}
		}

		// change the baseurl default value
		if( empty($this->baseUrl) ) {
			$this->baseUrl = $defaultBaseUrl;
		}

		// change the site name default value
		if( empty($this->siteName) ) {
			$this->siteName = $defaultSiteName;
		}

		// load template content and replace some template values
		$temp = file_get_contents($tempPath);
		$temp = str_replace("{baseUrl}", $this->baseUrl, $temp);
		$temp = str_replace("{siteName}", $this->siteName, $temp);

		$tempHtaccess = file_get_contents($htaccess);
		$tempHtaccess = str_replace('{base}', "", $tempHtaccess);
		
		// create the file
		@file_put_contents($dest, $temp);
		@file_put_contents('.htaccess', $tempHtaccess);
		
		// check if the file was created successfully
		if( file_exists($dest) and file_exists($htaccess)) {
			$this->success("Success: system setup complete.");
			return true;
		}

		$this->error("Something went wrong while setup was running.");
		return false;
	}
}