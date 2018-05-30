<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Http_Controller_Request {

	/**
	 *	Silence is Golden
	 */

	public function getRequest() {
		return Core::getSingleton("url/request")->getRequest();
	}
}