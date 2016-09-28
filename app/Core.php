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

/**
 *	Autoloader
 */
spl_autoload_register(function($class) {
	$class = strtolower(str_replace("_", DIRECTORY_SEPARATOR, $class));
	$paths = Core::$paths;

	foreach($paths as $path) {
		$mainpath = $path . $class . ".php";
		if(file_exists($mainpath)) {
			require_once $mainpath;
			return;
		}
	}

	Core::dispatchError()
 				->setTitlepage("Page not found")
 				->setMessage("Sorry the page deosnt exist.")
 				->setType(401)
 				->exec();
	return;
});

define("BPcore", "app/code/base/");
define("DS", DIRECTORY_SEPARATOR);
define("PS", PATH_SEPARATOR);
define("BP", dirname(dirname(__FILE__)));
define("US", "_");
define("BS", "/");

$paths = array();
$paths[] = BP . DS . "app" . DS . "code" . DS . "client" . DS;
$paths[] = BP . DS . "app" . DS . "code" . DS . "base" . DS;
$paths[] = BP . DS . "lib" . DS . "lexi" . DS;

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
	 *	Objects Instance
	 */
	public static $objects = array();

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
 			
 			$dirs = array_filter(glob(BPcore . '*'), 'is_dir');

 			foreach($dirs as $dir) {
 				if($this->params[0] == str_replace(BPcore, "", $dir)) {
 					Core::dispatchError()
 						->setTitlepage("Access Denied")
 						->setMessage("Sorry this page is reserve for core files only")
 						->setType(401)
 						->exec();
 				}
 			}
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
			$this->controller = Core::getSingleton($this->app . "/" . $this->controller);
 		}else{
 			$this->controller = Core::getSingleton($this->app . "/" . $this->controller);
 		}

 		if(method_exists($this->controller, $this->method)) {
 			call_user_func_array([$this->controller, $this->method], [$this->params]);
 		}else {
 			Core::dispatchError()
 				->setTitlepage("Page not found")
 				->setMessage("Sorry the page deosnt exist.")
 				->setType(401)
 				->exec();
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

 		if(!array_key_exists($varController, self::$objects)) {
 			self::$objects = self::$objects + array($varController => new $varController);
 		}
 		
 		return self::$objects[$varController];
 	}

 	/**
 	 *	Error Handler
 	 */
 	public static function dispatchError() {
 		return Core::getSingleton("error/error");
 	}

 	/**
 	 *	Return the parameters
 	 */
 	public static function getParams() {
 		return self::params;
 	}

 	/**
 	 *	Print Variables
 	 */
 	public static function log($varLog) {
 		echo "<pre>";
 		print_r($varLog);
 		echo "</pre>";
 	}

 	/**
 	 *	Instantiate Core Class
 	 */
 	public static function app() {
 		return new Core;
 	}

 }