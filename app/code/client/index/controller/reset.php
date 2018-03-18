<?php

Class Index_Controller_Reset extends Frontend_Controller_Action {

	public function indexAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		if( isset($request["dump"]) ) {
			Core::log("Session:");
			Core::log( $_SESSION );
		}else{
			Core::log("Session: before");
			Core::log( $_SESSION );
			Core::getSingleton("system/session")->destroy();
			Core::log("Session: after");
			Core::log($_SESSION);
			Core::log("Session was successfully reseted.");
		}
	}
}