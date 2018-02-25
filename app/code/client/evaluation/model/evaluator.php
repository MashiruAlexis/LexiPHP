<?php

Class Evaluation_Model_Evaluator extends Database_Model_Base {

	protected $table = "evaluator";

	/**
	 * Check evaluator to avoid duplicate
	 *	@param string|int $evaluator
	 *	@return bool $result
	 */
	public function isDuplicate( $code, $evaluator = false ) {
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$evaluationDetailsDb = Core::getModel("evaluation/evaluationdetails");

		$resEvaluation = $evaluationDb->where( "code", $code )->first(["id"]);
		$resEvaluator = $this->where("account_id", $evaluator)->orWhere("name", $evaluator)->first(["id"]);
		if( empty($resEvaluator) or empty($resEvaluation) ) {
			return false;
		}
		
		$rs = $evaluationDetailsDb->where("evaluation_id", $resEvaluation->id)->where("evaluator_id", $resEvaluator->id)->first();
		if(! empty($rs) ) {
			return true;
		}
		return false;
	}
}