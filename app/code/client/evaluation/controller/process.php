<?php

Class Evaluation_Controller_Process extends Frontend_Controller_Action {

	public function submitAction() {
		$session 		= Core::getSingleton("system/session");
		$request 		= Core::getSingleton("url/request")->getRequest();
		$evalDataDb 	= Core::getModel("evaluation/evaluationdata");
		$evaluationDb 	= Core::getModel("evaluation/evaluation");
		$evaluatorDb 	= Core::getModel("evaluation/evaluator");
		$next 			= Core::getBaseUrl() . "evaluation";
		$evalData 		= $session->get("evaluation");

		if(! $evalData["access"] ) {
			$session->add("alert",[
				"type" => "error",
				"message" => "Invalid Access."
			]);
			$this->_redirect($next);
			return;
		}

		if( isset($request["btnSubmit"]) ) {
			unset($request["btnSubmit"]);
		}

		if( isset($request["submit"]) ) {
			unset($request["submit"]);
		}

		$evaluatorDb->insert([
			"name" => $_SESSION["evaluation"]["name"],
			"position" => $_SESSION["evaluation"]["position"]
		]);

		$evaluatorId = $evaluatorDb->lastId;
		$evaluationId = $evaluationDb->where("code", $_SESSION["evaluation"]["code"])->first()->id;

		foreach( $request as $key => $scale ) {
			$evalDataDb->insert([
				"evaluation_id" => $evaluationId,
				"evaluation_sub_criteria_id" => $key,
				"evaluator_id" => $evaluatorId,
				"scale" => $scale
			]);
		}

		unset($_SESSION["evaluation"]);

		$this->_redirect( $next );
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

		// $session->add("evaluation", [
		// 	"name" => $request["fullname"],
		// 	"position" => $request["position"],
		// 	"hasEvaluator" => true,
		// 	"access" => true
		// ]);

		$_SESSION["evaluation"]["name"] 		= $request["fullname"];
		$_SESSION["evaluation"]["position"] 	= $request["position"];
		$_SESSION["evaluation"]["hasEvaluator"] = true;
		$_SESSION["evaluation"]["access"] 		= true;
		$this->_redirect($next);
	}
}