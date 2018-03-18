<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Controller_Register extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Create Account");
		$this->setBlock("account/register");
	}

	/**
	 *	Create User Account
	 */
	public function createAction() {
		$session 	= Core::getSingleton("system/session");
		$request 	= Core::getSingleton("url/request")->getRequest();
		$accountDb 	= Core::getModel("account/account");
		$accountDataDb = Core::getModel("account/accountdata");
		$hash 		= Core::getSingleton("system/hash");
		$next 		= isset($request["redirect"]) ? $request["redirect"] : false;

		if( $accountDb->where("username", $request["username"])->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Username already exist."
			]);

			if( $next ) {
				$this->_redirect( $next );
			}
			$this->_redirect( Core::getBaseUrl() . "admin" );
		}

		if( $accountDb->where("email", $request["email"])->exist() ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Email already exist."
			]);

			if( $next ) {
				$this->_redirect( $next );
			}
			$this->_redirect( Core::getBaseUrl() . "admin" );
		}

		if(! isset($request["department"]) ) {
			$request["department"] = "";
		}

		$rs = $accountDb->insert([
			"account_type_id" 	=> $request["accountType"],
			"fname"				=> $request["fname"],
			"lname"				=> $request["lname"],
			"username" 			=> $request["username"],
			"email" 			=> $request["email"],
			"password" 			=> $hash->hash($request["password"]),
			"status" 			=> $accountDb::STATUS_ACTIVE
		]);
		$aData["account_id"] = $accountDb->lastId;
		$aData["college_dept_id"] = $request["department"];

		// get dean based on department
		$accountData = $accountDataDb->where("college_dept_id", $request["department"])->get();
		$supervisorId = 0;
		foreach( $accountData as $adata ) {
			$account = $accountDb->where("id", $adata->account_id)->where("account_type_id", 2)->first();
			if( $account ) {
				$supervisorId = $account->id;
			}
		}
		$aData["supervisor_id"] = $supervisorId;
		
		if( $request["accountType"] == 3 ) {
			if( isset($request["scyear"]) ) {
				$aData["scyear"] = $request["scyear"];
			}

			if( isset($request["sem"]) ) {
				$aData["sem"] = $request["sem"];
			}

			if( isset($request["subject"]) ) {
				$aData["subject_id"] = $request["subject"];
			}
		}
		Core::log( $aData );
		// return;
		$accountDataDb->insert($aData);
		
		if( $rs ) {
			$session->add("alert", [
				"type" => "success",
				"message" => "Successfully created account."
			]);
		}else{
			$session->add("alert", [
				"type" => "error",
				"message" => "Something went wrong while creating this account."
			]);
		}

		if( $next ) {
			$this->_redirect( $next );
		}
		return;
	}

	public function setup() {
		$this->setJs("account/account");
		$this->setJs("default/jquery.validate.min");
		$this->setCss("default/style");
	}

}