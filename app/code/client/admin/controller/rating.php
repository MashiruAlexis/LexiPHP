<?php

Class Admin_Controller_Rating extends Frontend_Controller_Action {

	/**
	 *	View Rating
	 */
	public function viewAction() {
		$this->setPageTitle("View Rating");
		$this->setBlock("admin/ratingview");
	}

	public function studentsAction() {
		$this->setPageTitle("Students Rating");
		$this->setBlock("admin/ratingstudents");
	}

	public function supervisorAction() {
		$this->setPageTitle("Supervisor Rating");
		$this->setBlock("admin/ratingsupervisor");
	}

	public function peersAction() {
		$this->setPageTitle("Peers Rating");
		$this->setBlock("admin/ratingpeers");
	}
}