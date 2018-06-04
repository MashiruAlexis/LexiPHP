<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_db_seed extends Console_Controller_Core {

	public $description = 'New Console Command Created!';

	public function handler( $args = [] ) {
		// code here
		$this->success("Yey! success.");
		$this->info("Path: " . dirname(__FILE__));
		return;
	}
}