<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Make_Block extends Console_Controller_Core {

	public $description = 'Creates block in view directory.';

	public function handler( $args = [] ) {
		// code here
		$this->success("Yey! success.");
		$this->info("Path: " . dirname(__FILE__));
		return;
	}
}