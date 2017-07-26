<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Xmlreader {

	/**
	 *	Xml path
	 */
	public $path;

	public function __construct() {
		$this->path = dirname(__FILE__) . DS;
	}

	/**
	 *	Read XML	
	 */
	public function read($varXml = null) {
		$xmlPath = $this->path . $varXml . ".xml";
		if(file_exists($xmlPath)) {
			return simplexml_load_file($xmlPath);
		}else{
			throw new Exception("Config file not found!", 1);
		}
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