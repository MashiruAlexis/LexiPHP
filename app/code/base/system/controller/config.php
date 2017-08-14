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
		$this->config = Core::getSingleton("system/kernel")->getConfig( $this->configFileName );
	}

	/**
	 *	Get Config Data
	 *	@return array $config
	 */
	public function getConfig( $name = false ) {
		return isset($this->config[$name]) ? $this->config[$name] : $this->config;
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
}