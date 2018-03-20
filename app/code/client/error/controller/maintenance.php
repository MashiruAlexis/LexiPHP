<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Error_Controller_Maintenance extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Maintenance');
		$this->setBlock('error/maintenance');
		$this->setCss("error/error-style");
		$this->render();
		exit();
		// code here
	}
}