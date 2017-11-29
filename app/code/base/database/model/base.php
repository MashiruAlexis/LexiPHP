<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

/**
 *	Base model of all model
 */
Class Database_Model_Base {

	/**
	 *	Database
	 */
	protected $database;

	/**
	 *	Table
	 */
	protected $table;

	/**
	 *	host
	 */
	protected $host;

	/**
	 *	username
	 */
	protected $user;

	/**
	 *	password
	 */
	protected $pass;

	/**
	 *	SQL QUERY
	 */
	protected $sql;

	/**
	 *	where clause
	 */
	protected $whereClause;

	/**
	 *	select clause
	 */
	protected $selectClause;

	/**
	 *	Connection
	 */
	public $conn;

	/**
	 *	conenct to database when instantiated
	 */
	public function __construct() {
		$kernel = Core::getSingleton("system/kernel");
		$dbConfig = $kernel->getConfig("database");
		if( $dbConfig ) {
			$this->database = $dbConfig["DatabaseName"];
			$this->user = $dbConfig["Username"];
			$this->pass = $dbConfig["Password"];
			$this->host = $dbConfig["Host"];
		}
		$this->connect();
	}

	/**
	 *	SQL QUERIES Add, Update, Delete and SELECT
	 */
	public function insert( $items = array() ) {

		$sql = "INSERT INTO " . $this->table . " (";
		$itemLoopCounter = 0;
		foreach( $items as $key => $val ) {
			$itemLoopCounter++;
			$sql .= $key;
			if( $itemLoopCounter != count($items) ) {
				$sql .= ",";
			}
		}
		$sql .= ") VALUES (";
		$itemLoopCounter = 0;
		foreach( $items as $key => $item ) {
			$itemLoopCounter++;
			$sql .= '"' . $item . '"';
			if( $itemLoopCounter != count($items) ) {
				$sql .= ",";
			}
		}
		$sql .= ")";
		try {
		    $this->conn->exec($sql);
		    $this->lastId = $this->conn->lastInsertId();
		}catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
			return false;
		}
		$sql = null;
		return true;
	}

	/**
	 *	update data
	 */
	public function update( $items = array() ) {
		$sql = "UPDATE " . $this->table . " SET ";
		$c = 0;
		$itemNo = count($items);
		foreach( $items as $key => $val ) {
			$c++;
			$sql .= $key . '="' . $val . '"';
			if(! empty($val) ) {
				if( $c != $itemNo ) {
					$sql .= ", ";
				}
			}else{
				$itemNo = $itemNo - 1;
			}
		}
		$sql .= $this->whereClause;
		$this->whereClause = null;
		try {
		    // use exec() because no results are returned
		    $stmt = $this->conn->prepare($sql);
		    $stmt->execute();
		    }
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
			return false;
		}
		return true;
	}

	/**
	 *	public function delete
	 */
	public function delete() {
		$sql = "DELETE FROM " . $this->table . $this->whereClause;
		try {
			$this->conn->exec($sql);
			$this->whereClause = "";
			return true;
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
			return false;
		}
	}

	/**
	 *	get
	 */
	public function get( $col = false ) {
		if( empty($this->selectClause) ) {
			if(! $col ) {
				$this->selectClause = "*";
			}else{
				$c = 0;
				$items = count( $col );
				foreach( $col as $cl ) {
					$this->selectClause .= $cl;
					$c++;
					if( $c < $items ) {
						$this->selectClause .= ",";
					} 
					
				}
			}

		}
		$sql = "SELECT " . $this->selectClause . " FROM " . $this->table . $this->whereClause;
		Core::log( $sql );
    	try {
		    $stmt = $this->conn->prepare($sql); 
		    $stmt->execute();
		    $this->selectClause = "";
		    $this->whereClause = "";
		    return $stmt->fetchAll();
		}
		catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		    return false;
		}
		return true;
	}

	/**
	 *	first
	 */
	public function first() {
		if( empty($this->selectClause) ) {
			$this->selectClause = "*";
		}
		$sql = "SELECT " . $this->selectClause . " FROM " . $this->table . $this->whereClause;
    	try {
		    $stmt = $this->conn->prepare($sql); 
		    $stmt->execute();
		    $this->selectClause = "";
		    $this->whereClause = "";
		    return $stmt->fetch();
		}
		catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		    return false;
		}
		return true;
	}

	/**
	 *	create select
	 */
	public function select( $cols = array() ) {
		$itemLoopCounter = 0;
		foreach( $cols as $col ) {
			$itemLoopCounter++;
			if( $itemLoopCounter != count($cols) ) {
				$this->selectClause .= $col . ", ";
			}else{
				$this->selectClause .= $col;
			}
			
		}
		return $this;
	}

	/**
	 *	Check if table not empty
	 */
	public function tableNotEmpty( $name ) {
		$this->table = $name;
		$res = $this->first();
		if(! empty( $res ) ) {
			return true;
		}
		return false;
	}

	/**
	 *	Truncate Table
	 *	@param string $name
	 *	@return bool
	 */
	public function truncate( $name ) {
		$res = $this->conn->exec("TRUNCATE TABLE $name");
		if( $this->tableNotEmpty( $name ) ) {
			return false;
		}
		return true;
	}

	/**
	 *	Check specific data
	 *	@param array $data
	 *	@return bool
	 */
	public function ifNotExist( $key, $val ) {
		$res = $this->where( $key, $val )->exist();
		if( $res ) {
			return false;
		}
		return true;
	}

	/**
	 *	Check if table exist
	 *	@param string $name
	 *	@return bool
	 */
	public function tableExist( $name ) {
		return in_array($name, $this->showTables()) ? true : false;
	}

	/**
	 *	Get Tables
	 */
	public function showTables() {
		$tables =  $this->conn->query("show tables from " . $this->database)->fetchAll();
		$tableName = "Tables_in_" . $this->database;
		foreach( $tables as $table ) {
			$list[] = $table->$tableName;
		}
		return isset($list) ? $list : false;
	}

	/**
	 *	checks if the data exist
	 */
	public function exist() {
		if( empty($this->first()) ) {
			return false;
		}
		return true;
	}

	/**
	 *	Sql Where Clause
	 *	@param string $col
	 *	@param string $val
	 *	@return obj $this
	 */
	public function where( $col, $val ) {
		$andTxt = " and ";
		if( empty($this->whereClause) ) {
			$andTxt = " WHERE ";
		}
		$this->whereClause .= $andTxt . $col . " = '" . $val . "'";
		return $this;
	}

	/**
	 *	OrWhere Clause
	 *	@param string $col
	 *	@param string $val
	 *	@return obj $this
	 */
	public function orWhere( $col, $val ) {
		$this->whereClause .= $this->whereClause . " OR " . $col . "='" . $val . "' ";
		return $this;
	}

	/**
	 *	Get Table
	 */
	public function getTable() {
		return $this->table;
	}

	/**
	 *	get the connection
	 */
	public function getConnection() {
		return $this->conn;
	}

	/**
	 *	Connnect to database
	 */
	public function connect() {
		try {
			$conn = new PDO("mysql:host=". $this->host .";dbname=" . $this->database, $this->user, $this->pass);
			$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$this->conn = $conn;
		}
		catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}
		return $this->conn;
	}
}