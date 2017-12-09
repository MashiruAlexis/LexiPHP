<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Lexi_Index extends Console_Controller_Core {

	public $description = "this is the best framework.";

	public function handler( $args ) {
		$this->getHelp();
	}

	/**
	 *	Get Help for this command
	 */
	public function getHelp() {
		$kernel = Core::getSingleton("system/kernel");
		$config = $kernel->getConfig("system");

		$this->log( $this->color( $config["AppName"], "green" ) . " version " . $this->color( $config["Version"], "purple", "light_gray" ) );
		$this->log();
		$this->log( $this->color( "Usage:", "yellow" ) );
		$this->log( "   command [options] [arguments]" );
		$this->log();
		$this->log("testawd \t\t test");
	}
}