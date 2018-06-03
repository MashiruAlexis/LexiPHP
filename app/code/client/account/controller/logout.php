<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Logout extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$acct = Core::getModel("account/account");
		$sess = Core::getSingleton("system/session");
		if( $acct->logout() ) {
			$sess->add("alert", [
				"type" => "success",
				"msg" => "We have successfully logout your account."
			]);
			$this->_redirect(Core::getBaseUrl() . "account/login");
		}else{
			$sess->add("alert", [
				"type" => "warning",
				"msg" => "We are facing issues logging out your account."
			]);
			$this->_redirect(Core::getBaseUrl() . "dashboard");
		}
	}
}