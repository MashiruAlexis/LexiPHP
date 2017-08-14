<?php

Class Autologin {

	public function __construct() {
		if( Core::getSingleton("account/auth")->isAuth() ) {
			header("location:" . Core::getBaseUrl() . "dashboard");
		}
	}
}