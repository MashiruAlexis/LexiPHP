<?php

Class Evaluation_Model_Evaluation extends Database_Model_Base {

	const STATUS_ON_GOING 		= "on-going";
	const STATUS_COMPLETED 		= "completed";
	const STATUS_STOPED 		= "stopped";

	protected $table = "evaluation";
	
	/**
	 *	Check if evaluation has ratings or has been evaluted already
	 */
	public function hasRatings( $id ) {
		if( $this->getAverage($id) ) {
			return true;
		}
		return false;
	}

	/**
	 *	Get Average data
	 */
	public function getAverage( $id ) {
		$evaluation = $this->where("id", $id)->first();
		$process = Core::getSingleton("evaluation/process");
		$evaluationDetails = Core::getModel("evaluation/evaluationdetails")->where("evaluation_id", $evaluation->id)->get();
		$ratingDb = Core::getModel("evaluation/rating");
		// $id = 1;

		foreach( $evaluationDetails as $ed ) {
			$ratings[] = $ratingDb->where("id", $ed->rating_id)->first()->ave_total;
		}

		if( isset($ratings) ) {
			return $process->getAve($ratings, 3);
		}
		return false;
	}

	/**
	 *	Get account
	 *	@param int $id
	 *	@return obj $account
	 */
	public function getAccount( $id ) {
		$accountDb = Core::getModel("account/account");
		$evalaution = $this->where( "id", $id )->first();
		$rs = $accountDb->where("id", $evalaution->account_id)->first();
		if( $rs ) {
			return $rs;
		}
		return false;
	}
}