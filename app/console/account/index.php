<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Account_Index extends Console_Controller_Core {

	public $description = "All account console will be called here.";

	public function help() {

	}

	public function handler() {
		if( empty($this->getArgs()) ) {
			$this->error("   Error: no argument was passed.");
		}
	}
}