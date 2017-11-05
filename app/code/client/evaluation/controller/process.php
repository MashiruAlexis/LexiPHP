<?php

Class Evaluation_Controller_Process extends Frontend_Controller_Action {

	public function submitAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		Core::log($request);
	}
}