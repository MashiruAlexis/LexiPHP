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
		$request = Core::getSingleton("url/request")->getRequest();
		$accountDb = Core::getModel("account/account");

		$accountDb->like("fname", "%" . $request["name"] . "%" )->orLike( "lname", "%" . $request["name"] . "%" );
		foreach( explode(" ", $request["name"] ) as $val ) {
			$accountDb->orLike( "fname", "%" . $val . "%" );
			$accountDb->orLike( "lname", "%" . $val . "%" );
		}
		echo json_encode($accountDb->get(["id", "fname", "lname"])); exit();
		return;
	}
}