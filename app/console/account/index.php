<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Account_Index extends Console_Controller_Core {

	public $description = "All account console will be called here.";

	public $cmd = [
		"dummy"
	];

	public function handler( $args ) {
		foreach( $args as $arg ) {
			if( $arg == "dummy" ) {
				Core::getModel("account/account")->dummy();
				$this->success("Dummy Account Added!");
			}

			if( $arg == "prepop" ) {
				Core::getModel("account/accounttype")->prePopulateAccountType();
				$this->success("Account Pre Populated.");
			}
		}
	}
}