<?php

Class Admin_Controller_Users extends Frontend_Controller_Action {

	public function __construct() {
		// to stop unauthenticated user from access to this page
		$this->middleware("auth");
	}

	public function indexAction() {
		$this->setPageTitle("Users");
		$this->setBlock("admin/users");
	}

	/**
	 *	Create User Account
	 */
	public function createAction() {
		$this->setPageTitle("Create Account");
		$this->setBlock("admin/createuser");
	}

	/**
	 *	Delete User Account
	 */
	public function deleteAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$accountDb = Core::getModel("account/account");
		$session = Core::getSingleton("system/session");
		$next = Core::getBaseUrl() . "admin/users";

		if( $accountDb->where("id", $request["id"])->exist() ) {
			$accountDb->where("id", $request["id"])->delete();
			$session->add("alert", [
				"type" => "success",
				"message" => "User was successfully deleted."
			]);
			
		}
		$this->_redirect( $next );
		return;
	}

	public function setup() {
		$this->setJs("default/dashboard");
		$this->setJs("default/jquery.validate.min");
		$this->setJs("account/account");
		
	}
}