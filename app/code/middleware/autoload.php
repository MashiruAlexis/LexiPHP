<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */
spl_autoload_register(function( $middleware ){
	$middleware = dirname(__FILE__) . DIRECTORY_SEPARATOR . $middleware . ".php";
	if( file_exists($middleware) ) {
		return include_once $middleware;
	}
	
});