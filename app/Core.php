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
	 *	System Kernel
	 */
	protected $kernel;

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

 	/**
 	 *	Bootsrap
 	 */
 	public function __construct() {
 		// instantiate the kernel
 		$kernel = Core::getSingleton("system/kernel");

 		// get all the request
 		if(isset($_GET['request'])) {
 			$httpurl = Core::getSingleton("Url/Http");
 			// validate url
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
			$kernel->setApp( $this->params[0] );
			unset($this->params[0]);
			if(isset($this->params[1])) {
				$kernel->setController( $this->params[1] ); 
				unset($this->params[1]);
			}

			if(isset($this->params[2])) {
				$kernel->setMethod( $this->params[2] . "Action" );
				unset($this->params[2]);
			}
			$request = Core::getSingleton("url/request");
 			$request->genRequest($this->params);
			$kernel->setController( Core::getSingleton($kernel->getApp() . "/" . $kernel->getController()) );
 		}else{
 			$kernel->setController( Core::getSingleton($kernel->getApp() . "/" . $kernel->getController()) );
 		}
 		if(method_exists($kernel->getController(), $kernel->getMethod())) {
 			call_user_func([$kernel->getController(), "loadThemeResource"]);
 			if( method_exists($kernel->getController(), "setup") ) {
 				call_user_func([$kernel->getController(), "setup"]);
 			}
 			call_user_func_array([$kernel->getController(), $kernel->getMethod()], [$this->params]);
 			// render all the blocks
 			call_user_func([$kernel->getController(), "render"]);
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
 	 *	@var array $path
 	 *	@return
 	 */
 	public static function regPath( $path ) {
 		self::$paths = $path;
 	}

 	/**
 	 *	Get Singleton
 	 *	@var string $controller
 	 *	@return obj $controller
 	 */
 	public static function getSingleton( $controller ) {
 		$controller = explode("/", $controller);
 		$controller = $controller[0] . US . "Controller" . US . $controller[1];

 		if(!array_key_exists($controller, self::$objects)) {
 			self::$objects = self::$objects + array($controller => new $controller);
 		}
 		
 		return self::$objects[$controller];
 	}

 	/**
 	 *	Get new Instace of object
 	 *	@var string $instance
 	 *	@return obj $obj
 	 */
 	public static function getInstance( $instance ) {
 		$obj = explode("/", $instance);
 		$obj = $obj[0] . US . "controller" . US . $obj[1];
 		return new $obj;
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
 	 *	@var string $str
 	 *	@return
 	 */
 	public static function log( $str ) {
 		echo "<pre>";
 		print_r($str);
 		echo "</pre>";
 	}

 	/**
 	 *	Instantiate Core Class
 	 */
 	public static function app() {
 		return new Core;
 	}

 }