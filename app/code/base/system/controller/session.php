<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Session {

	/**
	 *	Add data to session
	 *	@var string $name
	 *	@var string|obj $val
	 *	@return $this
	 */
	public function add( $name, $val = false ) {
		if( $val ) {
			$_SESSION[$name] = $val;
			return $this;
		}
		$_SESSION[] = $name;
		return $this;
	}

	/**
	 *	Get data from session
	 *	@var string $key
	 *	@return string|array|obj $session
	 */
	public function get( $key ) {
		if( isset($_SESSION[$key]) ) {
			return $_SESSION[$key];
		}
		return false;
	}

	/**
	 *	Delete session data from session
	 *	@var string $key
	 *	@var bool
	 */
	public function del( $key ) {
		if( isset($_SESSION[$key]) ) {
			unset($_SESSION[$key]);
			return true;
		}
		return false;
	}

	/**
	 *	Start Sessions
	 */
	public function start() {
		if(! $this->isRunning() ) {
			session_start();
		}
	}

	/**
	 *	check if session is running
	 */
	public function isRunning() {
		if ( session_id() == '' ) {
			return false;
		}
	return true;
	}

	/**
	 *	Remove and Destroy Sessions
	 */
	public function destroy() {
		$_SESSION = [];
		session_unset(session_id());
	}

	// public function __call($method, $params = null) {

	// 	$type = substr($method, 0, 3);
	// 	$property = lcfirst(substr($method, 3));

		
	// 	try {
			
	// 		if($type == "set") {
	// 			$this->{$property} = $params[0];
	// 			return $this;
	// 		}elseif($type == "get") {
	// 			return $this->{$property};
	// 		}else{
	// 			throw new Exception("Error Processing Request", 1);
	// 		}
	// 	} catch (Exception $e) {
	// 		Core::log($e);
	// 	}
	// }
}