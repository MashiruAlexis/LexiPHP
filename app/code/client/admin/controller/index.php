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

		// render dean page
		if( $accountDb->getAccountType( $account->account_type_id )->type == "Dean" ) {
			$this->setPageTitle("Dean");
			$this->setBlock("admin/dean");
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
		$this->setJs("admin/jquery.canvasjs.min");
	}
}