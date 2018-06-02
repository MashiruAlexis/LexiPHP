<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Controller_Core {

	const STATUS_ERROR 		= "red";
	const STATUS_WARNING 	= "yellow";
	const STATUS_INFO 		= "cyan";
	const STATUS_SUCCESS 	= "green";

	/**
	 *	Default Console App
	 */
	public $app = "lexi";

	/**
	 *	Default Console Controller
	 */
	public $controller = "index";

	/**
	 *	Default Console Method
	 */
	public $method = "handler";

	/**
	 *	Args
	 */
	public $args;

	/**
	 *	Run lexi cli
	 */
	public function run() {
		// lets test if request was made from command
		if(! $this->is_cli( $this->args[0] ) ) {
			$this->error("Error: this console command will only run on CLI");
			return false;
		}

		$this->args[1] = isset($this->args[1]) ? $this->args[1] : $this->getApp();

		if ( strpos($this->args[1], ':') !== false ) {
		    $args = explode(':', $this->args[1]);
		    $this->setApp($args[0]);
		    $this->setController($args[1]);
		}else{
			$this->setApp( $this->args[1] );
		}
		
		unset($this->args[0]);
		unset($this->args[1]);
		unset($args); $args = [];

		$this->setController( $this->getApp() . "/" . $this->getController() );
		
		if( $this->controllerExist( $this->getController() ) ) {
			$this->setController( Core::getConsole($this->getController()) );
		}else{
			if( $this->controllerExist( $this->getApp() . "/index" ) ) {
				$this->setController( $this->getApp() . "/index" );
			}
			$this->error("Error: unknown console command.");
			return false;
		}

		if( method_exists($this->getController(), $this->getMethod()) ) {
			if(! empty($this->args) ) {
				foreach( $this->args as $arg ) {
					$args[] = $arg;
				}
			}
			call_user_func_array([$this->getController(), $this->getMethod()], [$args]);
		}
	}

	/**
	 *	Extract Variable Data
	 *	@param array $var
	 *	@return array $data
	 */
	public function extract( $vars  = [] ) {
		
		if( count($vars) < 1 ) {
			return false;
		}

		foreach( $vars as $var ) {
			$rs = explode("=", $var);
			$data[$rs[0]] = $rs[1];
		}

		return isset($data) ? $data : false;
	}

	/**
	 *	Test to see if a request was made from the command line.
	 */
	public function is_cli( $arg = false ) {
		$config = Core::getSingleton("system/config")->getConfig();
		// if( $arg ) {
		// 	if( $config["CliScript"] != $arg ) {
		// 		return false;
		// 	}
		// }
		return (PHP_SAPI === 'cli' OR defined('STDIN'));
	}

	/**
	 *	Log
	 *	@param string $str
	 *	@param bool $mode
	 *	@return
	 */
	public function log( $str = "", $mode = false, $modebg = null ) {
		return $this->output( $str, $mode, $modebg );
	}

	/**
	 *	Output Error on terminal
	 *	@param string $msg
	 *	@return
	 */
	public function error( $msg ) {
		$this->output( $msg, "error" );
		return;
	}

	/**
	 *	Output Information on terminal
	 *	@param string $msg
	 *	@return
	 */
	public function info( $msg ) {
		$this->output( $msg, "info" );
		return;
	}

	/**
	 *	Output Warming on terminal
	 *	@param string $msg
	 *	@return
	 */
	public function warning( $msg ) {
		$this->output( $msg, "warning" );
		return;
	}

	/**
	 *	Output Success on terminal
	 *	@param string $msg
	 *	@return
	 */
	public function success( $msg ) {
		$this->output( $msg, "success" );
		return;
	}

	/**
	 *	Output colored on terminal
	 *	@param string $str
	 *	@param string $mode
	 *	@return
	 */
	public function output( $str, $mode = false, $modebg = null ) {
		$color = Core::getSingleton("console/color");

		if( is_array($str) or is_object($str) ) {
			print_r($str);
			return;
		}

		if( $mode == "error") {
			echo $color->getColoredString( $str, self::STATUS_ERROR ) . "\n";
			return;
		}

		if( $mode == "info" ) {
			echo $color->getColoredString( $str, self::STATUS_INFO ) . "\n";
			return;
		}

		if( $mode == "warning" ) {
			echo $color->getColoredString( $str, self::STATUS_WARNING ) . "\n";
			return;
		}

		if( $mode == "success" ) {
			echo $color->getColoredString( $str, self::STATUS_SUCCESS ) . "\n";
			return;
		}
		echo $str . "\n";
		return;
	}

	/**
	 *	Alert
	 *	@param string $type
	 *	@param string $msg
	 *	@return
	 */
	public function alert( $type, $msg = false ) {
		$color = Core::getSingleton("console/color");
		switch ($type) {
			case 'error':
				echo "\n" . $color->getColoredString("Error: " . $msg, self::STATUS_ERROR) . "\n";
				break;

			case 'warning':
				echo "\n" . $color->getColoredString("Warning: " . $msg, self::STATUS_WARNING) . "\n";
				break;

			case 'info':
				echo "\n" . $color->getColoredString("Information: " . $msg, self::STATUS_INFO) . "\n";
				break;

			case 'success':
				echo "\n" . $color->getColoredString("Success: " . $msg, self::STATUS_SUCCESS) . "\n";
				break;
			
			default:
				$this->output($msg);
				break;
		}
	}

	/**
	 *	Add color to string
	 *	@param string $str
	 *	@param string $color
	 *	@return string $str
	 */
	public function color( $str, $color, $modebg = null ) {
		$strColor = Core::getSingleton("console/color");
		return $strColor->getColoredString( $str, $color, $modebg );
	}

	/**
	 *	Check if controller exist
	 *	@param string $cont
	 *	@return bool $result
	 */
	public function controllerExist( $cont ) {
		$cont = explode("/", $cont);
		$consoleControllerPath = BP . DS . "app" . DS . "console" . DS . $cont[0] . DS . $cont[1] . ".php";
		if( file_exists($consoleControllerPath) ) {
			return true;
		}
		return false;
	}

	/**
	 *	Set command
	 *	@var string $cmd
	 *	@return
	 */
	public function setCommand( $cmd ) {
		$this->cmd = $cmd;
		return;
	}

	/**
	 *	Get Command
	 *	@return string $cmd
	 */
	public function getCommand() {
		return $this->cmd;
	}

	/**
	 *	Set the arguments
	 *	@var array $args
	 *	@return
	 */
	public function setArgs( $args ) {
		$this->args = $args;
	}

	/**
	 *	Get the arguments
	 *	@return array $this->args
	 */
	public function getArgs() {
		return $this->args;
	}

	/**
	 *	Set Console App
	 *	@param string $app
	 */
	public function setApp( $app ) {
		$this->app = $app;
	}

	/**
	 *	Get Console App
	 *	@return string $this->app
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 *	Set Console Controller
	 *	@param string $cont
	 *	@return
	 */
	public function setController( $cont ) {
		$this->controller = $cont;
	}

	/**
	 *	Get Controller
	 *	@return string $this->controller
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 *	Set Console Method
	 *	@param string $method
	 *	@return
	 */
	public function setMethod( $method ) {
		$this->method = $method;
	}

	/**
	 *	Get Console Method
	 *	@return string $this->method
	 */
	public function getMethod() {
		return $this->method;
	}

	public function getConsolePath() {
		return Core::getConsole("lexi/index")->getConsolePath();
	}
}