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
		$date = Core::getSingleton("system/date");
		$totalToday = $this->todayTotalHours();
		$tasks = $totalToday["tasks"];
		$taskLists = [];
		foreach( $tasks as $task ) {
			$taskLists[$task["description"]][] = $date->getDiff( $task["start"], $task["end"] );
			$timeEntry[$task["description"]]["start"] = date("h:i:s a", strtotime($task["start"]));
			$timeEntry[$task["description"]]["end"] = date("h:i:s a", strtotime($task["end"]));
		}
		foreach( $tasks as $task ) {
			$timelog[$task["description"]]["start"][] = date("h:i:s a", strtotime($task["start"])); 
			$timelog[$task["description"]]["end"][] = date("h:i:s a", strtotime($task["end"]));
		}
		foreach( $taskLists as $key => $tasklist ) {
			$list[] = [
				"description" => $key,
				"duration" => $date->sumTime($tasklist),
				"start" => end($timelog[$key]["start"]),
				"end" => $timelog[$key]["end"][0]
			];
		}
		unset($totalToday["tasks"]);
		$response["totalToday"] = $totalToday;
		$response["payGrandTotal"] = $this->paydayEarned();
		$response["tasks"] = isset($list) ? $list : "";
		echo json_encode($response);
		exit();
	}

	public function todayTotalHours() {
		$date 		= Core::getSingleton("system/date");
		$account 	= Core::getModel("account/account");
		$totalHours = $account->getTotalHours( date("M d, Y"), date("M d, Y") );
		$rate = Core::getSingleton("system/session")->get("auth")->rate;
		$earned = $account->getTotalEarned( $totalHours, $rate );
		if(! $totalHours ) {
			$totalHours = "00:00:00";
		}
		return [
			"hrs" => $totalHours,
			"earned" => $earned,
			"tasks" => $account->getTasks()
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

	/**
	 *	Format number two decimal places
	 *	@param float $num
	 *	@return float $num
	 */
	public function format( $num ) {
		return str_pad($num, 2, '0', STR_PAD_LEFT);
	}
}