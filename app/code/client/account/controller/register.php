<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Register extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Create Account");
		$this->setBlock("account/register");
	}

	/**
	 *	Create User Account
	 */
	public function createAction() {
		$session 	= Core::getSingleton("system/session");
		$request 	= Core::getSingleton("url/request")->getRequest();
		$accountDb 	= Core::getModel("account/account");
		$hash 		= Core::getSingleton("system/hash");
		$next 		= isset($request["redirect"]) ? $request["redirect"] : false;

		Core::log( $request );

		if( $accountDb->where("username", $request["username"])->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Username already exist."
			]);

			if( $next ) {
				$this->_redirect( $next );
			}
			$this->_redirect( Core::getBaseUrl() . "admin" );
		}

		if( $accountDb->where("email", $request["email"])->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Email already exist."
			]);

			if( $next ) {
				$this->_redirect( $next );
			}
			$this->_redirect( Core::getBaseUrl() . "admin" );
		}

		$rs = $accountDb->insert([
			"account_type_id" 	=> $request["accountType"],
			"fname"				=> $request["fname"],
			"lname"				=> $request["lname"],
			"username" 			=> $request["username"],
			"email" 			=> $request["email"],
			"password" 			=> $hash->hash($request["password"]),
			"status" 			=> $accountDb::STATUS_ACTIVE
		]);

		if( $rs ) {
			$session->add("alert", [
				"type" => "success",
				"message" => "Successfully created account."
			]);
		}

		if( $next ) {
			$this->_redirect( $next );
		}
		return;
	}

	public function setup() {
		$this->setJs("account/account");
		$this->setJs("default/jquery.validate.min");
		$this->setCss("default/style");
	}

}