<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Error_Controller_Error extends Frontend_Controller_Action {

	/**
	 *	Error types [current supported error types]
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
		],
		"1001" => [
			"title" => "Fatal Error",
			"message" => "Something went wrong!"
		]
	];

	/**
	 *	Error Type
	 */
	public $type = 404;

	/**
	 *	Error Message
	 */
	public $message = false;

	/**
	 *	Exception Message
	 */
	public $exceptionMessage = false;

	/**
	 *	Error Traces
	 */
	public $traces = [];

	/**
	 *	File Path
	 */
	public $file = false;

	/**
	 *	Error Line
	 */
	public $line = false;

	public function __construct() {
		// include(dirname(__FILE__) . DS . 


		// $loader = BP . DS . 'vendor' . DS . 'autoload.php';
		// if( file_exists($loader) ) {
		// 	require $loader;
		// 	$whoops = new \Whoops\Run;
		// 	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		// 	$whoops->register();
		// }
		
	}

	/**
	 * PHP Exception Handler	
	 */
	public static function exceptionHandler( $e ) {
		Core::getSingleton("error/error")
			->setType(500)
			->setTraces($e->getTrace())
			->setExceptionMessage($e->getMessage())
			->setFile($e->getFile())
			->setLine($e->getLine())
			->new();
			exit();
	}

	/**
	 *	PHP Error Handler
	 */
	public static function errorHandler( $severity, $message, $filepath = null, $line = 0 ) {
		Core::getSingleton("error/error")
			// ->register([
			// 	"severity" => $severity,
			// 	"message" => $message,
			// 	"file" => $filepath,
			// 	"line" => $line
			// ]);
			->setType(500)
			->setExceptionMessage($message)
			->setFile( $filepath )
			->setLine( $line )
			->new();
			return true;
	}

	/**
	 *	PHP Shutdown Function Handler
	 */
	public static function shutdownHandler( ) {
		$last_error = error_get_last();
		Core::log( $last_error );
		exit(1);
	}

	/**
	 *	Register mutiple error
	 *	@param array $error
	 *	@return obj $this
	 */
	public function register( $error ) {
		$this->errors[] = $error;
		return $this;
	}

	/**
	 *	Execute error template and methods
	 */
	public function exec() {
		// $this->setPageTitle("We've got some trouble | " . $this->type . " - " . $this->errorTypes[$this->type]["title"]);
		$this->getBlock("error/HTTP" . $this->type);
		exit();
	}

	/**
	 *	new custom error
	 */
	public function new() {
		// $this->setHeaderStatus($this->type);
		$this->setPageTitle($this->errorTypes[$this->type]["title"]);
		$this->setMessage($this->errorTypes[$this->type]["message"]);
		$this->setCss("error/error-style-v1");
		$this->setBlock("error/new");
		$this->render();
		exit();
	}

	/**
	 * Set HTTP Status Header
	 *
	 * @param	int	the status code
	 * @param	string
	 * @return	void
	 */
	public function setHeaderStatus($code = 200, $text = '') {

		if (empty($code) OR ! is_numeric($code))
		{
			$this->errorHandler(1,'Status codes must be numeric', 500);
		}

		if (empty($text))
		{
			is_int($code) OR $code = (int) $code;
			$stati = array(
				100	=> 'Continue',
				101	=> 'Switching Protocols',
				103	=> 'Early Hints',

				200	=> 'OK',
				201	=> 'Created',
				202	=> 'Accepted',
				203	=> 'Non-Authoritative Information',
				204	=> 'No Content',
				205	=> 'Reset Content',
				206	=> 'Partial Content',
				207	=> 'Multi-Status',

				300	=> 'Multiple Choices',
				301	=> 'Moved Permanently',
				302	=> 'Found',
				303	=> 'See Other',
				304	=> 'Not Modified',
				305	=> 'Use Proxy',
				307	=> 'Temporary Redirect',
				308	=> 'Permanent Redirect',

				400	=> 'Bad Request',
				401	=> 'Unauthorized',
				402	=> 'Payment Required',
				403	=> 'Forbidden',
				404	=> 'Not Found',
				405	=> 'Method Not Allowed',
				406	=> 'Not Acceptable',
				407	=> 'Proxy Authentication Required',
				408	=> 'Request Timeout',
				409	=> 'Conflict',
				410	=> 'Gone',
				411	=> 'Length Required',
				412	=> 'Precondition Failed',
				413	=> 'Request Entity Too Large',
				414	=> 'Request-URI Too Long',
				415	=> 'Unsupported Media Type',
				416	=> 'Requested Range Not Satisfiable',
				417	=> 'Expectation Failed',
				421	=> 'Misdirected Request',
				422	=> 'Unprocessable Entity',
				426	=> 'Upgrade Required',
				428	=> 'Precondition Required',
				429	=> 'Too Many Requests',
				431	=> 'Request Header Fields Too Large',
				451	=> 'Unavailable For Legal Reasons',

				500	=> 'Internal Server Error',
				501	=> 'Not Implemented',
				502	=> 'Bad Gateway',
				503	=> 'Service Unavailable',
				504	=> 'Gateway Timeout',
				505	=> 'HTTP Version Not Supported',
				511	=> 'Network Authentication Required',
			);

			if (isset($stati[$code]))
			{
				$text = $stati[$code];
			}
			else
			{
				$this->errorHandler(1,'No status text available. Please check your status code number or supply your own message text.', 500);
			}
		}

		if (strpos(PHP_SAPI, 'cgi') === 0)
		{
			header('Status: '.$code.' '.$text, TRUE);
			return;
		}

		$server_protocol = (isset($_SERVER['SERVER_PROTOCOL']) && in_array($_SERVER['SERVER_PROTOCOL'], array('HTTP/1.0', 'HTTP/1.1', 'HTTP/2'), TRUE))
			? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
		header($server_protocol.' '.$code.' '.$text, TRUE, $code);
	}

	/**
	 *	Set error type
	 *	@param int $type
	 *	@return obj $this
	 */
	public function setType( $type ) {
		$this->type = $type;
		return $this;
	}

	/**
	 *	Get error type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 *	Get message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 *	Set message
	 *	@param string $msg
	 *	@return obj $this
	 */
	public function setMessage( $msg ) {
		$this->message = $msg;
		return $this;
	}

	public function __call($method, $params = null) {
		$type = substr($method, 0, 3);
		$property = lcfirst(substr($method, 3));
			if($type == "set") {
				$this->$property = $params[0];
				return $this;
			}elseif($type == "get") {
				return $this->$property;
			}else{
				throw new Exception("Error setting method $method", 1);
			}
	}
}