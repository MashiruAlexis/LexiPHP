<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Kernel {

	/**
	 *	Current Running App
	 */
	private $app = "dashboard";

	/**
	 *	Current Running Controller
	 */
	private $controller = "index";

	/**
	 *	Current Running Method
	 */
	private $method = "indexAction";

	/**
	 *	Config Directory Name
	 */
	const CONFIG_DIR_NAME = "config";

	/**
	 *	Config Default Path
	 */
	protected $configDefaultPath = BP . DS . "app" . DS . "config" . DS;

	/**
	 *	Kernel on boot
	 */
	public function __construct() {

		# Set PHP ERROR HANDLERS
		// set_error_handler( ['Error_Controller_Error', 'errorHandler'] );
		// set_exception_handler( ["Error_Controller_Error", "exceptionHandler"] );
		

		$config = $this->getConfig("system");
		$session = Core::getSingleton("system/session");
	// test
		if( isset($config["app"]) ) {
			$this->setApp( $config["app"] );
		}
// fopen("test", 'r');
		// set debug mode
		// if( $config["debug"] ) {
		// 	error_reporting(E_ALL);
		// 	ini_set('display_errors', 1);
		// }

		Core::getSingleton("error/error");
		// start session
		$session->start();
	}

	/**
	 *	Autoloader
	 */
	public function autoload() {
		$paths = $this->getConfig("autoload");
		foreach( $paths as $mod => $path ) {
			if( file_exists($path) ) {
				include $path;
			}
		}
		return;
	}

	/**
	 *	Get Config
	 *	@return array $config
	 */
	public function getConfig( $config ) {
		$configFilePath = $this->configDefaultPath . $config . ".php";
		if( file_exists($configFilePath) ) {
			return include($configFilePath);
		}
		return false;
	}

	/**
	 *	Set App
	 *	@var string $app
	 *	@return
	 */
	public function setApp( $app ) {
		$this->app = $app;
		return;
	}

	/**
	 *	Get App
	 *	@return string $app
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 *	Set Controller
	 *	@var string $controller
	 *	@return
	 */
	public function setController( $controller ) {
		$this->controller = $controller;
		return;
	}

	/**
	 *	Get Controller
	 *	@return string $controller
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 *	Set Method
	 *	@var string $method
	 *	@return
	 */
	public function setMethod( $method ) {
		$this->method = $method;
		return;
	}

	/**
	 *	Get Method
	 *	@return string $method
	 */
	public function getMethod() {
		return $this->method;
	}
}