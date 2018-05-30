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
		$this->setPageTitle('Login');
		$this->setBlock("account/login");
	}

	/**
	 *	Submit Login Action
	 */
	public function authenticateAction() {
		$data = Core::getSingleton("http/request")->getRequest();
		Core::log( $data );
		$this->_redirect(Core::getBaseUrl());
	}
}