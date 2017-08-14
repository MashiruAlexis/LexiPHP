<?php

Class Settings_Controller_Account extends Frontend_Controller_Action {

	public function __construct() {
		// $this->mid
	}

	public function indexAction() {
		$this->setPageTitle("Account Settings");
		$this->setBlock("settings/body");
	}
}