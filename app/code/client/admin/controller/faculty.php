<?php

Class Admin_Controller_Faculty extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Faculty");
		$this->setBlock("admin/faculty");
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

		$accountDataDb->insert([
			"account_id" 	=> $accountDb->lastId,
			"subject_id" 	=> $request["subject"],
			"scyear" 		=> $request["scyear"],
			"sem" 			=> $request["sem"],
			"college_dept_id" => $request["department"]
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