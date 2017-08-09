<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Auth {

	/**
	 *	Run middleware
	 */
	public function __construct() {
		$auth = Core::getSingleton("account/auth");
		$http = Core::getSingleton("http/url");

		if(! $auth->isAuth() ) {
			$param = http_build_query( ["redirect" => $http->getUrl()] );
			header("location: " . Core::getBaseUrl() . "account/login/?" .$param);
			exit();
		}
	}
}