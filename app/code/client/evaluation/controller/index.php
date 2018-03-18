	<?php

Class Evaluation_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$session = Core::getSingleton("system/session");
		$this->setPageTitle("Evaluation");

		$evaldata = $session->get("evaluation");

		if(! isset($evaldata["access"]) ) {
			$this->setBlock("evaluation/main");
		}

		if( isset($evaldata["code"]) and ! isset($evaldata["hasEvaluator"])  ) {
			$this->setBlock("evaluation/evaluator");
		}

		if( isset($evaldata["hasEvaluator"]) ) {
			$this->setBlock("evaluation/evaluate");
		}
		
		

	}

	/**
	 *	Cancel Evaluation
	 */
	public function cancelAction() {
		$next = Core::getBaseUrl() . "evaluation";
		$redirect = Core::getSingleton("url/request")->getRequest("redirect");

		if( $redirect ) {
			$next = $redirect;
		}

		if( isset($_SESSION["evaluation"]) ) {
			unset($_SESSION["evaluation"]);
		}
		
		$this->_redirect($next);
	}

	/**
	 *	Validate Code
	 *	@var string $code
	 *	@return bool
	 */
	public function validateAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$evaluationDb = Core::getModel("admin/evaluation");
		$next = Core::getBaseUrl() . "evaluation";

		if( empty($request["code"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Enter the code first."
			]);
			$this->_redirect($next);
		}

		if( $evaluationDb->where("code", $request["code"])->where("status", Admin_Controller_Evaluation::STATUS_ON_GOING)->exist() ) {
			$session->add("evaluation", [
				"access" => true,
				"code" => $request["code"]
			]);
		}else{
			$session->add("alert", [
				"type" => "error",
				"message" => "Invalid evaluation code."
			]);
		}

		$this->_redirect($next);
		return;
	}

	public function setup() {
		$this->setCss("default/style");
	}
}