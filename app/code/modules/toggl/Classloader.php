<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */
spl_autoload_register(function( $class ) {
    $filePath = dirname(__FILE__). DIRECTORY_SEPARATOR . $class . ".php";
    if( file_exists($filePath) ) {
        return include_once($filePath);
    }
});