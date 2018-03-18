<?php

Class Admin_Controller_Configure extends Frontend_Controller_Action {

	public function __construct() {
		// to stop unauthenticated user from access to this page
		$this->middleware("auth");
	}

	public function indexAction() {
		$this->setPageTitle("Configure");
		$this->setBlock("admin/configure");
	}

	/**
	 *	Update Criteria
	 */
	public function updateCriteriaAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");

		$criteriaDb = Core::getModel("evaluation/criteria");

		if( isset($request["btnUpdateCriteria"]) ) {
			unset($request["btnUpdateCriteria"]);
		}
		$criteriaDb->where("id", $request["criteriaId"])->update([
			"label" => $request[$request["criteriaId"]]
		]);
		$session->add("alert",[
			"type" => "success",
			"message" => "Criteria was successfully updated."
		]);
		$this->_redirect(Core::getBaseUrl() . "admin/configure");
		return;
	}

	/**
	 *	Update Sub Criteria
	 */
	public function updateSubCriteriaAction() {
		$session = Core::getSingleton("system/session");
		$request = Core::getSingleton("url/request")->getRequest();
		$next = Core::getBaseUrl() . "admin/configure?tab=subcriteria";

		$subcriteriaDb = Core::getModel("evaluation/subcriteria");

		$subcriteriaDb->where("id", $request["subcriteriaId"])->update([
			"question" => $request[$request["subcriteriaId"]]
		]);
		$session->add("alert", [
			"type" => "success",
			"message" => "Sub Criteria was successfully updated."
		]);
		
		$this->_redirect( $next );
		return;
	}

	public function setup() {
		$this->setJs("default/dashboard");
	}
}