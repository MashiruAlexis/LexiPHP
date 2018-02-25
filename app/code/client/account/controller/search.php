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
		$accountDb 		= Core::getModel("account/account");
		$evaluationDb 	= Core::getModel("evaluation/evaluation");

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
}