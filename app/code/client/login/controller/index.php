<?php

Class Login_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$kernel = Core::getSingleton("system/kernel");
		Core::log( $kernel->getController() );
		$this->setPageTitle("Login");
		$this->setBlock("login/body");
	}

	/**
	 *	
	 */
	public function setup() {
		$this->setCss("login/style");
	}
}