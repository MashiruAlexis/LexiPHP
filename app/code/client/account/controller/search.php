<?php

/**
 *	Search Account
 */

Class Account_Controller_Search extends Frontend_Controller_Action {

	/**
	 *	Search Account by Name
	 *	@param string $name
	 *	@return json $res
	 */
	public function searchAction() {
		$request 		= Core::getSingleton("url/request")->getRequest();
		$session		= Core::getSingleton("system/session");
		$accountDb 		= Core::getModel("account/account");
		$evaluationDb 	= Core::getModel("evaluation/evaluation");

		$user = $session->get("auth");

		if( $accountDb->isDean() ) {
			$this->searchForDeanAction();
		}

		if( $accountDb->isTeacher() ) {
			$this->searchForTeacherAction();
		}

		$accountDb->like("fname", "%" . $request["name"] . "%" )->orLike( "lname", "%" . $request["name"] . "%" );
		foreach( explode(" ", $request["name"] ) as $val ) {
			$accountDb->orLike( "fname", "%" . $val . "%" );
			$accountDb->orLike( "lname", "%" . $val . "%" );
		}

		$res = $accountDb->get(["id", "fname", "lname"]);
		$data1 = array();
		$dataEval = [];

		foreach( $evaluationDb->get(["account_id"]) as $data ) {
			$dataEval[] = $data->account_id;
		}

		if( count($res) ) {
			foreach( $res as $data ) {
				if( in_array($data->id, $dataEval)) {
					$data1[] = $data;
				}
			}
		}
		echo json_encode($data1); exit();
		return;
	}

	/**
	 *	Search Faculty by Name
	 *	@param string $name
	 *	@return obj $result
	 */
	public function searchByName( $name ) {
		$accountDb 		= Core::getModel("account/account");
		$evaluationDb 	= Core::getModel("evaluation/evaluation");
		$request["name"] = $name;

		$accountDb->like("fname", "%" . $request["name"] . "%" )->orLike( "lname", "%" . $request["name"] . "%" );
		foreach( explode(" ", $request["name"] ) as $val ) {
			$accountDb->orLike( "fname", "%" . $val . "%" );
			$accountDb->orLike( "lname", "%" . $val . "%" );
		}

		return $accountDb->get(["id", "fname", "lname"]);
	}

	/**
	 *	Search for Dean
	 */
	public function searchForDeanAction() {
		$this->middleware("auth");
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$user = $session->get("auth");
		$accountDb = Core::getModel("account/account");
		$names = $this->searchByName( $request["name"] );
		$data = [];

		foreach( $names as $name ) {
			if( $accountDb->sameDepartment( $user->id, $name->id ) and $accountDb->hasEvaluation($name->id) ) {
				$data[] = $name;
			}
		}
		echo json_encode($data); exit();

		return;
	}

	/**
	 *	Serach for Teachers
	 */
	public function searchForTeacherAction() {
		$this->middleware("auth");
		$user = Core::getSingleton("system/session")->get("auth");
		$request = Core::getSingleton("url/request")->getRequest();
		$accountDb = Core::getModel("account/account");

		$names = $this->searchByName( $request["name"] );
		$data = [];

		foreach( $names as $name ) {
			if( $accountDb->isTeacher( $name->id ) and $accountDb->hasEvaluation($name->id) ) {
				$data[] = $name;
			}
		}
		echo json_encode($data); exit();
		return;

	}
}