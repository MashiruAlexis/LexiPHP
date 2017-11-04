<?php

Class Evaluation_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Evaluation");
		$this->setBlock("evaluation/main");
	}

	public function setup() {
		$this->setCss("default/style");
	}
}