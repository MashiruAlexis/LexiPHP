<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Dashboard");
		$auth = Core::getSingleton("account/auth");

		// trigger login form
		if(! $auth->isLogin() ) {
			$this->setCss("default/style");
			$this->setBlock("account/login");
			return;	
		}

		$this->setBlock("dashboard/body");

	}

	/**
	 *
	 */
	public function setup() {
		$this->setJs("default/dashboard");
	}
}