<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Reset_Controller_Index extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Reset')s;
		Core::getSingleton("system/session")->destroy();
		$this->_redirect( Core::getBaseUrls() );
	}
}