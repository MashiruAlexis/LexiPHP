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
		$defaultBaseUrl = 'http://localhost/LexiPHP/';
		$defaultSiteName = 'LexiPHP';

		// set the template path
		$tempPath = $this->getConsolePath() . "make" . DS . "template"  . DS . "system.txt";
		// set the destination path
		$dest = BP . DS . "app" . DS . "config" .  DS . "system.php";
		
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
		
		// create the file
		@file_put_contents($dest, $temp);

		// check if the file was created successfully
		if( file_exists($dest) ) {
			$this->success("Success: system setup complete.");
			return true;
		}

		$this->error("Something went wrong while setup was running.");
		return false;
	}
}