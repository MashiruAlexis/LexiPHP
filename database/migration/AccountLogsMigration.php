<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class AccountlogsMigration extends Database_Model_Schema {

	/**
	 *	Run the migration
	 *	@return void
	 */
	public function up() {
		// create table
		$this->create('accountlogs');
		$this->increments("id"); // primary id
		$this->string("accountId");
		$this->string("os", 50);
		$this->string("browser", 50);
		$this->string("ipaddress", 45);
		$this->string('datetime', 50);

		// exection table schema
		$this->exec();
	}

	/**
	 *	Reverse the migrations.
	 *	@return void
	 */
	public function down() {
		$this->dropTable('accountlogs');
	}
}