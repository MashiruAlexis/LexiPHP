<?php

Class Admin_Controller_Evaluation extends Frontend_Controller_Action {

	const STATUS_ON_GOING = "on-going";
	const STATUS_COMPLETED = "completed";
	const STATUS_STOPED = "stoped";

	private static $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
	private static $string;
	private static $length = 6; //default random string length

	public function __construct() {
		// to stop unauthenticated user from access to this page
		$this->middleware("auth");
	}


	public function generateEvaluationCode($length = null) {

		if($length){
			self::$length = $length;
		}

		$characters_length = strlen(self::$characters) - 1;

		for ($i = 0; $i < self::$length; $i++) {
			self::$string .= self::$characters[mt_rand(0, $characters_length)];
		}

		return self::$string;
	}

	public function indexAction() {
		$this->setPageTitle("Evaluation");
		$this->setBlock("admin/evaluation");
	}

	/**
	 *	View
	 */
	public function viewAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");

		$this->setPageTitle("View Evaluation");
		$this->setBlock("admin/viewevaluation");
	}

	/**
	 *	Evaluate
	 */
	public function evaluateAction() {
		$this->setPageTitle("Evaluate");
		$this->setBlock("admin/evaluate");
	}

	/**
	 *	Evaluate Peer Form
	 */
	public function evaluatePeerAction() {
		$this->setPageTitle("Evaluate Peer");
		$this->setBlock("admin/evaluatepeer");
	}

	/**
	 *	Create Evaluation
	 */
	public function createAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$evaluationDb = Core::getModel("admin/evaluation");
		$session = Core::getSingleton("system/session");
		$next = Core::getBaseUrl() . "admin/evaluation";

		if( empty($request["evalcodemodal"]) ) {
			$session->add("alert",[
				"type" => "error",
				"message" => "Invalid evaluation code."
			]);
			$this->_redirect($next);
			return;
		}

		if( empty($request["faculty"]) ) {
			$session->add("alert",[
				"type" => "error",
				"message" => "Please select faculty member to evaluate."
			]);
			$this->_redirect($next);
			return;
		}

		if( $evaluationDb->where("code", $request["evalcodemodal"])->exist() ) {
			$session->add("alert",[
				"type" => "error",
				"message" => "Code has been used already."
			]);
			$this->_redirect($next);
			return;
		}

		$rs = $evaluationDb->insert([
			"account_id" => $request["faculty"],
			"code" => $request["evalcodemodal"],
			"status" => self::STATUS_ON_GOING
		]);

		if( $rs ) {
			$session->add("alert", [
				"type" => "success",
				"message" => "New evaluation has been added."
			]);
			$this->_redirect($next);
			return;
		}
		$session->add("alert",[
			"type" => "error",
			"message" => "Something went wrong while processing evaluation."
		]);
		$this->_redirect($next);
		return;
	}

	/**
	 *	Add Criteria
	 */
	public function addCriteriaAction() {
		$req = Core::getSingleton("url/request")->getRequest();
		$evaluation = Core::getModel("admin/evaluation");
		$criteriaDb = Core::getModel("admin/criteria");
		$alert = Core::getSingleton("system/session");

		unset($req["btnAddCriteria"]);

		if( empty($req["criteria"]) ) {
			$alert->add("alert", [
						"type" => "error",
						"message" => "Some fields were empty."
					]);
			$this->_redirect("/admin/configure?tab=criteria");
			return;
		}

		$criteriaDb->insert( ["label" => $req["criteria"]] );

		if( isset($req["redirect"]) ) {
			$this->_redirect($req["redirect"]);
		}

		$this->_redirect("/admin/configure?tab=criteria");
	}

	/**
	 *	Add Sub Criteria
	 */
	public function addSubCriteriaAction() {
		$req = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$subCriteriaDb = Core::getModel("admin/subcriteria");

		if( isset($req["addSubCriteria"]) ) {
			unset($req["addSubCriteria"]);
		}

		if( empty($req["subcriteria"]) or empty($req["criteria"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Please check all the fields before you submit."
			]);
			$this->_redirect("/admin/configure?tab=subcriteria");
			return;
		}

		$subCriteriaDb->insert([
			"evaluation_criteria_id" => $req["criteria"],
			"question" => $req["subcriteria"]
		]);

		$this->_redirect("/admin/configure?tab=subcriteria");

	}

	public function setup() {
		$this->setJs("default/dashboard");
	}
}