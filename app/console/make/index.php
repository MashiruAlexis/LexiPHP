<?php


Class Console_Make_Index extends Console_Controller_Core {

	public function handler() {
		$this->info("This command help the user to auto create client and controller.");
		$this->warning("Syntax1: php lexi make:client clientname");
		$this->warning("Syntax2: php lexi make:controller clientname controllername");
		return true;
	}
}