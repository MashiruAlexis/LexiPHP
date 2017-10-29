<?php

Class Admin_Controller_Configure extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Configure");
		$this->setBlock("admin/configure");
	}

	public function setup() {
		$this->setJs("default/dashboard");
	}
}