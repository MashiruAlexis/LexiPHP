<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Config {

	/**
	 *	Config Path
	 */
	protected $configFileName = "system";

	/**
	 *	Configuration
	 */
	private $config;

	/**
	 *	Default Extension
	 */
	private $ext = ".php";

	/**
	 *	Configuration
	 */
	protected $configuration;
	
	public function __construct() {
		$this->config = Core::getSingleton("system/kernel")->getConfig($this->configFileName);
	}

	/**
	 *	Get Config Data
	 *	@return array $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 *	Load configuration
	 */
	public function loadConfigFile() {
		return $this->config;
	}

	/**
	|----------------------------------------
	|	Load the Skin Paths
	|----------------------------------------
	*/
	public function getSkinPath() {
		return $this->config["skin"];
	}

	/**
	|----------------------------------------
	|	Load the baseurl
	|----------------------------------------
	*/
	public function getBaseUrl() {
		return $this->config["baseUrl"];
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