<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Index_Controller_Index extends Frontend_Controller_Action {

	

	public function indexAction() {
		$this->setPageTitle("LexiPHP");
		$this->setBlock("index/index");
		$this->setBlock("index/nav");
	}

	/**
	 *	Js, Css and fonts
	 */
	public function setup() {
		$this->setCss("index/index");
		$this->setJs("index/index");
	}
}