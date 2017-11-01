<?php

Class Account_Controller_Login extends frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Login");
		$this->setBlock("account/login");
	}

	public function setup() {
		$this->setJs("default/jquery.validate.min");
		$this->setCss("default/style");
	}
}