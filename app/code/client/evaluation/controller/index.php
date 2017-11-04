<?php

Class Evaluation_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Evaluation");
		$this->setBlock("evaluation/evaluate");
	}

	/**
	 *	Validate Code
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

		if( $evaluationDb->where("code", $request["code"])->where("status", $evaluationDb::STATUS_ON_GOING)->exist() ) {
			$session->add("evaluation", true);

		}

		$this->_redirect($next);
		return;
	}

	public function setup() {
		$this->setCss("default/style");
	}
}