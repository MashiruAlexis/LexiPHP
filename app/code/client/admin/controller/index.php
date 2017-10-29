<?php

Class Admin_Controller_Index extends Frontend_Controller_Action {

	/**
	 *	Admin main page
	 */
	public function indexAction() {
		$this->setPageTitle("Admin");
		$this->setBlock("admin/main");
	}

	/**
	 *	Evaluation Page
	 */
	public function evaluationAction() {
		$this->setPageTitle("Evaluation");
		$this->setBlock("admin/evaluation");
	}

	/**
	 *	Client Setup
	 */
	public function setup() {
		$this->setJs("default/dashboard");
	}
}