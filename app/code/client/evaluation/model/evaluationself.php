<?php

Class Evaluation_Model_Evaluationself extends Database_Model_Base {

	const STATUS_PENDING = "pending";
	const STATUS_APPROVED = "approved";

	protected $table = "evaluation_self";

	/**
	 *	Check if the teacher has already evaluated his/her self
	 *	@param int $id
	 *	@return bool $result
	 */
	public function hasEvaluated( $id = false ) {
		if(! $id ) {
			$id = Core::getSingleton("system/session")->get("auth")->id;
		}
		$rs = $this->where("account_id", $id)->first();
		if( $rs ) {
			return true;
		}
		return false;
	}

	/**
	 *	Get self evaluation data
	 *	@param int $id
	 *	@return obj $accountdata
	 */
	public function getData( $id = false ) {
		if( ! $id ) {
			$id = Core::getSingleton("system/session")->get("auth")->id;
		}
		return $this->where( "account_id", $id )->first();
	}

	/**
	 *	Get teacher that have self evaluation base on current dean's deparment
	 *	@param int $id [deans id]
	 *	@return obj $account
	 */
	public function getDeansTeachers( $id = false ) {
		if(! $id ) {
			$id = Core::getSingleton("system/session")->get("auth")->id;
		}

		
	} 
}