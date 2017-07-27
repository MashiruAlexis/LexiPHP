<?php

Class Arksystems_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		Core::log("I was set as default");
	}

	public function setup() {
		$this->setCss("arksystems/style");
	}
}