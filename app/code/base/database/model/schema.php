<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Database_Model_Schema extends Database_Model_Base {

	public $sqlQuery;

	/**
	 *	Create Database
	 *	@param string $name
	 *	@return
	 */
	public function createDatabase( $name ) {
		$sql = "CREATE DATABASE " . $name;
		if( $this->conn->query($sql) == true ) {
			return true;
		}
		return false;
	}

	/**
	 *	Create Table
	 *	@param string $table
	 *	@return bool
	 */
	public function createTable( $table ) {
		
	}
}