<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_make_migration extends Console_Controller_Core {

	public $description = 'Create a migration file.';

	/**
	 *	Create migrations
	 */
	public function handler( $args = [] ) {
		if( count($args) < 1 ) {
			$this->error("Error: missing argurments.");
			return false;
		}

		// set the class name
		$name = ucfirst(strtolower($args[0])) . "Migration";
		$table = strtolower($args[0]);
		$pathF = dirname(__FILE__) . DS . "template" . DS . "migration.txt";
		$pathT = BP . DS . "database" . DS . "migration" . DS . ucfirst($args[0]) . "Migration.php";

		if( file_exists($pathT) ) {
			$this->error("Error: ". $name ." already exists.");
			return false;
		}

		$temp = file_get_contents($pathF);
		$temp = str_replace("{name}", $name, $temp);
		$temp = str_replace("{table}", $table, $temp);
		file_put_contents($pathT, $temp);
		if( file_exists($pathT) ) {
			$this->success("Success: migration " . $name . " was created.");
			return true;
		}

		$this->error("Error: Something went wrong while creating migration.");
		return false;
	}
}