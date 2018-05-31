<?php

Class Account_Model_Account extends Database_Model_Base {

	protected $table = "accounts";

	/**
	 *	Checks if the current user is athenticated.
	 */
	public function isAuth(){
		$sess = Core::getSingleton("system/session");
		if( $sess->has("account") ) {
			return true;
		}
		return false;
	}

	/**
	 *	Authenticate Login Cridentials
	 *	@param username
	 *	@param password
	 */
	public function login( $username, $password ) {
		$hash = Core::getSingleton("system/hash");
		$sess = Core::getSingleton("system/session");

		$rs = $this->where("username", $username)->first();

		if(! $rs ) {
			return false;
		}

		if( $hash->verify($password, $rs->password) ) {
			$sess->add("account", $rs );
			Core::log( "username: " . $rs->username, true, "accounts.log" );
			return true;
		}

		return false;
	}

	/**
	 *	Logout Current User
	 */
	public function logout() {
		$sess = Core::getSingleton("system/session");
		if( $sess->has("account") ) {
			$sess->del("account");
			return true;
		}
		return false;
	}

	/**
	 *	Create account
	 *	@param array $data
	 *	@return bool
	 */
	public function add( $data = [] ) {
		$date = Core::getSingleton("system/date");
		$hash = Core::getSingleton("system/hash");
		$this->insert([
			"username" => $data["user"],
			"password" => $hash->hash($data["pass"]),
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