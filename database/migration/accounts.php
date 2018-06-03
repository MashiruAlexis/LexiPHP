<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Accounts extends Database_Model_Schema {

	/**
	 *	Run the migration
	 *	@return void
	 */
	public function up() {
		// create table
		$this->create('accounts');
		$this->increments("id");
		$this->string("username", 30);
		$this->string("password", 200);
		$this->string("email", 20);
		$this->string("created_at", 30);
		$this->string("updated_at", 30);

		// exection table schema
		$this->exec();
	}

	/**
	 *	Reverse the migrations.
	 *	@return void
	 */
	public function down() {
		$this->dropTable('accounts');
	}
}