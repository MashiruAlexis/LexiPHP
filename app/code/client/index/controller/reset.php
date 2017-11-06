<?php

Class Index_Controller_Reset extends Frontend_Controller_Action {

	public function indexAction() {
		$session = Core::getSingleton("system/session");
		$session->destroy();
		Core::log("Session was successfully reseted.");
	}
}