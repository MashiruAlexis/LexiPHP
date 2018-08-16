<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Sales_Controller_Contract extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Contract');
	}

	public function newAction() {
		$this->setPageTitle('Contract');
		$this->setBlock('sales/contract');
	}
}