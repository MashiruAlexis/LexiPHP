<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Drive extends Frontend_Controller_Action {

	public function __construct() {
		Core::middleware("auth");
	}

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Drive');
		$this->setBlock("dashboard/drive");
	}
}