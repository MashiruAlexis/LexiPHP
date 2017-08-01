<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Profile extends Frontend_Controller_Action {

	/**
	 *
	 */
	public function indexAction() {
		$this->setPageTitle("Profile");
		$this->setBlock("account/profile");
	}


}