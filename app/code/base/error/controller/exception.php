<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Error_Controller_Exception extends Frontend_Controller_Action {

	// public function __construct( $e ) {
	// 	Core::log( "test" );
	// 	return;
	// }

	public function handler( $e = false ) {
		echo $e->getTrace();
	}
}