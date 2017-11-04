<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Auth extends Frontend_Controller_Action {

	/**
	 *	check if user is authenticated
	 */
	public function isAuth() {
		return $this->isLogin();
	}

	/**
	 *	Check if the user has login
	 *	@return bool
	 */
	public function isLogin(){
		$session = Core::getSingleton("system/session");
		if( $session->get("auth") ) {
			return true;
		}
		return false;
	}

	/**
	 *	check if the username and password is valid
	 *	@param string $username
	 *	@param string $password
	 *	@return bool
	 */
	public function auth( $username, $password ) {
		$db = Core::getModel("account/account");
		$user = $db->where("username", $username)->where("password", $password)->first();

		if(! isset($user->id) ) {
			return false;
		}

		return true;
	}

}