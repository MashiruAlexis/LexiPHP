<?php

Class Customer_Controller_Login extends Frontend_Controller_Action {

	public function index() {
		$this->setBlock("customer/login");
		$this->render();
	}
}