<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Toggl_Controller_Handler extends Frontend_Controller_Action {

	protected $apikey;
	protected $app;
	protected $userAgent;

	public function __construct() {
		$account = Core::getModel("account/account");
		$userSession = Core::getSingleton("system/session")->get("auth");
		$user = $account->get($userSession->id);
		if( $user ) {
			$this->apikey = $user->apiKey;
		}
		$this->app["reports"] = new TogglReport;
		$this->app["user"] = new TogglUser;

	}	

	/**
	 *	Setup Account first use
	 */
	public function goSetupAction() {
		$session = Core::getSingleton("system/session");
		if(! $this->isSetup() ) {
			$this->sync();
			$session->add("alert", [
				"type" => "success",
				"message" => "Congrats! were in sync with toggl."
			]);
		}else{
			$session->add("alert", [
				"type" => "warning",
				"message" => "This account is already sync from toggl database. No need bro :)"
			]);
		}
		$this->_redirect(Core::getBaseUrl() . "account/profile");
	}

	/**
	 *	Check if sync is needed
	 */
	public function isSetup() {
		$toggl = Core::getModel("toggl/toggl");
		$uid = Core::getSingleton("system/session")->get("auth")->id;
		$res = $toggl->where("uid", $uid)->exist();
		return $res ? $res : false;
	}

	/**
	 *	Pull data from toggl
	 */
	public function sync() {
		if(! empty($this->apikey) ) {
			$toggl = $this->app['user']->getCurrentUserData(["api_token" => $this->apikey])['data'];
			$userId = Core::getSingleton("system/session")->get("auth")->id;
			$userData = [
				"uid" 		=> $userId,
				"togglId" 	=> $toggl['id'],
				"apiToken" 	=> $toggl['api_token'],
				"email"		=> $toggl['email'],
				"fullname"	=> $toggl['fullname'],
				"imageUrl"	=> $toggl['image_url'],
				"memberSince" => $toggl["created_at"]
			];
			$togglDb = Core::getModel("toggl/toggl");
			if( $togglDb->ifNotExist("togglId", $toggl['id']) ) {
				$togglDb->insert($userData);
			}
			$togglWorkspaceDb = Core::getModel("toggl/workspace");
			$def = 0;
			if( count($toggl['workspaces']) < 2 ) {
				$def = 1;
			}
			foreach( $toggl['workspaces'] as $workspace ) {
				if( $togglWorkspaceDb->ifNotExist( "togglId", $workspace['id'] ) ) {
					$togglWorkspaceDb->insert([
						"workspaceId" 	=> $workspace['id'],
						"togglId" 		=> $toggl['id'],
						"name" 			=> $workspace['name'],
						"apiToken" 		=> isset($workspace['api_token']) ? $workspace['api_token'] : "none",
						"isDefault" 	=> $def
					]);
				}
			}
		}
		return;
	}

	/**
	 *	Get App
	 */
	public function getApp( $name = false ){
		if( $name ) {
			return $this->app[$name];
		}
		return $this->app;
	}
}