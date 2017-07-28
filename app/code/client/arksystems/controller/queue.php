<?php

Class Arksystems_Controller_Queue extends Frontend_Controller_Action {

	const STATUS_PREPARING 		= "preparing";
	const STATUS_READY 			= "ready";
	const STATUS_COMPLETED  	= "completed";

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
			// Core::log("Queue: " . $request["queueNumber"] );
			$queue = Core::getModel("arksystems/queue");
			if( $queue->where("qnumber", $request["queueNumber"])->exist() ) {
				$session->add("alert", [
						"type" => "error",
						"message" => "Queue number already exist, please check the number and enter it again."
					]);
				$this->_redirect(Core::getBaseUrl() . "arksystems");
			}
			$res = $queue->insert([
					"qnumber" => $request["queueNumber"],
					"status" => self::STATUS_PREPARING
				]);
			if( $res ) {
				$session->add("alert", [
						"type" => "success",
						"message" => "Queue number was successfully added."
					]);
			}else{
				$session->add("alert", [
						"type" => "error",
						"message" => "Something went wrong. please contact IT professional to fix this issue."
					]);
			}
			$this->_redirect( Core::getBaseUrl() . "arksystems");
		}else{
			$session->add("alert",[
				"type" => "warning",
				"message" => "Unidentified request. Application has been automatically terminated."
				]);
			$this->_redirect(Core::getBaseUrl() . "arksystems");
		}
	}
}