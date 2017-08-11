<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Model_Account extends Database_Model_Base {

	/**
	 *	Table Name for this model
	 */
	protected $table = "accounts";


	/**
	 *	Get Account By Id
	 *	@param int $id
	 *	@return obj $account
	 */
	public function get( $id = false ){
		if( $id ) {
			return $this->where("id", $id)->first();
		}
		return $this->get();
	}

	/**
	 *	Login User By Col
	 */
	public function loginBy( $col, $val ) {
		$res = $this->where( $col, $val )->first();
		Core::getSingleton("system/session")->add("auth", $res);
	}
	
	/**
	 *	Get Id
	 */
	public function getId() {
		return Core::getSingleton("system/session")->get("auth")->id;
	}

	/**
	 *	Get Toggl Data
	 *	@param string $col
	 *	@return obj|string|int $toggl
	 */
	public function getToggl( $col = false ) {
		$toggl = Core::getModel("toggl/toggl");
		$res = $toggl->where("uid", Core::getSingleton("system/session")->get('auth')->id)->first();
		if( $col ) {
			return isset($res->$col) ? $res->$col : "";
		}
		return $res;
	}

	/**
	 *	Get Default workspace
	 */
	public function getDefaultWorkspace( $col = false ) {
		foreach( $this->getWorkspace() as $workspace ) {
			if( $workspace->isDefault ) {
				if( $col ) {
					return $workspace->$col;
				}
				return $workspace;
			}
		}
		return false;
	}

	/**
	 *	Get Workspace
	 *	@return $obj $workspace
	 */
	public function getWorkspace() {
		$workspace = Core::getModel("toggl/workspace");
		$res = $workspace->where( "togglId", $this->getToggl("togglId") )->get();
		return $res;
	}

	/**
	 *	Check if account has default workspace
	 */
	public function hasDefaultWorkspace() {
		$workspaces = $this->getWorkspace();
		foreach( $workspaces as $workspace ) {
			if( $workspace->isDefault ) {
				return true;
			}
		}
		return false;
	}

	/**
	 *	Get time entries
	 */
	public function getTimeEntries( $since, $until = false ){
		$toggl = Core::getSingleton("toggl/handler");
		$data;
		$page = 2;
		$params = [
			"since" 		=> $since,
			"user_agent" 	=> Core::getSingleton("system/config")->getConfig("email"),
			"workspace_id" 	=> $this->getDefaultWorkspace("workspaceId"),
			"user_ids" 		=> $this->getToggl("togglId"),
		];

		if( $until ) {
			$params["until"] = $until;
		}

		$res = $toggl->getApp("reports")->detailed($params);

		$data = $res["data"];

		if( $res["total_count"] > 50 ) {
			$params["page"] = 2;
			$res =  $toggl->getApp("reports")->detailed($params);
			$data = $this->combine($data, $res["data"]);
			if( $res["total_count"] > 100 ) {
				$params["page"] = 3;
				$res =  $toggl->getApp("reports")->detailed($params);
				$data = $this->combine($data, $res["data"]);
				if( $res["total_count"] > 150 ) {
					$params["page"] = 4;
					$res =  $toggl->getApp("reports")->detailed($params);
					$data = $this->combine($data, $res["data"]);
				}
			}
		}
		return $data;
	}

	public function addTwoTimes($time1 = "00:00:00", $time2 = "00:00:00"){
        $time2_arr = [];
        $time1 = $time1;
        $time2_arr = explode(":", $time2);
        //Hour
        if(isset($time2_arr[0]) && $time2_arr[0] != ""){
            $time1 = $time1." +".$time2_arr[0]." hours";
            $time1 = date("H:i:s", strtotime($time1));
        }
        //Minutes
        if(isset($time2_arr[1]) && $time2_arr[1] != ""){
            $time1 = $time1." +".$time2_arr[1]." minutes";
            $time1 = date("H:i:s", strtotime($time1));
        }
        //Seconds
        if(isset($time2_arr[2]) && $time2_arr[2] != ""){
            $time1 = $time1." +".$time2_arr[2]." seconds";
            $time1 = date("H:i:s", strtotime($time1));
        }

        return date("H:i:s", strtotime($time1));
    }

	/**
	 *	Get Total Hours
	 *	@param date|time $since
	 *	@param date|time $until
	 *	@return date|time $time
	 */
	public function getTotalHours( $since, $until = false ) {
		$date = Core::getSingleton("system/date");
		if( $until ) {
			$entries = $this->getTimeEntries( $since, $until );
		}else{
			$entries = $this->getTimeEntries( $since );
		}
		$times = "00:00:00";
		foreach( $entries as $entry ) {
			$dur = $date->getDiff( $entry["start"], $entry["end"] );
			$times = $this->addTwoTimes($times, $dur);
		}
		return $times;
	}

	/**
	 *	Combine arrays
	 */
	public function combine( $base, $data ) {
		foreach( $data as $dt ) {
			$base[] = $dt;
		}
		return $base;
	}

	/**
	 * Creates Dummy Account
	 */
	public function dummy() {
		$accounts[] = [
			"username" 	=> "mashiro",
			"password" 	=> "blockman123",
			"email" 	=> "alexis@arkhold.com",
			"fname" 	=> "Mashiro",
			"lname" 	=> "Alexis",
			"contact" 	=> "09061498612",
			"skills" 	=> "Backend Developer",
			"apiKey" 	=> "c7279f362fe703f7a3f53e941d454f5d",
		];

		$accounts[] = [
			"username" 	=> "jllimpo",
			"password" 	=> "123123123",
			"email" 	=> "jovelou@team.arkhold.com",
			"fname" 	=> "",
			"lname" 	=> "",
			"contact" 	=> "",
			"skills" 	=> "Stupid",
			"apiKey" 	=> "2230d512d73c8174025a216af0b548a6",
		];

		foreach( $accounts as $account ) {
			$this->insert($account);
		}
		return true;
	}
}