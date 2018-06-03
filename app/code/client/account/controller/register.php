<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Register extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->middleware("autologin");
		$this->setPageTitle('Register');
		$this->setBlock("account/register");
		$this->setCss("default/validetta.min");
		$this->setJs("default/validetta.min");
	}

	/**
	 *	Create account
	 */
	public function createAction() {
		$data = Core::getSingleton("url/request")->getRequest();
		$accountDb = Core::getModel("account/account");
		$alert = Core::getSingleton("system/session");

		// check if user already exists
		if( $accountDb->userExist( $data ) ) {
			$alert->add("alert", [
				"type" => "error",
				"msg" => "Account already exist."
			]);
			$this->_redirect(Core::getBaseUrl() . "account/register");
			return;
		}

		$rs = $accountDb->add( $data );

		if(! $rs ) {
			$alert->add("alert",[
				"type" => "error",
				"msg" => "Sorry something went error while creting your account."
			]);
			$this->_redirect(Core::getBaseUrl() . "account/register");
			return;
		}

		$alert->add("alert", [
				"type" => "success",
				"msg" => "Your account was successfully created."
			]);
		$accountDb->login($data["user"], $data["pass"]);
		$this->_redirect(Core::getBaseUrl() . "dashboard");
		return;
	}

}