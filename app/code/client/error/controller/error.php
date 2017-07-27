<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Error_Controller_Error extends Frontend_Controller_Action {

	/**
	 *	Error Type
	 */
	public $type = 404;

	/**
	 *	Error Message
	 */
	public $message = "Sorry";

	/**
	 *	Error Title
	 */
	public $titlepage = "Errors";

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
		$this->setPageTitle($this->titlepage);
		$this->setCss("error/error-style");
		$this->setBlock("error/body");
		$this->render();
		exit();
	}


 	public function __call($method, $params = null) {

		$type = substr($method, 0, 3);
		$property = lcfirst(substr($method, 3));

		
		try {
			
			if($type == "set") {
				$this->$property = $params[0];
				return $this;
			}elseif($type == "get") {
				return $this->$property;
			}else{
				throw new Exception("Error Processing Request", 1);
			}
		} catch (Exception $e) {
			Core::log($e);
		}
	}
}