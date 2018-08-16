<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Sales_Controller_Index extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Sales');
		$this->setBlock('sales/main');
	}
}