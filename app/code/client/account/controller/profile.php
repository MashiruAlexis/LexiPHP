<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Profile extends Frontend_Controller_Action {

	/**
	 *
	 */
	public function __construct() {
		$this->middleware("auth");
	}

	/**
	 *
	 */
	public function indexAction() {
		$this->setPageTitle("Profile");
		$this->setBlock("account/profile");
	}

	/**
	 *
	 */
	public function updateAction() {
		$db = Core::getModel("account/account");
		$session = Core::getSingleton("system/session");
		$request = Core::getSingleton("url/request")->getRequest();
		if( isset($request["btnTogglUpdate"]) ) {
			unset($request["btnTogglUpdate"]);
		}
		if( isset($request["btnPersonalUpdate"]) ) {
			unset($request["btnPersonalUpdate"]);
		}

		if( isset($request["id"]) ) {
			$userId = $request["id"];
			unset($request["id"]);
		}

		if( isset($request["workspaceId"]) ) {
			Core::getModel("toggl/workspace")->where("wid", $request["workspaceId"])->update(["isDefault" => 1]);
			unset($request["workspaceId"]);
		}
		
		$res = $db->where("id", $userId)->update($request);

		if( $res ) {
			$session->add("alert", [
				"type" => "info",
				"message" => "Profile has been updated."
			]);
		}else{
			$session->add("alert", [
				"type" => "error",
				"message" => "Something went wrong, please contact IT support."
			]);
		}
		$db->loginBy( "username", $session->get("auth")->username );
		$this->_redirect(Core::getBaseUrl() . "account/profile");
		return;
	}

	public function setup() {
		$this->setCss("account/style");
	}
}