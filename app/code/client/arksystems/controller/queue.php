<?php

Class Arksystems_Controller_Queue extends Frontend_Controller_Action {

	public function addAction() {
		$this->setPageTitle("Add Queue Number");
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");

		if( isset($request["btnEnter"]) ) {
			unset($request["btnEnter"]);
			if( empty($request["queueNumber"]) ) {
				$session->add("alert",[
						"type" => "error",
						"message" => "Please enter valid number format."
					]);
				$this->_redirect(Core::getBaseUrl() . "arksystems/");
			}
			Core::log("Queue: " . $request["queueNumber"] );
		}else{
			$session->add("alert",
				["type" => "warning",
				"message" => "Unidentified request has been terminated."]
			);
			$this->_redirect(Core::getBaseUrl() . "arksystems");
		}
	}
}