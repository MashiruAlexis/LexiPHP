<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Index_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Jad Systems");
		$this->setBlock("index/main");
	}

	public function setup() {
		$this->setCss("index/style");
	}
}