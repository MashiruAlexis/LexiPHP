<?php

Class Console_Make_Client extends Console_Controller_Core {

	public $description = "Create client and it's sub directories.";
	public $path;
	protected $dirs = [
		"controller",
		"model",
		"view"
	];

	/**
	 *	Setup client
	 */
	public function handler( $args = [] ) {
		if( empty($args) ) {
			$this->error("Error: no argument was passed.");
			return false;
		}

		$file = Core::getSingleton("system/filesystem");
		$this->path = Core::$paths[0] . $args[0];
		if( in_array("-base", $args) ) {
			$this->path = Core::$paths[1] . $args[0];
		}
		if( $file->dirExist( $this->path ) ) {
			$this->error("Error: " . $args[0] . " already exists.");
			return false;
		}

		if( $file->mkdir( strtolower($this->path) ) ) {
			$this->info( "Client " . $args[0] . " was created." );
			$mvcPath = $this->path . DS;
			foreach( $this->dirs as $dir ) {
				if( $file->mkdir( $mvcPath . $dir ) ) {
					$this->info( strtoupper($dir) . " was created." );
				}else{
					$this->error("Error: something went wrong while creating " . $dir );
					return false;
				}
			}
			Core::getConsole("make/controller")->handler(["$args[0]/index"]);
		}else{
			$this->error("Error: something went wrong while creating " . $args[0]);
			$this->info("Info: check you command syntax and try again.");
			return false;
		}
		$this->info("Info: " . $args[0] . " was successfully created");
		$this->info("Path: " . $this->path);
		return true;
	}
}