<?php

Class Login_Controller_Index extends Frontend_Controller_Action {

	public function __construct() {
		// set Css and Js
		$this->setCss("login/style");
	}

	public function index() {
		$kernel = Core::getSingleton("system/kernel");
		Core::log( $kernel->getController() );
		$this->setPageTitle("Login");
		$this->setBlock("login/body");
		$this->render();
	}
}