<?php

Class Arksystems_Controller_Queue extends Frontend_Controller_Action {

	const STATUS_PREPARING 		= "preparing";
	const STATUS_READY 			= "ready";
	const STATUS_COMPLETED  	= "completed";

	public function addToCompleteAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$queue = Core::getModel("arksystems/queue");
		if( isset($request["qnum"]) ) {
			if( $queue->where("qnumber", $request["qnum"])->where("status", self::STATUS_READY)->exist() ){
				$queue->where("qnumber", $request["qnum"])->where("status", self::STATUS_READY)->update(["status" => self::STATUS_COMPLETED]);
				echo json_encode(["status" => "success", "message" => "Queue Number was successfully add to collection."]);
				exit();
			}else{
				echo json_encode(["status" => "error", "message" => "The number does not exist, please try again."]);
				exit();
			}
		}else{
			echo json_encode(["status" => "error", "Request number must setted."]);
			exit();
		}
		exit();
	}

	public function addToCollectionAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$queue = Core::getModel("arksystems/queue");
		if( isset($request["qnum"]) ) {
			$res = $queue->where("qnumber", $request["qnum"])->where("status", self::STATUS_PREPARING)->exist();
			if(! $res ) {
				echo json_encode(["status" => "error", "message" => "The number does not exist, please try again."]);
				exit();
			}
			$queue->where("qnumber", $request["qnum"])->update(["status" => self::STATUS_READY]);
			echo json_encode(["status" => "success"]);
			exit();
		}
		exit();
	}

	public function getQueueListAction() {
		$queue = Core::getModel("arksystems/queue");
		foreach( $queue->where("status", self::STATUS_PREPARING)->get() as $queueNumer ) {
			$ques[self::STATUS_PREPARING][] = $queueNumer->qnumber;
		}

		foreach( $queue->where("status", self::STATUS_READY)->get() as $queueNumer ) {
			$ques[self::STATUS_READY][] = $queueNumer->qnumber;
		}

		foreach( $queue->where("status", self::STATUS_COMPLETED)->get() as $queueNumer ) {
			$ques[self::STATUS_COMPLETED][] = $queueNumer->qnumber;
		}

		if( isset($ques) and ! empty($ques) ) {
			echo json_encode($ques);
		}
		exit();
	}

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