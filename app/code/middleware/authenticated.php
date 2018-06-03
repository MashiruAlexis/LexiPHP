<?php

Class Authenticated {

	/**
	 *	Autologin Users
	 */
	public function __construct() {
		$acct = Core::getModel("account/account");
		if(! $acct->isAuth() ) {
			Core::getSingleton("system/session")->add("alert", [
				"type" => "warning",
				"msg" => "You dont have access to the page you requested."
			]);
			header("location: " . Core::getBaseUrl() . "account/login");
			exit();
		}
	}

}