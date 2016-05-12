<?php

Class Customer_Controller_Login extends Frontend_Controller_Action {

	public function index() {
		Core::log(Core::getSingleton("url/request"));
		$this->setBlock("customer/login");
		$this->render();
	}
}