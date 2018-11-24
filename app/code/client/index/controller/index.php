<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Index_Controller_Index extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->middleware("autologin");
		$this->setPageTitle('Linkmedia');
		$this->setBlock("index/index");
	}
}