<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

spl_autoload_register(["Core", "autoload"]);
define("BPcore", "app/code/base/");
define("DS", DIRECTORY_SEPARATOR);
define("PS", PATH_SEPARATOR);
define("BP", dirname(dirname(__FILE__)));
define("US", "_");
define("BS", "/");

$paths = array();
$paths[] = BP . DS . "app" . DS . "code" . DS . "client" . DS;
$paths[] = BP . DS . "app" . DS . "code" . DS . "base" . DS;

$skinPath = array();
$skinPath[] = BP . DS . "skin" . DS . "client" . DS;
$skinPath[] = BP . DS . "skin" . DS . "base" . DS;

Core::regPath( $paths );
Core::regSkinPath( $skinPath );
Core::getSingleton("system/kernel")->autoload();

Class Core {

	/**
	 *	System Kernel
	 */
	protected $kernel;

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
 	 *	Skin Paths
 	 */
 	public static $skinPath;

 	/**
 	 *	Bootsrap
 	 */
 	public function __construct() {
 		// let's check if we need to activate maintenance mode
		if( file_exists(Core::getSingleton("system/config")->getConfig('maintenanceFlagFile')) ) {
			self::dispatchError()->dispatch('e_maintenance');
		}

		// check if the system booted successfully
		if(! empty(Core::getSingleton("system/boot")->getErrors()) ) {
			foreach( Core::getSingleton("system/boot")->getErrors() as $errs ) {
				Core::log( $errs );
			}
			exit(); // end the system!
		}

 		// instantiate the kernel
 		$kernel = Core::getSingleton("system/kernel");

 		// get all the request
 		if(isset($_GET['request'])) {
 			$httpurl = Core::getSingleton("Url/Http");
 			$httpurl->setUrl($_GET['request'])->chkUrl();
 			$this->params = $httpurl->getParams();
 			
 			$dirs = array_filter(glob(BPcore . '*'), 'is_dir');

 			foreach($dirs as $dir) {
 				if($this->params[0] == str_replace(BPcore, "", $dir)) {
 					self::dispatchError()->dispatch(403);
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
 		}

 		if(! Core::controllerExist([$kernel->getApp(), $kernel->getController()]) ) {
 			self::dispatchError()->dispatch(404);
 		}

 		ob_start();
 		$kernel->setController( Core::getSingleton($kernel->getApp() . "/" . $kernel->getController()) );
 		if(method_exists($kernel->getController(), $kernel->getMethod())) {
 			call_user_func([$kernel->getController(), "loadThemeResource"]);
 			if( method_exists($kernel->getController(), "setup") ) {
 				call_user_func([$kernel->getController(), "setup"]);
 			}
 			call_user_func_array([$kernel->getController(), $kernel->getMethod()], [$this->params]);
 			call_user_func([$kernel->getController(), "render"]);
 		}else {
 			self::dispatchError()->dispatch(404);
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
 	 *	Register Skin Path
 	 *	@var array $path
 	 *	@return
 	 */
 	public static function regSkinPath( $path ) {
 		self::$skinPath = $path;
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
 	 *	Error Handler
 	 */
 	public static function dispatchError() {
 		return new \Errors\Controller\Handler;
 	}

 	/**
 	 *	Get Model
 	 *	@var string $model
 	 *	@return obj $model
 	 */
 	public static function getModel( $model ) {
 		$model = explode("/", $model);
 		$model = $model[0] . "_model_" . $model[1];
 		return new $model;
 	}

 	/**
 	 *	Command 
 	 *	@param string $cmd
 	 *	@return obj $console
 	 */
 	public static function getConsole( $cmd ) {
 		if( strpos($cmd, "/") !== false ) {
 			$cmd = explode("/", $cmd);
 		}else{
 			$cmd = [
 				$cmd,
 				"main"
 			];
 		}
 		$cmd =  "console_" . $cmd[0] . "_" . $cmd[1]; 
 		return new $cmd;
 	}

 	/**
 	 *	Instanciate Migration Object
 	 *	@param string $migration
 	 *	@return obj $migration
 	 */
 	public static function getMigration( $migration ) {
 		$path = BP . DS . "database" . DS . "migration" . DS . $migration . ".php";
 		if(! file_exists($path) ) {
 			return false;
 		}

 		return new $migration;
 	}

 	/**
 	 *	Instanciate Seeder Object
 	 *	@param string $seeder
 	 *	@return obj $seeder
 	 */
 	public static function getSeeder( $seeder ) {
 		$path = BP . DS . "database" . DS . "seeder" . DS . $seeder . ".php";
 		if( file_exists($path) ) {
 			return new $seeder;
 		}
 	}

 	/**
 	 *	set the middleware
 	 *	@param string $name
 	 *	@return obj $middleware
 	 */
 	public static function middleware( $name ) {
 		return new $name;
 	}

 	/**
 	 *	Get Base URL
 	 *	@return string $BaseUrl
 	 */
 	public static function getBaseUrl() {
 		$config = Core::getSingleton("system/kernel")->getConfig("system");
 		return $config["baseUrl"];
 	}

 	/**
 	 *	Check if controller exist
 	 *	@param array $cont
 	 *	@return bool
 	 */
 	public static function controllerExist( $cont ){
 		foreach( Core::$paths as $path ){
 			$contPath = $path . $cont[0] . DS . "controller" . DS . $cont[1] . ".php";
 			if( file_exists($contPath) ) {
 				return true;
 			}
 		}
 		return false;
 	}

 	/**
 	 *	Make a system alert
 	 *	@param array $data
 	 *	@return void
 	 */
 	public static function alert( $data = [] ) {
 		Core::getSingleton('system/session')->add("alert",[
 			"type" => $data['type'],
 			'msg' => $data['msg']
 		]);
 		return true;
 	}

 	/**
 	 *	Print Variables
 	 *	@param string $str
 	 *	@param bool $file
 	 *	@return void
 	 */
 	public static function log( $str, $string = false, $filename = "system.log" ) {
 		$path = BP . DS . "logs" . DS . $filename;
 		$date = Core::getSingleton("system/date");

 		if($string === true && is_writable($path)) {
 			if( $string || is_object($str) || is_array($str) ) {
	 			file_put_contents($path, "====# " . $date->getDate() . " #====" . "\n", FILE_APPEND);
	 			file_put_contents($path, print_r($str, true) . "\n", FILE_APPEND);
	 			return;
	 		}else{
	 			file_put_contents($path, $date->getDate() . ": " . $str . "\n", FILE_APPEND);
	 			return;
	 		}
 		}else{
 			if( $string === true ) {
 				echo "Error: " . $path . " is not writable";
 			}
 		}

 		echo "<pre>";
 		print_r($str);
 		echo "</pre>";
 	}

 	/**
 	 *	Instantiate Core Class
 	 *	@return obj Core
 	 */
 	public static function app() {
 		return new Core;
 	}

 	/**
 	 *	Core Autoloader
 	 */
 	public static function autoload( $class ) {
 		$class = strtolower(str_replace("_", DIRECTORY_SEPARATOR, $class));
		$paths = Core::$paths;
		
		foreach($paths as $path) {
			$mainpath = $path . $class . ".php";
			if(file_exists($mainpath)) {
				return require_once $mainpath;
			}
		}
 	}

 }