<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Index extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->middleware("authenticated");
		$this->setPageTitle('Dashboard');
		$this->setBlock("dashboard/main");
	}
}