	<?php

Class Evaluation_Controller_Process extends Frontend_Controller_Action {

	public function submitAction() {
		$session 		= Core::getSingleton("system/session");
		$request 		= Core::getSingleton("url/request")->getRequest();
		$evalDataDb 	= Core::getModel("evaluation/evaluationdata");
		$evaluationDb 	= Core::getModel("evaluation/evaluation");
		$evaluatorDb 	= Core::getModel("evaluation/evaluator");
		$evaluationDetailsDb = Core::getModel("evaluation/evaluationdetails");
		$ratingDb 		= Core::getModel("evaluation/rating");
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

		if( isset($request["btnEval"]) ) {
			unset($request["btnEval"]);
		}

		$evaluatorDb->insert([
			"name" 	=> $_SESSION["evaluation"]["evaluator"]["name"],
			"type" 	=> "Student",
			"year" 	=> $_SESSION["evaluation"]["evaluator"]["year"],
			"course" => $_SESSION["evaluation"]["evaluator"]["course"]
		]);

		$evaluatorId = $evaluatorDb->lastId;
		
		$evaluationId = $evaluationDb->where("code", $_SESSION["evaluation"]["code"])->first()->id;

		$ratingDb->insert([
			"crit_A1" => $request[1],
			"crit_A2" => $request[3],
			"crit_A3" => $request[6],
			"crit_A4" => $request[7],
			"crit_A5" => $request[8],
			"ave_crit1" => $this->getAve([$request[1],$request[3],$request[6],$request[7],$request[8]], 1),

			"crit_B1" => $request[2],
			"crit_B2" => $request[9],
			"crit_B3" => $request[10],
			"crit_B4" => $request[11],
			"crit_B5" => $request[12],
			"ave_crit2" => $this->getAve([$request[2],$request[9],$request[10],$request[11],$request[12]], 1),

			"crit_C1" => $request[4],
			"crit_C2" => $request[13],
			"crit_C3" => $request[14],
			"crit_C4" => $request[15],
			"crit_C5" => $request[16],
			"ave_crit3" => $this->getAve([$request[4],$request[13],$request[14],$request[15],$request[16]], 2),

			"crit_D1" => $request[5],
			"crit_D2" => $request[17],
			"crit_D3" => $request[18],
			"crit_D4" => $request[19],
			"crit_D5" => $request[20],
			"ave_crit4" => $this->getAve([$request[5],$request[17],$request[18],$request[19],$request[20]], 2),

			"ave_total" => $this->getAve([
				$this->getAve([$request[1],$request[3],$request[6],$request[7],$request[8]], 1),
				$this->getAve([$request[2],$request[9],$request[10],$request[11],$request[12]], 1),
				$this->getAve([$request[4],$request[13],$request[14],$request[15],$request[16]], 2),
				$this->getAve([$request[5],$request[17],$request[18],$request[19],$request[20]], 2),
			],
			3
		)
		]);

		$evalAccountData = Core::getModel("account/accountdata")->where("account_id", $evaluationDb->where("code", $_SESSION["evaluation"]["code"])->first()->account_id)->first();

		$evaluationDetailsDb->insert([
			"evaluation_id" => $evaluationId,
			"evaluator_id" => $evaluatorId,
			"rating_id" => $ratingDb->lastId,
			"school_year" => $evalAccountData->scyear,
			"semester" => $evalAccountData->sem,
			"comments" => $request["comments"]
		]);

		unset($_SESSION["evaluation"]);

		$session->add("alert", [
			"type" => "success",
			"message" => "Faculty was successfully evaluated."
		]);
		
		$this->_redirect( $next );
	}

	public function getAve($ans = array(), $type = false) {
		$sum = 0;
		if( $type == 1 ) {
			foreach( $ans as $a ) {
				$sum = $sum + $a;
			}

			return (($sum / 25) * 100);
		}

		if( $type == 2 ) {
			foreach( $ans as $a ) {
				$sum = $sum + $a;
			}

			return (($sum / 25) * 100);
		}

		if( $type = 3 ) {
			foreach( $ans as $a ) {
				$sum = $sum + $a;
			}
			return $sum / count($ans);
		}
		return 0;
	}

	public function evaluatorInfoAction () {
		$session = Core::getSingleton("system/session");
		$request = Core::getSingleton("url/request")->getRequest();
		$next = Core::getBaseUrl() . "evaluation";

		if( empty($request["fullname"]) or empty($request["year"]) or empty($request["course"]) ) {
			$session->add("alert", [ 
				"type" => "error",
				"message" => "Please fill all the fields."
			]);
			$this->_redirect($next);
			return;
		}

		$_SESSION["evaluation"]["evaluator"]["name"] 	= $request["fullname"];
		$_SESSION["evaluation"]["evaluator"]["year"] 	= $request["year"];
		$_SESSION["evaluation"]["evaluator"]["course"] 	= $request["course"];
		$_SESSION["evaluation"]["hasEvaluator"]			= true;
		$_SESSION["evaluation"]["access"] 				= true;
		$this->_redirect($next);
	}
}