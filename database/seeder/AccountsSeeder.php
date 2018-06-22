<?php

Class AccountsSeeder extends Database_Model_Schema {
	protected $table = 'accounts';

	public function seed() {
		$pass = Core::getSingleton("system/hash");
		$date = Core::getSingleton("system/date");
		// column and values inside the array
		$rs = $this->insert([
			"username" => "alexis",
			"password" => $pass->hash( "blockman123" ),
			"email" => "celisramon@ymail.com",
			"updated_at" => $date->getDate(),
			"created_at" => $date->getDate()
		]);

		$rs = $this->insert([
			"username" => "admin",
			"password" => $pass->hash( "ako" ),
			"email" => "celisramon@ymail.com",
			"updated_at" => $date->getDate(),
			"created_at" => $date->getDate()
		]);

		if(! $rs ) {
			return false;
		}

		return true;
	}
}