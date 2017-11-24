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
		$request 	= Core::getSingleton("url/request")->getRequest();
		$session 	= Core::getSingleton("system/session");
		$db 		= Core::getModel("account/account");
		$next 		= Core::getBaseUrl() . "account/login/";
		$hash 		= Core::getSingleton("system/hash");

		if(! $db->where("username", $request["username"])->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Username or Password did not match."
			]);
			$this->_redirect($next);
			return;
		}

		$user = $db->where("username", $request["username"])->first();

		if( $user->status == $db::STATUS_DISABLED ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Your account is Banned/locked. contact admin for more information."
			]);
			$this->_redirect( $next );
			return;
		}

		if(! $hash->verify( $request["password"], $user->password ) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Username or Password did not match."
			]);
			$this->_redirect($next);
			return;	
		}

		$session->add("auth", $user);
		$session->add("alert", [
			"type" => "success",
			"message" => "You have successfully login."
		]);

		$this->_redirect( Core::getBaseUrl() . "admin" );
		return;
	}

	public function exitAction() {
		$session = Core::getSingleton("system/session");
		$session->del("auth");
		$session->del("evaluation");
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