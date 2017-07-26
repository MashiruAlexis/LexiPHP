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
	 *	Start Sessions
	 */
	public function start() {
		if(! $this->isRunning() ) {
			session_start();
			$_SESSION["test"] = md5(rand());
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
		// session_destroy();
	}
}