<?php
/**
 *
 * MIT License
 *
 * Copyright (c) 2016 Ramon Alexis Celis
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