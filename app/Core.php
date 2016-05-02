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

define("DS", DIRECTORY_SEPARATOR);
define("PS", PATH_SEPARATOR);
define("BP", dirname(dirname(__FILE__)));
define("US", "_");
define("BS", "/");

$paths = array();
$paths[] = BP . DS . "app" . DS . "code" . DS . "client" . DS;
$paths[] = BP . DS . "app" . DS . "code" . DS . "base" . DS;

Core::regPath($paths);

Class Core {

	/**
	 *	Default App
	 */
	public $app = "index";

	/**
	 *	Default Controller
	 */
	public $controller = "index";

	/**
	 *	Default Method
	 */
	public $method = "index";

	/**
	 *	Params
	 */
	public $params = array();

 	/**
 	 *	Variable Paths
 	 */
 	public static $paths;

 	/**
 	 *	Url
 	 */
 	public static $url = null;

 	public function __construct() {

 		if(isset($_GET['request'])) {
 			$httpurl = Core::getSingleton("Url/Http");
 			$httpurl->setUrl($_GET['request'])->chkUrl();
 			$this->params = $httpurl->getParams();

 		}

 		if(isset($this->params[0])) {
			$this->app = $this->params[0];
			unset($this->params[0]);

			if(isset($this->params[1])) {
				$this->controller = $this->params[1]; 
				unset($this->params[1]);
			}

			if(isset($this->params[2])) {
				$this->method = $this->params[2];
			}
			$request = Core::getSingleton("url/request");
 			$request->genRequest($this->params);
 			Core::log(Core::getSingleton("url/Http"));
			$this->controller = Core::getSingleton($this->app . "/" . $this->controller);
 		}else{
 			$this->controller = Core::getSingleton($this->app . "/" . $this->controller);
 		}

 		if(method_exists($this->controller, $this->method)) {
 			call_user_func_array([$this->controller, $this->method], [$this->params]);
 		}else {
 			Core::dispatchError()->setTitlepage("Page not found")->setMessage("Sorry the page deosnt exist.")->setType(401)->exec();
 		}

 		

 	}

 	/**
 	 *	Register paths
 	 */
 	public static function regPath($varPath) {
 		self::$paths = $varPath;
 	}

 	/**
 	 *	Get Singleton
 	 */
 	public static function getSingleton($varController) {
 		$varController = explode("/", $varController);
 		$varController = $varController[0] . US . "Controller" . US . $varController[1];
 		return new $varController;
 	}

 	/**
 	 *	Error Handler
 	 */
 	public function dispatchError() {
 		return Core::getSingleton("error/error");
 	}

 	/**
 	 *	Print Variables
 	 */
 	public static function log($varLog) {
 		echo "<pre>";
 		print_r($varLog);
 		echo "</pre>";
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

 	/**
 	 *	Instantiate Core Class
 	 */
 	public static function app() {
 		return new Core;
 	}

 }