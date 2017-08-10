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
			return $res->$col;
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
		// return Core::getModel("toggl/workspace")->where("isDefault", 1)->where("togglId", $this->getToggl("togglId"))->first();
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
		$this->insert([
			"username" 	=> "mashiro",
			"password" 	=> "blockman123",
			"email" 	=> "alexis@arkhold.com",
			"fname" 	=> "Mashiro",
			"lname" 	=> "Alexis",
			"contact" 	=> "09061498612",
			"skills" 	=> "Backend Developer",
			"apiKey" 	=> "c7279f362fe703f7a3f53e941d454f5d",
		]);
		return true;
	}
}