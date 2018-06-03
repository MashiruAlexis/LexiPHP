<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Database_Model_Schema extends Database_Model_Base {

	/**
	 *	SQL Query
	 */
	protected $sql;

	/**
	 *	Current Table
	 */
	public $schemTable;

	/**
	 *	Create Table
	 *	@param string $table
	 *	@return obj $this
	 */
	public function create( $table ) {
		$this->schemTable = $table;
		$this->sql = 'CREATE TABLE ' . $table . " (";
		return $this;
	}

	/**
	 *	Add primary key to the table created.
	 *	@param string $col
	 *	@return obj $this
	 */
	public function increments( $col ) {
		$this->sql .= $col . " INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
		return $this;
	}

	/**
	 *	Add string column (varchar)
	 *	@param string $col
	 *	@return obj $this
	 */
	public function string( $col, $lenght = 10 ) {
		$this->sql .= $col . " VARCHAR(". $lenght .") NULL,";
		return $this;
	}

	/**
	 *	Drop Table
	 *	@param string $table
	 *	@return bool
	 */
	public function dropTable( $table ) {
		if( $this->tableExist( $table ) ) {
			$this->conn->exec("DROP TABLE " . $table);
			if(! $this->tableExist( $table ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 *	execute schema
	 */
	public function exec() {
		$this->sql = rtrim($this->sql,", ");
		$this->sql .= ")";

		if( $this->tableExist($this->schemTable) ) {
			return false;
		}

		try {
			$this->conn->exec($this->sql);
			if( $this->tableExist($this->schemTable) ) {
				return true;
			}
		}
		catch(PDOException $e) {
    		echo $sql . "<br>" . $e->getMessage();
    	}
	}


}