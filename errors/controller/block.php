<?php
namespace Errors\Controller;

use Errors\Controller\Logger;

Class Block {

	// list of the blocks to be rendered
	public $blocks = [];

	// path to blocks
	public $pathToBlock;

	// error type
	public $errorType;

	// stored error
	protected $errors;

	/**
	 *	Class Constructor
	 */
	public function __construct() {
		# set the path to blocks
		$this->pathToBlock = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "view" . DIRECTORY_SEPARATOR;
	}

	/**
	 *	add new blocks the will be rendered later.
	 *	@param string $name
	 *	@return obj $this
	 */
	public function setBlock( $name ) {
		$this->blocks[] = $name;
		return $this;
	}

	/**
	 * get needed blocks
	 */
	public function getBlock() {
		return $this->blocks;
	}

	/**
	 *	Render all the blocks
	 */
	public function render() {
		$path = $this->pathToBlock . "main.phtml";
		if( file_exists($path) ) {
			include $path;
		}
		return true;
	}

	/**
	 *	get child block
	 *	@param string $name
	 *	@return obj $this
	 */
	public function getChildBlock( $name ) {
		$path = $this->pathToBlock . "blocks" . DIRECTORY_SEPARATOR . $name . ".phtml";
		if( file_exists($path) ) {
			return include $path;
		}
		return true;
	}

	/**
	 *	Set the error type
	 *	@param string $type
	 *	@return obj $this
	 */
	public function setErrorType( $type ) {
		$this->errorType = $type;
		return $this;
	}

	/**
	 *	pass the error to block
	 *	@param string $error
	 *	@return void
	 */
	public function setError( $error ) {
		$this->errors = $error;
		return;
	}
}