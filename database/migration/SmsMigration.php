<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class SmsMigration extends Database_Model_Schema {

	/**
	 *	Run the migration
	 *	@return void
	 */
	public function up() {
		// create table
		$this->create('sms');
		$this->increments("id"); // primary id
		$this->string("senderId", 10);
		$this->string("receiver", 10);
		$this->string("message", 100);
		$this->string("response", 500);

		// exection table schema
		$this->exec();
	}

	/**
	 *	Reverse the migrations.
	 *	@return void
	 */
	public function down() {
		$this->dropTable('sms');
	}
}