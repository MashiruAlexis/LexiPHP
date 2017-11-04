<?php

Class Admin_Controller_Users extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Users");
		$this->setBlock("admin/users");
	}

	/**
	 *	Create User Account
	 */
	public function createAction() {
		$this->setPageTitle("Create Account");
		$this->setBlock("admin/createuser");
	}

	public function setup() {
		$this->setJs("default/dashboard");
		$this->setJs("default/jquery.validate.min");
		$this->setJs("account/account");
		
	}
}