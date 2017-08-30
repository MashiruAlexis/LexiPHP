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

	public function addToQueueAction() {
		$db = Core::getModel("arksystems/queue");
		$request = Core::getSingleton("url/request")->getRequest();
		if( $request["qnum"] > 999 || empty($request["qnum"]) ) {
			$this->response([
				"error" => "Please review the queue number field and try it again.",
				"status" => "error"
			]);
		}
		$rs = $db->where( "qnumber", $request["qnum"] )->first();
		if(! isset($rs->qid) ) {
			$db->insert([
				"qnumber" => $request["qnum"],
				"status" => self::STATUS_PREPARING
			]);
			$this->response([
				"status" => "success",
				"msg" => "Number added to queue."
			]);
		}
		$this->response([
			"status" => "error",
			"error" => "Number already exist."
		]);
	}

	public function response( $data = array() ) {
		echo json_encode($data);
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
				$this->_redirect(Core::getBaseUrl() . "arksystems/index/cashier");
			}
			$queue = Core::getModel("arksystems/queue");
			if( $queue->where("qnumber", $request["queueNumber"])->exist() ) {
				$session->add("alert", [
						"type" => "error",
						"message" => "Queue number already exist, please check the number and enter it again."
					]);
				$this->_redirect(Core::getBaseUrl() . "arksystems/index/cashier");
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
			$this->_redirect( Core::getBaseUrl() . "arksystems/index/cashier");
		}else{
			$session->add("alert",[
				"type" => "warning",
				"message" => "Unidentified request. Application has been automatically terminated."
				]);
			$this->_redirect(Core::getBaseUrl() . "arksystems/index/cashier");
		}
	}

	/**
	 *	Delete all completed items
	 */
	public function softResetAction() {
		$this->setPageTitle("Soft Reset");
		$db = Core::getModel("arksystems/queue");
		$db->where( "status", self::STATUS_COMPLETED )->delete();
		$this->_redirect(Core::getBaseUrl() . "arksystems");
	}

	/**
	 *	Delete all items
	 */
	public function resetAction() {
		$this->setPageTitle("Reset");
		Core::getModel("arksystems/queue")->delete();
		$this->_redirect(Core::getBaseUrl() . "arksystems");
	}

	/**
	 *	get ads
	 */
	public function getAdsAction() {
		$session = Core::getSingleton("system/session");
		// $session->add("ads", 0);
		$dir = BP . DS . "app" . DS . "code" . DS . "modules" . DS . "elfinder" . DS . "files";
		$images = glob("$dir/*.{jpg,png,bmp,gif,mp4}", GLOB_BRACE);
		if(! isset($_SESSION['ads']) ) {
			$_SESSION["ads"] = 0;
		}
		echo json_encode(["ads" => str_replace("\\", "/", str_replace(BP . DS, Core::getBaseUrl(), $images[$_SESSION['ads']]))]);
		$_SESSION['ads']++;
		if( $_SESSION['ads'] >= count($images) ) {
			$_SESSION['ads'] = 0;
		}
		exit();
	}
}