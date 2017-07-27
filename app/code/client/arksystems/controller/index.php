<?php

Class Arksystems_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Enter Number");
		$this->setCss("default/style");
		$this->setBlock("arksystems/cashier");
	}

	public function setup() {
		$this->setCss("arksystems/style");
	}
}