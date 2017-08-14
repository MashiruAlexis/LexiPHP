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

	public function createAction() {
		$session = Core::getSingleton("system/session");
		$request = Core::getSingleton("url/request")->getRequest();
		$db = Core::getModel("account/account");

		if( $request["password"] != $request["repassword"] ) {
			$session->add("alert",[
					"type" => "error",
					"message" => "An error has occurd while checking the input you have provided, please try again."
				]);
			$this->_redirect(Core::getBaseUrl() . "account/register");
		}

		if( $db->where("username", $request["username"])->exist() ) {
			$session->add("alert", [
					"type" => "error",
					"message" => "Sorry, the username you have picked already exist, please pick another one."
				]);
			$this->_redirect(Core::getBaseUrl() . "account/register");
		}

		if( $db->where("email", $request["email"])->exist() ) {
			$session->add("alert", [
					"type" => "error",
					"message" => "Sorry, the email you have picked already exist, please pick another one."
				]);
			$this->_redirect(Core::getBaseUrl() . "account/register");
		}
		
		$reg = $db->insert([
				"username" => $request["username"],
				"password" => $request["password"],
				"email" => $request["email"]
			]);
		if( $reg ) {
			$session->add("alert",[
					"type" => "success",
					"message" => "Congrats, you successfully created an account."
				]);
			$this->_redirect(Core::getBaseUrl() . "account/login");
		}
		$this->_redirect(Core::getBaseUrl() . "account/register");
	}

	public function setup() {
		$this->setJs("account/account");
		$this->setJs("default/jquery.validate.min");
		$this->setCss("default/style");
	}

}