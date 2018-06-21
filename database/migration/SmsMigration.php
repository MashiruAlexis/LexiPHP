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
		$this->string("from", 30);
		$this->string("to", 10);
		$this->string("message", 100);

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