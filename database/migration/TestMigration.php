<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class TestMigration extends Database_Model_Schema {

	/**
	 *	Run the migration
	 *	@return void
	 */
	public function up() {
		// create table
		$this->create('test');
		$this->increments("id");
		$this->string("name");

		// exection table schema
		$this->exec();
	}

	/**
	 *	Reverse the migrations.
	 *	@return void
	 */
	public function down() {
		$this->dropTable('test');
	}
}