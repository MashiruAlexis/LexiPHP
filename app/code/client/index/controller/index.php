<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Index_Controller_Index extends Frontend_Controller_Action {
	
	public function __construct() {
		$this->middleware("autologin");
	}

	public function indexAction() {
		$this->setPageTitle("Faculty Evaluation System");
		$this->setBlock("index/main");
	}

	public function setup() {
		$this->setCss("index/style");
	}
}