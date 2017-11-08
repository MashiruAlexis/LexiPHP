<?php

Class Evaluation_Controller_Process extends Frontend_Controller_Action {

	public function submitAction() {
		$session = Core::getSingleton("system/session");
		$request = Core::getSingleton("url/request")->getRequest();
		$next = Core::getBaseUrl() . "evaluation";
		$evalData = $session->get("evaluation");
		Core::log( $evalData );
		Core::log($request);

		if(! $evalData["access"] ) {
			$session->add("alert",[
				"type" => "error",
				"message" => "Invalid Access."
			]);
			$this->_redirect($next);
			return;
		}


	}

	public function evaluatorInfoAction () {
		$session = Core::getSingleton("system/session");
		$request = Core::getSingleton("url/request")->getRequest();
		$next = Core::getBaseUrl() . "evaluation";

		if( empty($request["fullname"]) or empty($request["position"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Please fill all the fields."
			]);
			$this->_redirect($next);
			return;
		}

		$session->add("evaluation", [
			"name" => $request["fullname"],
			"position" => $request["position"],
			"hasEvaluator" => true,
			"access" => true
		]);

		$this->_redirect($next);
	}
}