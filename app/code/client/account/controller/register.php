<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Register extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Create Account");
		$this->setBlock("account/register");
	}

	public function createAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		if( $request["password"] != $request["repassword"] ) {

		}
		$this->_redirect("/account/register");
	}

	public function setup() {
		$this->setJs("account/account");
		$this->setJs("default/jquery.validate.min");
	}

}