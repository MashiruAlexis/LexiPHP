<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Account_Add extends Console_Controller_Core {

	protected $description = "Add new User.";

	/**
	 *	Default console handler
	 */
	public function handler() {
		$this->info( $this->args );
	}
} 