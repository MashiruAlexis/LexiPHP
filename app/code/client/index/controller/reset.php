<?php

Class Index_Controller_Reset extends Frontend_Controller_Action {

	public function indexAction() {
		Core::log("Session: before");
		Core::log( $_SESSION );
		Core::getSingleton("system/session")->destroy();
		Core::log("Session: after");
		Core::log($_SESSION);
		Core::log("Session was successfully reseted.");
	}
}