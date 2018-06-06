<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_make_seeder extends Console_Controller_Core {

	public $description = 'Create Seeder';

	// template name
	protected $template = "seeder.txt";

	public function handler( $args = [] ) {
		// check if there were arguments passed.
		if(! isset($args[0]) ) {
			$this->error("Error: no argument was passed.");
			return false;
		}

		// Seeder Class Name
		$name = ucfirst($args[0]) . "Seeder";
		// table name
		$table = $args[0];

		// lets set the path first
		$pathF = $this->getConsolePath() . "make" . DS . "template" . DS . $this->template;
		$pathT = BP . DS . "database" . DS . "seeder" . DS . $name . ".php";

		// check if the seeder already exist
		if( file_exists($pathT) ) {
			$this->error("Error: " . $name . " already exists.");
			return false;
		}

		// load the content of the template file
		// replace some string on the template content
		$tempData = file_get_contents($pathF);
		$tempData = str_replace("{name}", $name, $tempData);
		$tempData = str_replace("{table}", $table, $tempData);
		
		// create the file to php
		file_put_contents($pathT, $tempData);

		// notify the user if the command run successfully.
		if( file_exists($pathT) ) {
			$this->success("Success: " . $name . " was created.");
			return true;
		}

		$this->error("Somethig went wrong while running this command.");
		return false;
	}
}