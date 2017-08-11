 <?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Api_Controller_Toggl extends Frontend_Controller_Action {

	public function __construct() {
		$this->middleware("auth");
	}

	public function todayTotalHoursAction() {
		$request = Core::getSingleton("url/request")->getRequest();
		// Core::log( $request );
		$toggl = Core::getSingleton("toggl/handler");
		$account = Core::getModel("account/account");
		echo json_encode(["hrs" => $account->getTotalHours( date("Y-m-d", strtotime("Aug 11, 2017")), date("Y-m-d", strtotime("Aug 11, 2017")) )]);
		exit();
	}
}