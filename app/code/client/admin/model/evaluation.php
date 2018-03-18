<?php


Class Admin_Model_Evaluation extends Database_Model_Base {

	/**
	 *	Table Name
	 */
	protected $table = "evaluation";

	/**
	 *	Evaluation Data by ID
	 *	@var string $code
	 *	@return obj $evaluationData
	 */
	public function getAccountEvaluated( $code ) {
		$accountDb = Core::getModel("account/account");
		$evaluation = $this->where("code", $code)->first();
		$account = $accountDb->where("id", $evaluation->account_id)->first();
		if( $account ) {
			return $account;
		}
		return false;
	}
	
}