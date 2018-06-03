<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_db_setup extends Console_Controller_Core {

	public $description = 'Setup database cridentials via commandline.';

	protected $Database = '';
	protected $User 	= '';
	protected $Password = '';
	protected $Host 	= '';

	public function handler( $args = [] ) {
		// extract values
		$args = $this->extract( $args );

		// set deafualt values
		$Database 	= "lexiphp";
		$User 		= "root";
		$Password 	= "";
		$Host 		= "localhost";

		// the default path
		$tempPath = $this->getConsolePath() . "make" . DS . "template"  . DS . "database.txt";
		$destPath = BP . DS . "app" . DS . "config" . DS . "database.php";

		foreach( $args as $argK => $argV ) {
			if( property_exists($this, $argK) ) {
				$this->{$argK} = $argV;
			}else{
				$this->warning("Unknown argument: " . $argK);
			}
		}

		// set the default values if the user did not set any.
		if( empty($this->Database) ) { $this->Database = $Database; }
		if( empty($this->User) ) { $this->User = $User; }
		if( empty($this->Password) ) { $this->Password = $Password; }
		if( empty($this->Host) ) { $this->Host = $Host; }

		// load template content
		$temp = file_get_contents($tempPath);
		$temp = str_replace("{Database}", $this->Database, $temp);
		$temp = str_replace("{User}", $this->User, $temp);
		$temp = str_replace("{Password}", $this->Password, $temp);
		$temp = str_replace("{Host}", $this->Host, $temp);

		// start
		@file_put_contents($destPath, $temp);

		// check if the file was successfully created
		if( file_exists($destPath) ) {
			$this->info("Database: " . $this->Database);
			$this->info("User: " . $this->User);
			$this->info("Password: " . $this->Password);
			$this->info("Host: " . $this->Host);
			$this->success("Database setup complete.");
			return true;
		}

		$this->error("Something went wrong, database setup incomplete.");
		return false;
	}
}