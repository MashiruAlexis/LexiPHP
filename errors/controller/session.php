<?php
namespace Errors\Controller;

Class Session {

	/**
	 *	Start the session if not started yet.
	 */
	public static function start() {
		if(! self::isRunning() ) {
			session_start();
			return true;
		}
		return false;
	}

	/**
	 *	check if session is running
	 */
	public static function isRunning() {
		if ( session_id() == '' ) {
			return false;
		}
		return true;
	}

	/**
	 *	Remove and Destroy Sessions
	 */
	public static function destroy() {
		$_SESSION = [];
		session_unset(session_id());
	}

}