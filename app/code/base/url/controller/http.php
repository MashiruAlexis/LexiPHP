<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Url_Controller_Http {

	/**
	 * Url	
	 */
	public $url;

	/**
	 *	Params
	 */
	public $params;

	/**
	 * Sanitize Url and	extract args
	 */
	public function chkUrl() {
		$this->params = explode("/",  filter_var(rtrim($this->url, "/"), FILTER_SANITIZE_URL));
		return $this;
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