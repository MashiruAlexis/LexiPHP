<?php

Class Arksystems_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Enter Number");
		$this->setCss("default/style");
		$this->setBlock("arksystems/cashier");
	}

	public function kitchenAction() {
		$this->setPageTitle("Kitchen Display");
		$this->setCss("default/style");
		$this->setBlock("arksystems/kitchen");
	}

	public function setup() {
		$this->setCss("arksystems/style");
		$this->setJs("arksystems/script");
	}
}