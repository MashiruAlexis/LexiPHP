<?php

Class Admin_Controller_Index extends Frontend_Controller_Action {

	public function __construct() {
		$this->middleware("auth");
	}

	/**
	 *	Admin main page
	 */
	public function indexAction() {
		$session 		= Core::getSingleton("system/session");
		$accountDb 		= Core::getModel("account/account");
		$account 		= $session->get("auth");
		$accountType 	= $accountDb->getAccountType( $account->account_type_id )->type;

		// render dean page
		if( $accountType == "Admin" ) {
			$this->setPageTitle("Admin");
			$this->setBlock("admin/main");
		}

		// render dean page
		if( $accountType == "Dean" ) {
			$this->setPageTitle("Dean");
			$this->setBlock("admin/dean");
		}

		// render faculty page
		if( $accountType == "Teacher" ) {
			$this->setPageTitle("Teacher");
			$this->setBlock("admin/teacher");
		}

		
		// $this->setBlock("admin/main");

	}

	/**
	 *	Evaluation Page
	 */
	public function evaluationAction() {
		$this->setPageTitle("Evaluation");
		$this->setBlock("admin/evaluation");
	}

	/**
	 *	Client Setup
	 */
	public function setup() {
		$this->setJs("default/dashboard");
		$this->setJs("admin/admin");
		$this->setJs("admin/canvasjs");
	}
}