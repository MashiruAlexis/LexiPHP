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
			"account_type_id" 	=> rand(1,3),
			"fname" 			=> "Alexis",
			"lname" 			=> "Celis",
			"username" 			=> "alexis",
			"password" 			=> $hash->hash("blockman123"),
			"email" 			=> "alexis@alexis.com",
			"status"			=> self::STATUS_ACTIVE
		];

		$data[] = [
			"account_type_id" 	=> rand(1,3),
			"fname" 			=> "Alexis",
			"lname" 			=> "Celis",
			"username" 			=> "alexis1",
			"password" 			=> $hash->hash("blockman123"),
			"email" 			=> "alexis1@alexis.com",
			"status"			=> self::STATUS_ACTIVE
		];

		$data[] = [
			"account_type_id" 	=> rand(1,3),
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