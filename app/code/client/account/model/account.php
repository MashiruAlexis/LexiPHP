<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Model_Account extends Database_Model_Base {

	const STATUS_ACTIVE = "active";
	const STATUS_INACTIVE = "inactive";
	const STATUS_DISABLED = "disable";

	/**
	 *	Table Name for this model
	 */
	protected $table = "account";

	/**
	 *	Get Account Subject
	 *	@var int $id
	 *	@return obj $subject
	 */
	public function getSubject( $id ) {
		$subjectDb = Core::getModel("admin/subject");
		
	}

	/**
	 *	Get Account Data
	 *	@var int $id
	 *	@return obj $account
	 */
	public function getAccountData( $id ) {
		$accountDataDb = Core::getModel("account/accountdata");
		$rs = $accountDataDb->where("account_id", $id)->first();
		if( $rs ) {
			return $rs;
		}
		return false;
	}

	/**
	 *	Get Account Type
	 *	@var int $id
	 *	@return obj $type
	 */
	public function getAccountType( $id ) {
		return Core::getModel("account/accounttype")->where("id", $id)->first();
	}

	/**
	 *	Get Fullname by account id
	 *	@var int $id
	 *	@var string $name
	 */
	public function getFullname( $id ) {
		$account = $this->where("id", $id)->first();
		return $account->fname . " " . $account->lname;
	}

	/**
	 *	Create Account Automatically
	 */
	public function preAccount() {
		$hash = Core::getSingleton("system/hash");
		$data[] = [
			"account_type_id" 	=> 1,
			"fname" 			=> "Alexis",
			"lname" 			=> "Celis",
			"username" 			=> "alexis",
			"password" 			=> $hash->hash("blockman123"),
			"email" 			=> "alexis@alexis.com",
			"status"			=> self::STATUS_ACTIVE
		];

		$data[] = [
			"account_type_id" 	=> 2,
			"fname" 			=> "Alexis",
			"lname" 			=> "Celis",
			"username" 			=> "alexis1",
			"password" 			=> $hash->hash("blockman123"),
			"email" 			=> "alexis1@alexis.com",
			"status"			=> self::STATUS_ACTIVE
		];

		$data[] = [
			"account_type_id" 	=> 3,
			"fname" 			=> "Alexis",
			"lname" 			=> "Celis",
			"username" 			=> "alexis2",
			"password" 			=> $hash->hash("blockman123"),
			"email" 			=> "alexis2@alexis.com",
			"status"			=> self::STATUS_ACTIVE
		];

		foreach( $data as $dt ) {
			$this->insert($dt);
		}
		return true;
	}

}