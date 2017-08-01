<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Login extends Frontend_Controller_Action {

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
			$session->add("alert", [
					"type" => "success",
					"message" => "You have login success fully."
				]);
			$session->add("user", $user);
			$this->_redirect('/');
		}else{
			$session->add("alert", [
				"type" => "error",
				"message" => "The credentials you have enter does not exist in our database."
			]);
		}
		$this->_redirect( Core::getBaseUrl() . 'account/login');
	}

	public function exitAction() {
		$session = Core::getSingleton("system/session");
		$session->del("user");
		$session->add("alert", [
				"type" => "info",
				"message" => "You have successfully logout, come again."
			]);
		$this->_redirect("/");
	}

	public function setup() {
		$this->setJs("default/jquery.validate.min");
		$this->setCss("default/style");
	}
}