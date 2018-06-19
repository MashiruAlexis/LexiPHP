<?php
namespace Errors\Controller;

use Errors\Controller\Config;
use Errors\Controller\Block;
use Errors\Controller\Logger;

/**
 *	Modify PHP defualt error handler
 */
Class Handler {

	/**
	 *	Error Types
	 */
	protected $errorTypes = [
		"400" => [
			"title" => "Bad Request",
			"message" => "The server cannot process the request due to something that is perceived to be a client error."
		],
		"401" => [
			"title" => "Unauthorized",
			"message" => "The requested resource requires an authentication."
		],
		"403" => [
			"title" => "Access Denied",
			"message" => "The requested resource requires an authentication."
		],
		"404" => [
			"title" => "Resource not found",
			"message" => "The requested resource could not be found but may be available again in the future."
		],
		"500" => [
			"title" => "Webservice currently unavailable",
			"message" => "An unexpected condition was encountered. Our service team has been dispatched to bring it back online."
		],
		"501" => [
			"title" => "Not Implemented",
			"message" => "The Webserver cannot recognize the request method."
		],
		"502" => [
			"title" => "Webservice currently unavailable",
			"message" => "We've got some trouble with our backend upstream cluster. Our service team has been dispatched to bring it back online."
		],
		"503" => [
			"title" => "Webservice currently unavailable",
			"message" => "We've got some trouble with our backend upstream cluster. Our service team has been dispatched to bring it back online."
		],
		"520" => [
			"title" => "Origin Error - Unknown Host",
			"message" => "The requested hostname is not routed. Use only hostnames to access resources."
		],
		"521" => [
			"title" => "Webservice currently unavailable",
			"message" => "We've got some trouble with our backend upstream cluster. Our service team has been dispatched to bring it back online."
		]
	];

	// path to blocks
	private $blockPath;

	// let set the handler
	public function __construct() {
		$this->blockPath = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "view" . DIRECTORY_SEPARATOR;
		set_error_handler([$this, 'errorHandler']);
		set_exception_handler([$this, 'exceptionHandler']);
		register_shutdown_function([$this, 'shutdownHandler']);
	}

	/**
	 *	Render the generated error
	 */
	public function render() {
		// get the main block
		echo $this->blockPath . 'main.phtml';
	}

	/**
	 *	Get Current URI
	 */
	public function getUri() {
		return $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}

	/**
	 *	Let set the error endpoints
	 */

	/**
	 *	Error endpoint
	 *	@param int $serverity
	 *	@param string $message
	 *	@param string $filepath
	 *	@param int $line
	 *	@return void
	 */	
	public function errorHandler( $error_level, $error_message, $error_file, $error_line, $error_context ) {
		$block = new Block;
		$block->setErrorType("error");
		$block->setError([
			"error_level" => $error_level,
			"error_message" => $error_message,
			"error_file" => $error_file,
			"error_line" => $error_line,
			"error_context" => $error_context
		]);
		$block->setBlock("main");
		$block->render();
		return;
	}

	/**
	 *	Exception Handler
	 *	@param obj $e
	 *	@return void
	 */
	public function exceptionHandler( $e ) {
		$block = new Block;
		$block->setErrorType("exception");
		$block->setError($e);
		$block->setBlock("main");
		$block->render();
		return;
	}

	/**
	 *	Shutdown handler
	 *	@param func error_get_last()
	 *	@return void
	 */
	public function shutdownHandler() {
		if(! empty(error_get_last()) ) {
			$error = error_get_last();
			$this->errorHandler( $error['type'], $error['message'], $error['file'], $error['line'], $error['context'] );
			return;
		}
	}

	/**
	 *	Logger
	 *	@param string $str
	 *	@return void
	 */
	public static function log( $str ) {
		echo "<pre>";
		print_r($str);
		echo "</pre>";
		return;
	}

	/**
	 *	Get the error types
	 */
	public function getErrorTypes() {
		return $this->errorTypes;
	}

	/**
	 * Custom setter and getter
	 *	@param string $medthod
	 *	@param string $params
	 *	@return void
	 */
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
	 *	Let's boot this!
	 */
	public static function boot() {
		return new Handler;
	}
}