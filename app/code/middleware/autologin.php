<?php

Class Autologin {

	/**
	 *	Autologin Users
	 */
	public function __construct() {
		$acct = Core::getModel("account/account");
		if( $acct->isAuth() ) {
			header("location: " . Core::getBaseUrl() . "dashboard");
			exit();
		}
	}

}