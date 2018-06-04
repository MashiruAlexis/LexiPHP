<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

// migration autoload
spl_autoload_register(function( $migration ) {
	$migration = BP . DS . "database" . DS . "migration" . DS . $migration . ".php";
	if( file_exists($migration) ) {
		return include_once $migration;
	}
});

// seeder autoload
spl_autoload_register(function( $seeder ) {
	$path = BP . DS . "database" . DS . "seeder" . DS . $seeder . ".php";
	if( file_exists($path) ) {
		return include_once $path;
	}
});