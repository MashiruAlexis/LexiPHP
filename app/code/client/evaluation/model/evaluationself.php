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
	 *	@return obj $teacherData
	 */
	public function getDeansTeachers( $id = false ) {
		if(! $id ) {
			$id = Core::getSingleton("system/session")->get("auth")->id;
		}

		$accountDb = Core::getModel("account/account");
		$teachers = $accountDb->where("account_type_id", 3)->get();

		if(! $accountDb->isDean($id) ) {
			return false;
		}
		$teacherData = [];
		foreach( $teachers as $teacher ) {
			if( $accountDb->sameDepartment( $teacher->id, $id ) ) {
				$teacherData[] = $teacher;
			}
		}

		return $teacherData;
	}

	/**
	 *	Get self evaluation pending count
	 *	@param int $id
	 *	@return int $count
	 */
	public function getBadgeCount( $id = false ) {
		$accountDb = Core::getModel("account/account");
		$session = Core::getSingleton("system/session");

		if(! $id ) {
			$id = $session->get("auth")->id;
		}

		if(! $accountDb->isDean( $id ) ) {
			return false;
		}

		$teachers = $this->getDeansTeachers( $id );
		$pending = [];
		foreach( $teachers as $teacher ) {
			$rsData = $this->getData( $teacher->id );
			if( $rsData ) {
				if( $rsData->status === self::STATUS_PENDING ) {
					$pending[] = $teacher;
				}
			}
		}
		return count($pending);
	}
}