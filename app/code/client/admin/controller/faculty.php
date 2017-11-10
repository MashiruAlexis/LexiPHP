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
}