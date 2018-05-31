<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Login extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->middleware("autologin");
		$this->setPageTitle('Login');
		$this->setBlock("account/login");
	}

	/**
	 *	Submit Login Action
	 */
	public function authenticateAction() {
		$data = Core::getSingleton("http/request")->getRequest();
		$sess = Core::getSingleton("system/session");
		$acct = Core::GetModel("account/account");
		$auth = Core::getSingleton("account/auth");

		if( $acct->login($data["user"], $data["pass"]) ) {
			$this->_redirect(Core::getBaseUrl() . "dashboard");
			return;
		}

		$sess->add("alert", [
				"type" => "error",
				"msg" => "Your account was invalid, please try again."
			]);
		$this->_redirect(Core::getBaseUrl() . "account/login?user=" . $data["user"]);
		return;
	}
}