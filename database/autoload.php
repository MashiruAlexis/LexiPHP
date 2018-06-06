<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

// migration and seeder autoload
spl_autoload_register(function( $database ) {
	if( strpos($database, "Migration") ) {
		$database = BP . DS . "database" . DS . "migration" . DS . $database . ".php";
	}

	if( strpos($database, "Seeder") ) {
		$database = BP . DS . "database" . DS . "seeder" . DS . $database . ".php";
	}
	
	if( file_exists($database) ) {
		return include_once $database;
	}
});