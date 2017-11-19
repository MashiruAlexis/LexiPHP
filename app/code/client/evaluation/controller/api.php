<?php

Class Evaluation_Controller_Api extends Frontend_Controller_Action {

	public function getEvaluationRating( $id ) {
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$evaluationDetailsDb = Core::getModel("evaluation/evaluationdetails");
		$ratingDb = Core::getModel("evaluation/rating");

		$evaluation = $evaluationDb->where("id", $id)->first();
		$evaluationDetails = $evaluationDetailsDb->where("evaluation_id", $evaluation->id)->get();
		$ratings = [];
		foreach( $evaluationDetails as $edtails ) {
			$ratings[] = $ratingDb->where("id", $edtails->rating_id)->first();
		}
		// Core::log( $ratings );
		return $ratings;
	}

	public function getDepartmentByEvaluation( $deptId = null ) {
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$accountDb = Core::getModel("account/account");
		$evaluation = $evaluationDb->where("status", $evaluationDb::STATUS_ON_GOING)->get();
		$evalData = [];
		foreach( $evaluation as $eval ) {
			if( $accountDb->getDepartment($eval->account_id)->id == $deptId ) {
				$evalData[] = $eval;
			}
		}

		return $evalData;
	}

	public function getAdminDataAction() {
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$departmentDb = Core::getModel("account/department");
		$accountDb = Core::getModel("account/account");

		$evaluation = $evaluationDb->where("status", $evaluationDb::STATUS_ON_GOING)->get();
		$department = $departmentDb->get();
		$data = [];
		$final = [];
		$totalRate = 0;
		$ts = 0;
		foreach( $department as $dp ) {
			$totalRate = 0; $ts = 0;
			foreach( $this->getDepartmentByEvaluation($dp->id) as $de ) {
				$evalRatings = $this->getEvaluationRating( $de->id );
				
				// $ts = count($evalRatings);
				foreach( $evalRatings as $rt ) {
					$totalRate = $totalRate + $rt->ave_total;
					$ts++;
				}
			}
			
			$final[] = ["label" => $dp->label, "rating" => $this->division($totalRate, $ts)];
		}
		
		echo json_encode($final);
		exit();
	}

	public function division( $num1, $num2 ) {
		if( $num1 < 1 ) {
			return 0;
		}
		return round($num1 / $num2);
	}

	public function getFacultyDataAction() {
		
	}
}