<?php

/**
 *	Base model of all model
 */
Class Database_Model_Base {

	/**
	 *	Database
	 */
	protected $database = "centralpoint";

	/**
	 *	Table
	 */
	protected $table;

	/**
	 *	host
	 */
	protected $host = "localhost";

	/**
	 *	username
	 */
	protected $user = "lioncityco";

	/**
	 *	password
	 */
	protected $pass = "lcc987";

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
		$sql = "INSERT INTO " . $this->table . "(";
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
		Kernel::put($sql, "sql.logs");
		try {
		    // use exec() because no results are returned

		    $this->conn->exec($sql);
		    }
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
			return false;
		}
		return true;
	}

	/**
	 *	update data
	 */
	public function update( $items = array() ) {
		$sql = "UPDATE " . $this->table . " SET ";
		foreach( $items as $key => $val ) {
			$sql .= $key . '="' . $val . '"';
		}
		$sql .= $this->whereClause;
		$this->whereClause = null;
		Kernel::log( $sql );
		// exit();
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
	public function get() {
		if( empty($this->selectClause) ) {
			$this->selectClause = "*";
		}
		$sql = "SELECT " . $this->selectClause . " FROM " . $this->table . $this->whereClause;
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
		// Kernel::log($this->selectClause);
		return $this;
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
	 *	auto generate where clause in sql
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

	public function bootParent() {
		Kernel::log("Mother Model was successfully booted.");
	}
}