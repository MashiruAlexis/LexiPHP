<?php

Class Evaluation_Controller_Evaluation extends Frontend_Controller_Action {

	/**
	 *	Resume Evaluation
	 */
	public function resumeAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$next = Core::getBaseUrl() . "admin/evaluation";

		$rsFindEval = $evaluationDb->where("id", $request["id"])->first();

		if( $rsFindEval ) {
			$evaluationDb->where("id", $request["id"])->update(["status" => $evaluationDb::STATUS_ON_GOING]);
			$session->add("alert",[
				"type" => "success",
				"message" => "Evaluation was successfully resumed."
			]);
			$this->_redirect($next);
		}

		$session->add("alert", [
			"type" => "error",
			"message" => "Something went wrong trying to resume the evaluation"
		]);
		$this->_redirect($next);
	}

	/**
	 *	Stop Evaluation
	 */
	public function stopAction() {
		$this->middleware("auth");

		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$next = Core::getBaseUrl() . "admin/evaluation";

		if( $evaluationDb->where("id", $request["id"])->where("status", $evaluationDb::STATUS_ON_GOING)->exist() ) {
			$evaluationDb->where("id", $request["id"])->update([ "status" => $evaluationDb::STATUS_STOPED]);
			$evaluation = $evaluationDb->where("id", $request["id"])->first();
			$session->add("alert", [
				"type" => "success",
				"message" => "Evaluation with code:" . $evaluation->code . " has been stoped."
			]);
			$this->_redirect($next);
		}

		$session->add("alert", [
			"type" => "error",
			"message" => "Something went wrong while trying to stop this evaluation."
		]);
		$this->_redirect($next);
		return;
	}

	/**
	 *	Get School Year
	 */
	public function getSchoolYear() {
		return [
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
			"BSHRRM",
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
}