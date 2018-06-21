<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Index extends Frontend_Controller_Action {

	public function __construct() {
		Core::middleware('auth');
	}

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Dashboard');
		$this->setBlock("dashboard/main");
	}
}