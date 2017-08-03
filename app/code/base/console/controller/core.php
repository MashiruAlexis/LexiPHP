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
	 *	Command
	 */
	public $cmd;

	/**
	 *	Args
	 */
	public $args;

	/**
	 *	Run lexi cli
	 */
	public function run() {
		$config = Core::getSingleton("system/config")->getConfig();
		if( $config["CliScript"] != $this->args[0] ) {
			$this->alert("error", "this script will only run on terminal.");
			return;
		}
		echo "\n\n";
		$this->cmd = isset($this->args[1]) ? $this->args[1] : $this->alert("error", "No Command was added to parameter.");
		unset($this->args[0]);
		unset($this->args[1]);

		$commands = Core::getSingleton("system/kernel")->getConfig("console");
		$this->output(Core::getConsole("account/add"));
	}

	/**
	 *	Get available commands
	 */
	public function getAvailableCommands() {

	}

	public function output( $str, $mode = false ) {
		$color = Core::getSingleton("command/color");

		if( is_array($str) ) {
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
		$color = Core::getSingleton("command/color");
		// if( $msg ) {
		// 	echo $this->getColoredString($type, );
		// }
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
	 *	@retyrb
	 */
	public function getArgs() {
		return $this->args;
	}

	public function test() {
		$this->alert("error", "Hello World!");
		$this->alert("warning", "Hello World!");
		$this->alert("info", "Hello World!");
		$this->alert("success", "Hello World!");
	}
}