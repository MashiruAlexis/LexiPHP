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

	/**
	 *	Submit Evaluation
	 */
	public function submitAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$process = Core::getSingleton("evaluation/process");

		$evaluationDb = Core::getModel("evaluation/evaluation");
		$evaluationDetailsDb = Core::getModel("evaluation/evaluationdetails");
		$evaluatorDb = Core::getModel("evaluation/evaluator");
		$accountDb = Core::getModel("account/account");
		$ratingDb = Core::getModel("evaluation/rating");

		$next = Core::getBaseUrl() . "admin/evaluation/evaluatepeer";


		$auth = $session->get("auth");
		Core::log( $request );
		$code = isset($_SESSION["evaluation"]["code"]) ? $_SESSION["evaluation"]["code"] : false;

		$evaluatorDb->insert([
			"account_id" => $auth->id,
			"type" => $accountDb->getAccountType($auth->id)->type,
			"name" => $auth->fname . " " . $auth->lname,
		]);
		$evaluatorId = $evaluatorDb->lastId;

		$ratingDb->insert([
			"crit_A1" => $request[1],
			"crit_A2" => $request[3],
			"crit_A3" => $request[6],
			"crit_A4" => $request[7],
			"crit_A5" => $request[8],
			"ave_crit1" => $process->getAve([$request[1],$request[3],$request[6],$request[7],$request[8]]),

			"crit_B1" => $request[2],
			"crit_B2" => $request[9],
			"crit_B3" => $request[10],
			"crit_B4" => $request[11],
			"crit_B5" => $request[12],
			"ave_crit2" => $process->getAve([$request[2],$request[9],$request[10],$request[11],$request[12]]),

			"crit_C1" => $request[4],
			"crit_C2" => $request[13],
			"crit_C3" => $request[14],
			"crit_C4" => $request[15],
			"crit_C5" => $request[16],
			"ave_crit3" => $process->getAve([$request[4],$request[13],$request[14],$request[15],$request[16]]),

			"crit_D1" => $request[5],
			"crit_D2" => $request[17],
			"crit_D3" => $request[18],
			"crit_D4" => $request[19],
			"crit_D5" => $request[20],
			"ave_crit4" => $process->getAve([$request[5],$request[17],$request[18],$request[19],$request[20]]),

			"ave_total" => $process->getAve([
				$process->getAve([$request[1],$request[3],$request[6],$request[7],$request[8]]),
				$process->getAve([$request[2],$request[9],$request[10],$request[11],$request[12]]),
				$process->getAve([$request[4],$request[13],$request[14],$request[15],$request[16]]),
				$process->getAve([$request[5],$request[17],$request[18],$request[19],$request[20]]),
			])
		]);

		$ratingId = $ratingDb->lastId;
		$evaluation = $evaluationDb->where("code", $_SESSION["evaluation"]["code"])->first();
		$accountEvaluatedData = $accountDb->getAccountData( $evaluation->account_id );

		Core::log( $evaluation );
		Core::log( $accountEvaluatedData );
		$evaluationDetailsDb->insert([
			"evaluation_id" => $evaluation->id,
			"evaluator_id" => $evaluatorId,
			"rating_id" => $ratingId,
			"school_year" => $accountEvaluatedData->scyear,
			"semester" => $accountEvaluatedData->sem,
			"comments" => $request["comments"]
		]);

		$session->add("alert", [
			"type" => "success",
			"message" => "Faculty was successfully evaluated."
		]); 

		unset($_SESSION["evaluation"]);
		$this->_redirect( $next );
		return;
	}

	/**
	 *	Validate Evaluation Code
	 */
	public function validateCodeAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$next = Core::getBaseUrl() . "admin/evaluation/evaluatepeer";

		if(! $this->validate( $request["evalcode"] ) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Evalution code does not exist."
			]);
			$this->_redirect( $next );
		}

		$_SESSION["evaluation"]["access"] = true;
		$_SESSION["evaluation"]["code"] = $request["evalcode"];
		$_SESSION["evaluation"]["hasEvaluator"] = true;

		$this->_redirect( $next );
		return;
	}

	/**
	 *	Validate Evaluation Code
	 *	@var string $code
	 *	@return bool
	 */
	public function validate( $code ) {
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$rs = $evaluationDb->where("code", $code)->first();
		if( $rs ) {
			return true;
		}
		return false;
	}

	/**
	 *	Generate random alpha numeric characters
	 */
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

	public function getCodeApiAction() {
		echo json_encode(["code" => $this->generateEvaluationCode(6)]);
		exit();
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

	/**
	 *	Get School Year
	 */
	public function getSchoolYear() {
		return [
			"2015-2016",
			"2016-2017",
			"2017-2018",
			"2018-2019",
			"2019-2020",
			"2020-2021",
			"2021-2022"
		];
	}

	/**
	 *	Get Semester
	 */
	public function getSemester() {
		return [
			"1st",
			"2nd"
		];
	}

	/**
	 *	Get Available Course
	 */
	public function getCourse() {
		return [
			"BSIT",
			"BSCE",
			"BSED",
			"BEED",
			"BSHRM",
			"BSBA",
			"BST",
			"BA Com"
		];
	}

	/**
	 *	Get Student Year
	 */
	public function getStudentYear() {
		return [
			"1st",
			"2nd",
			"3rd",
			"4rth"
		];
	}

	public function setup() {
		$this->setJs("default/dashboard");
	}
}