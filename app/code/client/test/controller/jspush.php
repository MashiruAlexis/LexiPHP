<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Test_Controller_Jspush extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Push Notification');
		$this->setBlock("test/pushnoti");
	}
}