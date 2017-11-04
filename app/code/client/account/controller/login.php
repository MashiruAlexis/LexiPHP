<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Login extends Frontend_Controller_Action {

	public function __construct() {
		$this->middleware("autologin");
	}
	
	/**
	 *	User Login
	 */
	public function indexAction() {
		$this->setPageTitle("Login");
		$this->setBlock("account/login");
	}

	public function authenticateAction() {
		$request 	= Core::getSingleton("url/request");
		$session 	= Core::getSingleton("system/session");
		$db 		= Core::getModel("account/account");

		$uname 		= $request->getRequest("username");
		$pass 		= $request->getRequest("password");
		$user 		= $db->where("username", $uname)->where("password", $pass)->first();
		if( $user ) {
			$session->add("auth", $user);
			if( $request->getRequest("redirect") ) {
				$this->_redirect($request->getRequest("redirect"));
			}else{
				$this->_redirect( Core::getBaseUrl() . "dashboard" );
			}
		}else{
			$session->add("alert", [
				"type" => "error",
				"message" => "Username or Password is incorrect."
			]);
		}
		$this->_redirect( Core::getBaseUrl() . 'account/login');
	}

	public function exitAction() {
		$session = Core::getSingleton("system/session");
		$session->del("auth");
		$session->add("alert", [
				"type" => "info",
				"message" => "You have successfully logout, come again."
			]);
		$this->_redirect( Core::getBaseUrl() . "account/login" );
	}

	public function setup() {
		$this->setJs("default/jquery.validate.min");
		$this->setCss("default/style");
	}
}