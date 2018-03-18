<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_lexi_down extends Console_Controller_Core {

	public $description = "Let's shutdown everything at the moment.";

	public function handler() {
		// code here
		$this->success("Yey! success.");
		$this->info("Path: " . dirname(__FILE__));
		return;
	}
}