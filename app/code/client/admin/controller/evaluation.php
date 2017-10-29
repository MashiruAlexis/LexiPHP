<?php

Class Admin_Controller_Evaluation extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Evaluation");
		$this->setBlock("admin/evaluation");
	}

	public function addCriteriaAction() {
		$req = Core::getSingleton("url/request")->getRequest();
		$evaluation = Core::getModel("admin/evaluation");
		Core::log( $req );
		Core::log( $evaluation );
	}

	public function setup() {
		$this->setJs("default/dashboard");
	}
}