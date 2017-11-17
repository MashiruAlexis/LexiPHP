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

		// $resEmail = $accountDb->where("email", $request["email"])->exist();
		// if( $resEmail ) {
		// 	$session->add("alert", [
		// 		"type" => "error",
		// 		"message" => "Email already exist."
		// 	]);
		// 	$this->_redirect($next);
		// }

		$resSaveAccount = $accountDb->where("id", $request["id"])->update([
			"fname" => $request["fname"],
			"lname" => $request["lname"],
			// "email" => $request["email"],
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

	/**
	 *	Change Password
	 */
	public function changePasswordAction() {
		$session 	= Core::getSingleton("system/session");
		$hash 		= Core::getSingleton("system/hash");
		$auth 		= $session->get("auth");
		$request 	= Core::getSingleton("url/request")->getRequest();
		$accountDb 	= Core::getModel("account/account");
		$next 		= Core::getBaseUrl() . "admin";
		if( $hash->verify($request["currentPass"], $auth->password) ) {
			$accountDb->where("id", $auth->id)->update(["password" => $hash->hash($request["newPass"])]);
			$session->add("alert",[
				"type" => "success",
				"message" => "Password has been updated."
			]);
			$this->_redirect($next);
		}else{
			$session->add("alert",[
				"type" => "error",
				"message" => "Sorry we could not verify your current password."
			]);
			$this->_redirect($next);
		}
		$this->_redirect($next);
		return;
	}

	/**
	 *	Change Email
	 */
	public function changeEmailAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$auth = $_SESSION["auth"];
		$accountDb = Core::getModel("account/account");
		$accountDb->where("id", $auth->id)->update(["email" => $request["email"]]);
		$this->_redirect(Core::getBaseUrl(). "admin");
	}
}