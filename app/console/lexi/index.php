<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Lexi_Index extends Console_Controller_Core {

	public $description = "this is the best framework.";
	public $excludes = [
		".php",
		"index"
	];

	public function handler( $args ) {
		$this->getHelp();
	}

	/**
	 *	Get Help for this command
	 */
	public function getHelp() {
		$kernel = Core::getSingleton("system/kernel");
		$config = $kernel->getConfig("system");

		$this->log( $this->color( $config["AppName"], "green" ) . " version " . $this->color( $config["Version"], "purple", "light_gray" ) );
		$this->log();
		$this->log( $this->color( "Usage:", "yellow" ) );
		$this->log( "\tcommand [options] [arguments]" );
		$this->log();

		

		$cmds = $this->getCmds();
		foreach( $cmds as $cmd ) {
			$this->warning( $cmd . ":" );
			foreach( $this->getSubCmd( $cmd ) as $subCmd ) {
				$this->log("   " . $subCmd . "\t This command will do something in the future.");
			}
			$this->log();
		}
	}

	/**
	 *	Get console commands
	 */
	public function getCmds() {
		$file = Core::getSingleton("system/filesystem");
		return $file->getDirList( $this->getConsolePath() );
	}

	/**
	 *	Get sub commands
	 *	@param string $cmd
	 *	@return array $subCmd
	 */
	public function getSubCmd( $cmd ) {
		$file = Core::getSingleton("system/filesystem");
		$subCmds = $file->getDirContents( $this->getConsolePath() . $cmd );
		$subCmdData = [];
		foreach( $subCmds as $subCmd ) {
			if( $subCmd == "index.php" ) { continue; }
			$subCmdData[] = str_replace(".php", "", $subCmd);
		}
		return $subCmdData;
	}

	/**
	 *	Print Commands
	 */
	public function printCmd(  ) {}

	/**
	 *	Return Console Command Path
	 *	@return $path
	 */
	public function getConsolePath() {
		return dirname(dirname(__FILE__)) . DS;
	}
}