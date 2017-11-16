<?php

Class Admin_Controller_Account extends Frontend_Controller_Action {

	public function __construct() {
		$this->middleware("auth");
	}

	public function profileAction() {
		$this->setPageTitle("Profile");
		$this->setBlock("admin/profile");
	}

	public function updateAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$accountDb = Core::getModel("account/account");
		$resUsername = $accountDb->where("username", $request["username"])->exist();
		$next = Core::getBaseUrl() . "admin/account/profile";

		if( $resUsername ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Username already exist."
			]);
			$this->_redirect($next);
		}

		$resEmail = $accountDb->where("email", $request["email"])->exist();
		if( $resEmail ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Email already exist."
			]);
			$this->_redirect($next);
		}

		$resSaveAccount = $accountDb->where("id", $request["id"])->update([
			"fname" => $request["fname"],
			"lname" => $request["lname"],
			"email" => $request["email"],
			"username" => $request["username"]
		]);

		if( $resSaveAccount ) {
			$session->add("alert", [
				"type" => "success",
				"message" => "Profile was successfully updated."
			]);
		}

		$this->_redirect($next);
		return;
	}
}