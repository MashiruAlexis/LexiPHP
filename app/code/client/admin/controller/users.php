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

	/**
	 *	UnBan Account
	 */
	public function unbanAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$accountDb = Core::getModel("account/account");
		$next = Core::getBaseUrl() . "admin/users";

		if(! isset($request["id"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Invalid Access."
			]);
			$this->_redirect( $next );
			return;
		}

		if(! $accountDb->where("id", $request["id"])->where("status", $accountDb::STATUS_DISABLED)->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Invalid Access"
			]);
			$this->_redirect( $next );
			return;
		}

		$rs = $accountDb->where("id", $request["id"])->update([ "status" => $accountDb::STATUS_ACTIVE ]);

		if( $rs ) {
			$session->add("alert", [
				"type" => "success",
				"message" => "Account was successfully unbanned/unlocked"
			]);
			$this->_redirect( $next );
			return;
		}
		$session->add("alert", [
			"type" => "error",
			"message" => "The system encounter an error while performing an action."
		]);
		$this->_redirect( $next );
		return;
	}

	/**
	 *	Ban/Lock Account
	 */
	public function banAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$accountDb = Core::getModel("account/account");
		$next = Core::getBaseUrl() . "admin/users";

		if(!isset($request["id"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Invalid Access"
			]);
			$this->_redirect( $next );
			return;
		}

		if( $accountDb->where("id", $request["id"])->exist() ) {
			$accountDb->where("id", $request["id"])->update([
				"status" => $accountDb::STATUS_DISABLED
			]);
			$session->add("alert", [
				"type" => "success",
				"message" => "Account was banned/lock."
			]);
			$this->_redirect($next);
		}else{
			$session->add("alert", [
				"type" => "error",
				"message" => "Invalid User"
			]);
			$this->_redirect($next);
		}

		$this->_redirect($next);
	}

	public function setup() {
		$this->setJs("default/dashboard");
		$this->setJs("default/jquery.validate.min");
		$this->setJs("account/account");
		
	}
}