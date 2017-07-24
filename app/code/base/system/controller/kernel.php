<?php
/**
 *
 * MIT License
 *
 * Copyright (c) 2017 Ramon Alexis Celis
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

Class System_Controller_Kernel {

	/**
	 *	Current Running App
	 */
	private $app = "index";

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
		$config = $this->getConfig("system");
		if( $config["debug"] ) {
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
		}
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