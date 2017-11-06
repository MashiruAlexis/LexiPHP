<?php

Class Console_Reset_Index extends Console_Controller_Core {

	public function handler() {
		$session = Core::getSingleton("system/session")->destroy();
		$this->success("Sessions was successfully reseted.");
	}
}