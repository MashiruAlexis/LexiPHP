<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Http_Controller_Url  extends Url_Controller_Request{

	/**
	 *	Reload current page
	 */
	public function reload() {
		$this->_redirect( $this->getUrl() );
	}

	/**
	 *	Reload
	 *	@param string $url
	 *	@return;
	 */
	public function _redirect( $url ) {
		header("location: " . $url);
		exit("Redirecting...");
	}

	/**
	 *	Get Current Uri
	 */
	public function getUrl() {
		return $_SERVER['REQUEST_URI'];
	}
}