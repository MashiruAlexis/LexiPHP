<?php

Class Admin_Controller_Evaluation extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Evaluation");
		$this->setBlock("admin/evaluation");
	}

	/**
	 *	Add Criteria
	 */
	public function addCriteriaAction() {
		$req = Core::getSingleton("url/request")->getRequest();
		$evaluation = Core::getModel("admin/evaluation");
		$criteriaDb = Core::getModel("admin/criteria");
		$alert = Core::getSingleton("system/session");

		unset($req["btnAddCriteria"]);

		if( empty($req["criteria"]) ) {
			$alert->add("alert", [
						"type" => "error",
						"message" => "Some fields were empty."
					]);
			$this->_redirect("/admin/configure?tab=criteria");
			return;
		}

		$criteriaDb->insert( ["label" => $req["criteria"]] );

		if( isset($req["redirect"]) ) {
			$this->_redirect($req["redirect"]);
		}

		$this->_redirect("/admin/configure?tab=criteria");
	}

	/**
	 *	Add Sub Criteria
	 */
	public function addSubCriteriaAction() {
		$req = Core::getSingleton("url/request")->getRequest();
		$session = Core::getSingleton("system/session");
		$subCriteriaDb = Core::getModel("admin/subcriteria");

		if( isset($req["addSubCriteria"]) ) {
			unset($req["addSubCriteria"]);
		}

		if( empty($req["subcriteria"]) or empty($req["criteria"]) ) {
			$session->add("alert", [
				"type" => "error",
				"message" => "Please check all the fields before you submit."
			]);
			$this->_redirect("/admin/configure?tab=subcriteria");
			return;
		}

		$subCriteriaDb->insert([
			"evaluation_criteria_id" => $req["criteria"],
			"question" => $req["subcriteria"]
		]);

		$this->_redirect("/admin/configure?tab=subcriteria");

	}

	public function setup() {
		$this->setJs("default/dashboard");
	}
}