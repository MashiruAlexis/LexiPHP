<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

 Class Test_Controller_Env extends Frontend_Controller_Action {

 	/**
 	 *	Default controller action
 	 */
 	public function indexAction() {
 		// code here
 		echo getenv('APP_NAME');
 	}
 }