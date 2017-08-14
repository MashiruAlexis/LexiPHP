 <?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Api_Controller_Toggl extends Frontend_Controller_Action {

	public function __construct() {
		$this->middleware("auth");
	}

	public function dashboardAction() {
		$response["totalToday"] = $this->todayTotalHours();
		$response["payGrandTotal"] = $this->paydayEarned();
		echo json_encode($response);
		exit();
	}

	public function todayTotalHours() {
		$date 		= Core::getSingleton("system/date");
		$account 	= Core::getModel("account/account");
		$totalHours = $account->getTotalHours( date("M d, Y"), date("M d, Y") );
		$rate = Core::getSingleton("system/session")->get("auth")->rate;
		$earned = $account->getTotalEarned( $totalHours, $rate );
		return [
			"hrs" => $totalHours,
			"earned" => $earned
		];
	}

	public function paydayEarned() {
		$account 	= Core::getModel("account/account");
		$date 		= Core::getSingleton("system/date");
		$user 		= Core::getSingleton("system/session")->get("auth");

		$currMonth = $this->format( date("m") - 1 );
		$nextMonth = $this->format( date("m") );
		$monthDivident = [
			"first" => [
				"start" => date("M d, Y", strtotime(date("Y") . "/" . $currMonth . "/26")) ,
				"end" => date("M d, Y", strtotime(date("Y") . "/" . $nextMonth . "/10"))
			],
			"second" => [
				"start" => date("M d, Y", strtotime(date("Y") . "/" . date("m") . "/" . "11")) ,
				"end" => date("M d, Y", strtotime(date("Y") . "/" . date("m") . "/" . "25")) ,
			]
		];
		$currentDate = date("M d, Y");
		$currentDate1 = date("Y/m/d");
		foreach( $monthDivident as $mt ) {
			if( strtotime($currentDate) <= strtotime($mt["end"]) ){
				$since = $mt["start"];
				$until = $mt["end"];
			}
		}
		$totalHours = $account->getTotalHours( $since, $until );
		$amountEarned = $account->getTotalEarned( $totalHours, $user->rate );
		return [
			"hrs" => $totalHours, 
			"amountEarned" => $amountEarned
		];
	}

	public function format( $num ) {
		return str_pad($num, 2, '0', STR_PAD_LEFT);
	}

}