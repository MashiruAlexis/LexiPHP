<?php

Class Settings_Controller_Account extends Frontend_Controller_Action {

	public function __construct() {
		$this->middleware("auth");
	}

	public function indexAction() {
		$this->setPageTitle("Account Settings");
		$this->setBlock("settings/body");
	}

	public function updateAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$user = Core::getSingleton("system/session")->get("auth");
		$session = Core::getSingleton("system/session");
		$account = Core::getModel("account/account");
		unset($request["btnUpdateSettings"]);
		foreach( $request as $reqKey => $req ) {
			if( empty($req) ) {
				continue;
			}
			$update[$reqKey] = $req;
		}
		$rs = $account->where("id", $user->id)->update($update);
		if( $rs ) {
			$session->add("alert",[
				"type" => "success",
				"message" => "Account settings has been updated."
			]);
		}else{
			$session->add("alert",[
				"type" => "error",
				"message" => "Problem uccored while updating account settings."
			]);
		}
		$account->loginBy("id", $user->id);
		$this->_redirect( Core::getBaseUrl() . "settings/account" );
		return;
	}
}