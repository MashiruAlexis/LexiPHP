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
		$request 	= Core::getSingleton("url/request")->getRequest();
		$date 		= Core::getSingleton("system/date");
		$toggl 		= Core::getSingleton("toggl/handler");
		$account 	= Core::getModel("account/account");
		$totalHours = $account->getTotalHours( date("M d, Y"), date("M d, Y") );
		// $totalHours = $account->getTotalHours( "June 25, 2017", "July 10, 2017" );
		$rate = 86.38;
		// $totalHours = "91:18:54";
		Core::log( $account->getTotalEarned( $totalHours, $rate ) );
		echo json_encode([
			"hrs" => $totalHours,
			"earned" => 1
		]);
		exit();
	}
}