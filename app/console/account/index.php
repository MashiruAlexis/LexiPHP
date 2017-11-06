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

			if( $arg == "migrate" ) {

				// Account Type
				Core::getModel("account/accounttype")->prePopulateAccountType();
				$this->success("Account Type was Pre Populated.");

				// Account
				Core::getModel("account/account")->preAccount();
				$this->success("Account was Pre Populated.");
			}

			if( $arg == "migrate:account" ) {

				// Account
				Core::getModel("account/account")->preAccount();
				$this->success("Account was Pre Populated.");
			}
		}
	}
}