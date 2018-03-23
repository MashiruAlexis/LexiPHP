<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Error_Controller_Error extends Frontend_Controller_Action {

	/**
	 *	Error types [current supported error types]
	 */
	protected $errorTypes = [
		"400" => [
			"title" => "Bad Request",
			"message" => "The server cannot process the request due to something that is perceived to be a client error."
		],
		"401" => [
			"title" => "Unauthorized",
			"message" => "The requested resource requires an authentication."
		],
		"403" => [
			"title" => "Access Denied",
			"message" => "The requested resource requires an authentication."
		],
		"404" => [
			"title" => "Resource not found",
			"message" => "The requested resource could not be found but may be available again in the future."
		],
		"500" => [
			"title" => "Webservice currently unavailable",
			"message" => "An unexpected condition was encountered. Our service team has been dispatched to bring it back online."
		],
		"501" => [
			"title" => "Not Implemented",
			"message" => "The Webserver cannot recognize the request method."
		],
		"502" => [
			"title" => "Webservice currently unavailable",
			"message" => "We've got some trouble with our backend upstream cluster. Our service team has been dispatched to bring it back online."
		],
		"503" => [
			"title" => "Webservice currently unavailable",
			"message" => "We've got some trouble with our backend upstream cluster. Our service team has been dispatched to bring it back online."
		],
		"520" => [
			"title" => "Origin Error - Unknown Host",
			"message" => "The requested hostname is not routed. Use only hostnames to access resources."
		],
		"521" => [
			"title" => "Webservice currently unavailable",
			"message" => "We've got some trouble with our backend upstream cluster. Our service team has been dispatched to bring it back online."
		],
	];

	/**
	 *	Error Type
	 */
	public $type = 404;

	/**
	 *	Error Message
	 */
	public $message = "Sorry";

	/**
	 *	Use this controller as index method
	 */
	public function index() {
		$this->exec();
	}

	/**
	 *	Execute error template and methods
	 */
	public function exec() {
		// $this->setPageTitle("We've got some trouble | " . $this->type . " - " . $this->errorTypes[$this->type]["title"]);
		$this->getBlock("error/HTTP" . $this->type);
		exit();
	}

	/**
	 *	Set error type
	 */
	public function setType( $type ) {
		$this->type = $type;
		return $this;
	}
}