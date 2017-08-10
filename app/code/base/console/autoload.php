<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

spl_autoload_register(function( $obj ) {
	$obj = BP . DS . "app" . DS . str_replace(US, DS, $obj) . ".php";
	if( file_exists($obj) ) {
		return include_once $obj;
	}
});