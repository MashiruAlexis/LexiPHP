<?php

Class Account_Model_Account extends Database_Model_Base {

	protected $table = "accounts";

	
	/**
	 *	Create account
	 *	@param array $data
	 *	@return bool
	 */
	public function add( $data = [] ) {
		$date = Core::getSingleton("system/date");
		$this->insert([
			"username" => $data["user"],
			"password" => $data["pass"],
			"email" => $data["email"],
			"created_at" => $date->getDate(),
			"updated_at" => $date->getDate()
		]);

		if( isset($this->lastId) ) {
			return true;
		}

		return false;
	}

	/**
	 *	check if user already exists
	 *	@param array $data
	 *	@return bool
	 */
	public function userExist( $data = [] ) {
		if( $this->where("username", $data["user"])->exist() ) {
			return true;
		}
		return false;
	}
}