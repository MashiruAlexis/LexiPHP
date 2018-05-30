<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Register extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Register');
		$this->setBlock("account/register");
		$this->setCss("default/validetta.min");
		$this->setJs("default/validetta.min");
	}

}