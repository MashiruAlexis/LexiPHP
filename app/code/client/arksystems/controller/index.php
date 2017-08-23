<?php

Class Arksystems_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Menu");
		$this->setCss("default/style");
		$this->setCss("arksystems/sweetalert");
		$this->setJs("arksystems/sweetalert.min");
		$this->setBlock("arksystems/menu");
	}

	public function cashierAction() {
		$this->setPageTitle("Enter Number");
		$this->setCss("default/style");
		$this->setCss("arksystems/keyboard");
		$this->setJs("arksystems/keyboard");
		$this->setBlock("arksystems/cashier");
	}

	public function kitchenAction() {
		$this->setPageTitle("Kitchen Display");
		$this->setCss("default/style");
		$this->setCss("arksystems/sweetalert");
		$this->setJs("arksystems/sweetalert.min");
		$this->setJs("arksystems/queueautoupdate");
		$this->setBlock("arksystems/kitchen");
	}

	public function sinageAction() {
		$this->setPageTitle("Sinage");
		$this->setBlock("arksystems/sinage");
	}

	public function setup() {
		$this->setCss("arksystems/style");
		$this->setJs("arksystems/script");
	}
}