<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Url_Controller_Request {

	/**
	 *	Request
	 */
	public $request = array();

	/**
	 *	Request Method
	 */
	public $method;

	/**
	 *	Group the request
	 */
	public function genRequest($varReq) {
		# set what method used when making the http request
		$this->method = $_SERVER['REQUEST_METHOD'];

		unset($_GET["request"]);
		if( isset($_GET) ) {
			$this->request = $this->request + $_GET;
		}
		if( isset($_POST) ) {
			$this->request = $this->request + $_POST;
		}

		if(isset($varReq[2])) {
			unset($varReq[2]);
		}
		
		$len = ceil(count($varReq) / 2);
		$key = 3; $val = 4;
		for($x = 0; $x < $len; $x++) {
			if(isset($varReq[$key]) && isset($varReq[$val])) {
				$this->request[$varReq[$key]] = $varReq[$val];
			}
			$key = $key + 2;
			$val = $val + 2;
		}
		return $this;
	}

	/**
	 *	Get Request
	 */
	public function getRequest($varSting = false) {
		if($varSting) {
			if(isset($this->request[$varSting])) {
				return $this->request[$varSting];
			}
		}else{
			return $this->request;
		}
		return false;
	}

	/**
	 *	POST METHOD
	 */
	public function getPost( $data = false ) {
		# validate request method
		if( $this->method !== 'POST' ) {
			Core::dispatchError()->dispatch(400);
		}

		if(! $data ) {
			return $this->request;
		}

		if(isset($this->request[$varSting])) {
			return $this->request[$varSting];
		}

		return false;
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