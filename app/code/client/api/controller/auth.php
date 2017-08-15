<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Api_Controller_Auth {

	/** 
	 *	Check if user is login
	 */
	public function authAction() {
		if(! Core::getSingleton("account/auth")->isAuth() ) {
			echo json_encode([
				"type" => "error", 
				"message" => "Your login session has expired, please login again."
			]);
		}
	}
}