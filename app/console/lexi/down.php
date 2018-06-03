<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_lexi_down extends Console_Controller_Core {

	public $description = "Let's shutdown everything at the moment.";

	public function handler( $args ) {
		if( empty($args) ) {
			$args[] = 'false';
		}
		$file = Core::getSingleton("system/config")->getConfig("maintenanceFlagFile");
		if( file_exists($file) ) {
			$this->info("Were already down, we dont need to go deeper :)");
			return false;
		}
		@file_put_contents($file, $args[0]);
		if( file_exists($file) ) {
			$this->success("This site is now under maintenance.");
			return true;
		}
		return false;
	}
}