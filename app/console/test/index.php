<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_test_index extends Console_Controller_Core {

	public function handler( $args ) {
		// code here
		$this->log( $args );
		$this->success("Yey! success.");
		$this->info("Path: " . dirname(__FILE__));
		return;
	}
}