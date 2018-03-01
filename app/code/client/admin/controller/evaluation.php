<?php

Class Admin_Controller_Evaluation extends Frontend_Controller_Action {

	const STATUS_ON_GOING = "on-going";
	const STATUS_COMPLETED = "completed";
	const STATUS_STOPED = "stopped";

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

		$evaluationDb 			= Core::getModel("evaluation/evaluation");
		$evaluationDetailsDb 	= Core::getModel("evaluation/evaluationdetails");
		$evaluatorDb 			= Core::getModel("evaluation/evaluator");
		$accountDb 				= Core::getModel("account/account");
		$ratingDb 				= Core::getModel("evaluation/rating");

		$next = Core::getBaseUrl() . "admin/evaluation/evaluatepeer";

		if( isset($_SESSION["evaluation"]["redirect"]) ) {
			$next = $_SESSION["evaluation"]["redirect"];
		}

		$auth = $session->get("auth");
		$code = isset($_SESSION["evaluation"]["code"]) ? $_SESSION["evaluation"]["code"] : false;

		$evaluatorResData = $evaluatorDb->where("account_id", $auth->id)->first();
		if( empty($evaluatorResData) ) {
			$evaluatorDb->insert([
				"account_id" => $auth->id,
				"type" => $accountDb->getAccountType($auth->id)->type,
				"name" => $auth->fname . " " . $auth->lname,
			]);
			$evaluatorId = $evaluatorDb->lastId;
		}else{
			$evaluatorId = $evaluatorResData->id;
		}
		
		

		$ratingDb->insert([
			"crit_A1" => $request[1],
			"crit_A2" => $request[3],
			"crit_A3" => $request[6],
			"crit_A4" => $request[7],
			"crit_A5" => $request[8],
			"ave_crit1" => $process->getAve([$request[1],$request[3],$request[6],$request[7],$request[8]], 1),

			"crit_B1" => $request[2],
			"crit_B2" => $request[9],
			"crit_B3" => $request[10],
			"crit_B4" => $request[11],
			"crit_B5" => $request[12],
			"ave_crit2" => $process->getAve([$request[2],$request[9],$request[10],$request[11],$request[12]], 1),

			"crit_C1" => $request[4],
			"crit_C2" => $request[13],
			"crit_C3" => $request[14],
			"crit_C4" => $request[15],
			"crit_C5" => $request[16],
			"ave_crit3" => $process->getAve([$request[4],$request[13],$request[14],$request[15],$request[16]], 2),

			"crit_D1" => $request[5],
			"crit_D2" => $request[17],
			"crit_D3" => $request[18],
			"crit_D4" => $request[19],
			"crit_D5" => $request[20],
			"ave_crit4" => $process->getAve([$request[5],$request[17],$request[18],$request[19],$request[20]], 2),

			"ave_total" => $process->getAve([
				$process->getAve([$request[1],$request[3],$request[6],$request[7],$request[8]], 1),
				$process->getAve([$request[2],$request[9],$request[10],$request[11],$request[12]], 1),
				$process->getAve([$request[4],$request[13],$request[14],$request[15],$request[16]], 2),
				$process->getAve([$request[5],$request[17],$request[18],$request[19],$request[20]], 2),
			],
			3)
		]);

		$ratingId = $ratingDb->lastId;
		$evaluation = $evaluationDb->where("code", $_SESSION["evaluation"]["code"])->first();
		$accountEvaluatedData = $accountDb->getAccountData( $evaluation->account_id );

		$evaluationDetailsDb->insert([
			"evaluation_id" 	=> $evaluation->id,
			"evaluator_id" 		=> $evaluatorId,
			"rating_id" 		=> $ratingId,
			"school_year" 		=> $accountEvaluatedData->scyear,
			"semester" 			=> $accountEvaluatedData->sem,
			"comments" 			=> $request["comments"]
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
		$request 	= Core::getSingleton("url/request")->getRequest();
		$session 	= Core::getSingleton("system/session");
		$evaluatorDb = Core::getModel("evaluation/evaluator");
		$next 		= Core::getBaseUrl() . "admin/evaluation/evaluatepeer";

		if(! $this->validate( $request["evalcode"] ) ) {
			$session->add("alert", [
				"type" 		=> "error",
				"message" 	=> "Evalution code does not exist."
			]);
			$this->_redirect( $next );
		}

		// bug fix for letting faculty to evaluate themself (LOL hahah)
		$auth = $session->get("auth");
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$codeData = $evaluationDb->where("code", $request["evalcode"])->first();
		if( $codeData->account_id == $auth->id ) {
			$session->add("alert", [
				"type" 		=> "error",
				"message" 	=> "Invalid Action, it is not possible to evaluate your own."
			]);
			$this->_redirect( $next );
			return;
		}
		
		// [new feature] check if the user has already evaluated this code
		if( $evaluatorDb->isDuplicate($request["evalcode"], $auth->id) ) {
			$session->add("alert", [
				"type" 		=> "error",
				"message" 	=> "You have already evaluated this peer."
			]);
			$this->_redirect( $next );
			return;
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
		$rs = $evaluationDb->where("code", $code)->where("status", $evaluationDb::STATUS_ON_GOING)->first();
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
	 *	Evaluate Self
	 */
	public function evaluateSelfAction() {
		$this->setPageTitle("Self Evaluation");
		$this->setBlock("admin/selfevaluation");
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
		$request 		= Core::getSingleton("url/request")->getRequest();
		$evaluationDb 	= Core::getModel("admin/evaluation");
		$session 		= Core::getSingleton("system/session");
		$next 			= Core::getBaseUrl() . "admin/evaluation";

		if( empty($request["evalcodemodal"]) ) {
			$session->add("alert",[
				"type" 		=> "error",
				"message" 	=> "Invalid evaluation code."
			]);
			$this->_redirect($next);
			return;
		}

		if( empty($request["faculty"]) ) {
			$session->add("alert",[
				"type" 		=> "error",
				"message" 	=> "Please select faculty member to evaluate."
			]);
			$this->_redirect($next);
			return;
		}

		if( $evaluationDb->where("code", $request["evalcodemodal"])->exist() ) {
			$session->add("alert",[
				"type" 		=> "error",
				"message" 	=> "Code has been used already."
			]);
			$this->_redirect($next);
			return;
		}

		$rs = $evaluationDb->insert([
			"account_id" 	=> $request["faculty"],
			"code" 			=> $request["evalcodemodal"],
			"status" 		=> self::STATUS_ON_GOING
		]);

		if( $rs ) {
			$session->add("alert", [
				"type" 		=> "success",
				"message" 	=> "New evaluation has been added."
			]);
			$this->_redirect($next);
			return;
		}
		$session->add("alert",[
			"type" 		=> "error",
			"message" 	=> "Something went wrong while processing evaluation."
		]);
		$this->_redirect($next);
		return;
	}

	/**
	 *	Add Criteria
	 */
	public function addCriteriaAction() {
		$req 		= Core::getSingleton("url/request")->getRequest();
		$evaluation = Core::getModel("admin/evaluation");
		$criteriaDb = Core::getModel("admin/criteria");
		$alert 		= Core::getSingleton("system/session");

		unset($req["btnAddCriteria"]);

		if( empty($req["criteria"]) ) {
			$alert->add("alert", [
						"type" => "error",
						"message" => "Some fields were empty."
					]);
			$this->_redirect(Core::getBaseUrl() . "admin/configure?tab=criteria");
			return;
		}

		$criteriaDb->insert( ["label" => $req["criteria"]] );

		if( isset($req["redirect"]) ) {
			$this->_redirect($req["redirect"]);
		}

		$this->_redirect( Core::getBaseUrl() . "admin/configure?tab=criteria");
	}

	/**
	 *	Add Sub Criteria
	 */
	public function addSubCriteriaAction() {
		$req 			= Core::getSingleton("url/request")->getRequest();
		$session 		= Core::getSingleton("system/session");
		$subCriteriaDb 	= Core::getModel("admin/subcriteria");

		if( isset($req["addSubCriteria"]) ) {
			unset($req["addSubCriteria"]);
		}

		if( empty($req["subcriteria"]) or empty($req["criteria"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Please check all the fields before you submit."
			]);
			$this->_redirect(Core::getBaseUrl() . "admin/configure?tab=subcriteria");
			return;
		}

		$subCriteriaDb->insert([
			"evaluation_criteria_id" => $req["criteria"],
			"question" => $req["subcriteria"]
		]);

		$this->_redirect(Core::getBaseUrl() . "admin/configure?tab=subcriteria");

	}

	/**
	 *	Get Evaluation DDS Data
	 *	@var int $id
	 *	@return array $data
	 */
	public function getEvaluationDdsData( $id, $debug = false ) {
		$evalutionDb = Core::getModel("evaluation/evaluation");
		$evaluationDetailsDb = Core::getModel("evaluation/evaluationdetails");
		$ratingDb = Core::getModel("evaluation/rating");


		$evaluation = $evalutionDb->where("id", $id)->first();
		$evaluationDetails = $evaluationDetailsDb->where("evaluation_id", $evaluation->id)->get();
		$total_crit1 = 0;
		$total_crit2 = 0;
		$total_crit3 = 0;
		$total_crit4 = 0;
		$total_ave = 0;
		foreach( $evaluationDetails as $ed ) {
			$rating = $ratingDb->where("id", $ed->rating_id)->first();
			$total_crit1 = 	$total_crit1 + $rating->ave_crit1;
			$total_crit2 = 	$total_crit2 + $rating->ave_crit2;
			$total_crit3 = 	$total_crit3 + $rating->ave_crit3;
			$total_crit4 = 	$total_crit4 + $rating->ave_crit4;
			$total_ave = 	$total_ave + $rating->ave_total;
			
			
			// Core::log( $ed->comments );
		}
		// Core::log( "Commitment: " . round($total_crit1 / count($evaluationDetails)) );
		// Core::log( "Knowledge of Subject: " . round($total_crit2 / count($evaluationDetails)) );
		// Core::log( "Teaching for Independent Learning: " . round($total_crit3 / count($evaluationDetails)) );
		// Core::log( "Management of Learning: " . round($total_crit4 / count($evaluationDetails)) );
		// Core::log( "Overall Rating: " . round($total_ave / count($evaluationDetails)) );
		$data = [
			[
				"label" 	=> "Commitment",
				"rating" 	=> round($total_crit1 / count($evaluationDetails))
			],
			[
				"label" 	=> "Knowledge of Subject",
				"rating" 	=> round($total_crit2 / count($evaluationDetails)),
			],
			[
				"label" 	=> "Teaching for Independent Learning",
				"rating" 	=> round($total_crit3 / count($evaluationDetails))
			],
			[
				"label" 	=> "Management of Learning",
				"rating" 	=> round($total_crit4 / count($evaluationDetails))
			]
		];

		// $data = [
		// 	[
		// 		"label" 	=> "Commitment",
		// 		"rating" 	=> 67
		// 	],
		// 	[
		// 		"label" 	=> "Knowledge of Subject",
		// 		"rating" 	=> 78
		// 	],
		// 	[
		// 		"label" 	=> "Teaching for Independent Learning",
		// 		"rating" 	=> 60
		// 	],
		// 	[
		// 		"label" 	=> "Management of Learning",
		// 		"rating" 	=> 86
		// 	]
		// ];
		// $overallRating = 0;
		// foreach( $data as $dt ) {
		// 	$overallRating = $overallRating + $dt["rating"];
		// }

		$overallRating = $total_ave / count($evaluationDetails);

		
		$decision = $this->makeRecomendation( $data, round($overallRating) );
		$finalData = $data;
		$finalData["recomendation"] = $decision;
		$finalData["overall"] = $overallRating;
		return $finalData;
	}

	public function makeRecomendation( $data = array() , $overall = false ) {
		$decisionDb = Core::getModel("evaluation/decision");
		$recomendationTxt = "Overall performance is ";
		$recomendationTxt .= $this->getInterpretation($overall);

		$highest = 0;
		$lowest1 = 0;
		$lowest2 = 0;
		foreach( $data as $key => $dt ) {
			if( $dt["rating"] > $data[$highest]["rating"] ) {
				$highest = $key;
			}
			if( $dt["rating"] < $data[$lowest1]["rating"] ) {
				$lowest1 = $key;
			}
		}
		foreach( $data as $key => $dt ) {
			if( $key == $lowest1 ) {
				continue;
			}
			if( $dt["rating"] < $data[$lowest2]["rating"] ) {
				$lowest2 = $key;
			}
		}

		if( $this->getInterpretation($data[$highest]["rating"], true)->id < 2 ) {
			$recomendationTxt .= ", keep up the good work.";

			if( $data[$lowest1]["rating"] < 80) {
				$recomendationTxt .= ' how ever the faculty can improve his/her performance by improving his/her ' . $data[$lowest1]["label"];

			}

			if( $data[$lowest2]["rating"] < 80) {
				$recomendationTxt .= ' how ever the faculty can improve his/her performance by improving his/her ' . $data[$lowest2]["label"];
			}
		}

		if( $this->getInterpretation($data[$highest]["rating"], true)->id == 3 or $this->getInterpretation($overall, true)->id >= 3 ) {
			$recomendationTxt .= ' how ever the faculty can improve his/her performance by improving his/her  "'. $data[$lowest1]["label"] .'" and "'. $data[$lowest2]["label"] .'"';
		}

		return $recomendationTxt;
	}

	public function getInterpretation( $rate, $obj = false ) {
		$decisionDb = Core::getModel("evaluation/decision");
		foreach( $decisionDb->get() as $dc ) {
			$range = explode("-", $dc->ranged);
			if( $rate >= $range[0] and $rate <= $range[1] ) {
				if( $obj ) {
					return $dc;
				}
				return $dc->interpretation;
			}
		}
		return false;
	}

	/**
	 *	check if evaluation has evaluator
	 */
	public function hasEvaluator( $evalDetailsId ) {
		$evaluatorDb = Core::getModel("evaluation/evaluator");
		if( $evaluatorDb->where("id", $evalDetailsId)->exist() ) {
			return true;
		}
		return false;
	}

	/**
	 *	Get School Year
	 */
	public function getSchoolYear() {
		return Core::getSingleton("evaluation/evaluation")->getSchoolYear();
	}

	/**
	 *	Get Semester
	 */
	public function getSemester() {
		return Core::getSingleton("evaluation/evaluation")->getSemester();
	}

	/**
	 *	Get Available Course
	 */
	public function getCourse() {
		return Core::getSingleton("evaluation/evaluation")->getCourse();
	}

	/**
	 *	Get Student Year
	 */
	public function getStudentYear() {
		return Core::getSingleton("evaluation/evaluation")->getStudentYear();
	}

	public function setup() {
		$this->setJs("default/dashboard");
		$this->setCss("default/fix");
	}
}