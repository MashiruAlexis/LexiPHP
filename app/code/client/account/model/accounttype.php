<?php

Class Account_Model_AccountType extends Database_Model_Base {

	protected $table = "account_type";

	/**
	 *	Auto populate usertype
	 */
	public function prePopulateAccountType() {
		$datas[] = [
			"type" => "Admin"
		];

		$datas[] = [
			"type" => "Dean"
		];

		$datas[] = [
			"type" => "Teacher"
		];

		foreach( $datas as $data ) {
			$this->insert($data);
		}
		return true;
	}
}