<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Sms extends Frontend_Controller_Action {

	public function __construct() {
		Core::middleware('auth');
	}

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Sms');
		$this->setBlock("dashboard/sms");
	}

	/**
	 *	Send Message
	 */
	public function sendAction() {
		$data = Core::getSingleton("url/request")->getPost();
		Core::log( $data );

		
	}
}