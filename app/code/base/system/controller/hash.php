<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Hash {

	/**
	 *	Hash String
	 *	@var string $str
	 *	@return string $str
	 */
	public function hash( $str ) {
		/**
		 * In this case, we want to increase the default cost for BCRYPT to 12.
		 * Note that we also switched to BCRYPT, which will always be 60 characters.
		 */
		return password_hash($str, PASSWORD_BCRYPT);
	}

	/**
	 *	Verify password
	 *	@var string $pass
	 *	@var string $hashed
	 *	@return bool
	 */
	public function verify( $pass, $hashed ) {
		return password_verify( $pass, $hashed );
	}
}