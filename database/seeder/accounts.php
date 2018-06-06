<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class AccountsSeeder extends Database_Model_Schema {
	protected $table = "accounts";

	public function seed() {
		$hash = Core::getSingleton("system/hash");
		$date = Core::getSingleton("system/date");
		$rs = $this->insert([
			"username" => "alexis",
			"password" => $hash->hash("blockman123"),
			"email" => "celisramon@ymail.com",
			"created_at" => $date->getDate(),
			"updated_at" => $date->getDate()
		]);

		if( $rs ) {
			$this->success(__CLASS__ . " successfully seeded.");
			return true;
		}

		$this->error("Something went wrong while seeding " . __CLASS__);
		return false;
	}

}