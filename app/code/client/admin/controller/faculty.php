<?php

Class Admin_Controller_Faculty extends Frontend_Controller_Action {

	/**
	 *	Faculty default page
	 */
	public function indexAction() {
		$this->setPageTitle("Faculty");
		$this->setBlock("admin/faculty");
	}

	/**
	 *	Self Evaluation List
	 */
	public function selfEvaluationAction() {
		$this->setPageTitle("Faculty Self Evaluation");
		$this->setBlock("admin/selfevaluationlist");
	}

	/**
	 *	Approve Teacher Self Evaluation
	 */
	public function approveSelfEvaluationAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$evaluationSelfDb = Core::getModel("evaluation/evaluationself");
		$next = Core::getBaseUrl() . 'admin/faculty/selfEvaluation';
		if(! isset($request["id"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Invalid Request"
			]);
			$this->_redirect( $next );
			return;
		}

		$rs = $evaluationSelfDb->where("account_id", $request["id"])->update([
			"status" => $evaluationSelfDb::STATUS_APPROVED
		]);

		if(! $rs ) {
			$session->add("alert",[
				"type" => "error",
				"message" => "Something went wrong while approving this evaluation."
			]);
			$this->_redirect( $next );
			return;
		}

		$session->add("alert",[
			"type" => "success",
			"message" => "Teacher was successfully approved."
		]);
		$this->_redirect( $next );
		return;
	}

	/**
	 *	Faculty get data
	 *	@param int $id
	 *	@param int $scyear
	 *	@param string $sem
	 *	@return array $ratings
	 */
	public function getFacultyData( $id, $scyear = null, $sem = null ) {
		$evaluationDb = Core::getModel("evaluation/evaluation");
		$evaluationDetailsDb = Core::getModel("evaluation/evaluationdetails");
		$ratingDb = Core::getModel("evaluation/rating");

		$evaluation = $evaluationDb->where("account_id", $id)->first();
		$evaluationDetails = $evaluationDetailsDb
			->where("evaluation_id", $evaluation->id)
			->where("school_year", $scyear)
			->where("semester", $sem)
			->get();

		$ratings = [];
		foreach( $evaluationDetails as $ed ) {
			$rs = $ratingDb->where("id", $ed->rating_id)->first();
			if( $rs ) {
				$ratings[] = $rs;
			}else{
				$rs = [];
			}
		}
		$cr1 = 0;
		$cr2 = 0;
		$cr3 = 0;
		$cr4 = 0;
		foreach( $ratings as $rt ) {
			$cr1 = $cr1 + $rt->ave_crit1;
			$cr2 = $cr2 + $rt->ave_crit2;
			$cr3 = $cr3 + $rt->ave_crit3;
			$cr4 = $cr4 + $rt->ave_crit4;
		}

		if( $this->isZero( $cr1 ) or $this->isZero( $cr2 ) or $this->isZero( $cr3 ) or $this->isZero( $cr4 ) ) {
			return [
				"cr1" => count($ratings),
				"cr2" => count($ratings),
				"cr3" => count($ratings),
				"cr4" => count($ratings),
			];

		}

		return [
			"cr1" => $cr1 / count($ratings),
			"cr2" => $cr2 / count($ratings),
			"cr3" => $cr3 / count($ratings),
			"cr4" => $cr4 / count($ratings),
		];
		// $rating = $ratingDb->where("id", $evaluationDetails->rating_id)->first();

	}

	/**
	 *	Check if a number is zero
	 *	@var int $num
	 *	@return bool
	 */
	public function isZero( $num ) {
		if( $num == 0 ) {
			return true;
		}
		return false;
	}

	/**
	 *	Create Faculty Account
	 */
	public function createAction() {
		$this->setPageTitle("Create Faculty Account");
		$this->setBlock("admin/createfaculty");
	}

	/**
	 *	Update Faculty
	 */
	public function editAction() {
		$this->setPageTitle("Update Faculty");
		$this->setBlock("admin/updatefaculty");
	}

	public function submitCreateAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$hash = Core::getSingleton("system/hash");

		$accountDb = Core::getModel("account/account");
		$accountDataDb = Core::getModel("account/accountdata");

		$next = Core::getBaseUrl() . "admin/faculty/create";
		Core::log( $request );

		if( $accountDb->where("username", $request["username"])->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Username already exist."
			]);
			$this->_redirect( $next );
		}

		if( $accountDb->where("email", $request["email"])->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Email already exist."
			]);
			$this->_redirect( $next );
		}

		$accountDb->insert([
			"account_type_id" 	=> 3,
			"fname" 			=> $request["fname"],
			"lname" 			=> $request["lname"],
			"username" 			=> $request["username"],
			"password" 			=> $hash->hash($request["password"]),
			"email" 			=> $request["email"],
			"status" 			=> $accountDb::STATUS_ACTIVE
		]);
		$supervisorId = 0;
		if( $accountDb->isAccountType("Dean") ) {
			$supervisorId = $_SESSION["auth"]->id;
		}
		$accountDataDb->insert([
			"account_id" 	=> $accountDb->lastId,
			"subject_id" 	=> $request["subject"],
			"scyear" 		=> $request["scyear"],
			"sem" 			=> $request["sem"],
			"college_dept_id" => $request["department"],
			"supervisor_id" => $supervisorId
		]);
		
		$session->add("alert",[
			"type" => "success",
			"message" => "Successfully created account."
		]);
		$this->_redirect($next);
	}

	public function submitUpdateAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$hash = Core::getSingleton("system/hash");
		$accountDb = Core::getModel("account/account");
		$accountDataDb = Core::getModel("account/accountdata");
		$next = Core::getBaseUrl() . "admin/faculty";

		if( isset($request["redirect"]) ) {
			$next = $request["redirect"];
		}

		if( $request["password"] ) {
			$accountDb->where("id", $request["accountId"])
			->update([
				"fname" 		=> $request["fname"],
				"lname" 		=> $request["lname"],
				"username" 		=> $request["username"],
				"password" 		=> $hash->hash( $request["password"] )
			]);
		}else{
			$accountDb->where("id", $request["accountId"])
			->update([
				"fname" 	=> $request["fname"],
				"lname" 	=> $request["lname"],
				"username" 	=> $request["username"],
			]);
		}

		$accountDataDb->where("account_id", $request["accountId"])
		->update([
			"college_dept_id" 	=> $request["department"],
			"subject_id" 		=> $request["subject"],
			"scyear"			=> $request["scyear"],
			"sem"				=> $request["sem"]
		]);

		$session->add("alert", [
			"type" => "success",
			"message" => "Account was successfully updated."
		]);
		$this->_redirect($next);
		return;
	}

	public function setup() {
		$this->setJs("default/jquery.validate.min");
	}
}