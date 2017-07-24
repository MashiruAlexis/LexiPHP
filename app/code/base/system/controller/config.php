<?php
/**
 *
 * MIT License
 *
 * Copyright (c) 2016 Ramon Alexis Celis
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