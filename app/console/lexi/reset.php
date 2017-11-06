<?php

Class Console_Lexi_Reset extends Console_Controller_Core {

	public function hander() {
		$session = Core::getSingleton("system/session")->destroy();
		$this->success("Sessions was successfully reseted.");
	}
}