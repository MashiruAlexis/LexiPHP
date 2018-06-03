<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_lexi_up extends Console_Controller_Core {

	public $description = "Turn the system back on!";

	public function handler() {
		$config = Core::getSingleton("system/config")->getConfig("maintenanceFlagFile");
		if( file_exists($config) ) {
			@unlink($config);
			if( file_exists($config) ) {
				$this->error("Error: something went wrong while trying to turn the system back on!");
				return false;
			}else{
				$this->success("Were back!");
				return true;
			}
		}
		$this->info("Were alreay up and running!");
		return;
	}
}