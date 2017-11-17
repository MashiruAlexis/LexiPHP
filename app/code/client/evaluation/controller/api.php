<?php

Class Evaluation_Controller_Api extends Frontend_Controller_Action {

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
		foreach( $department as $dp ) {
			Core::log( $dp );
			Core::log( $this->getDepartmentByEvaluation($dp->id) );
			Core::log("---------------------------------------");
		}
		
		return;
		echo json_encode([
				[
					"criteria" => "Commitment",
					"value" => 10
				],
				[
					"criteria" => "Knowledge of Subject",
					"value" => 40
				],
				[
					"criteria" => "eaching for Independent Learning",
					"value" => 50
				],
				[
					"criteria" => "Management of Learning",
					"value" => 78
				],
		]);
		exit();
	}
}