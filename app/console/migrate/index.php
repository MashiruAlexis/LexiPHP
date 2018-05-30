<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Migrate_Index extends Console_Controller_Core {

	/**
	 *	Description
	 */
	public $description = "Indexed!";

	/**
	 *	Up the migrations
	 */
	public function handler() {

		$migrations = $this->getList();
		if( count($migrations) < 1 ) {
			$this->error("Error: no migration file was found.");
			return false;
		}

		foreach( $migrations as $migration ) {
			Core::getMigration($migration)->up();
			$this->success($migration . " was migrated successfully.");
		}
		return;
	}

	/**
	 *	get migration list
	 */
	public function getList() {
		// path to migration directory
		$path = BP . DS . "database" . DS . "migration";

		$file = Core::getSingleton("system/filesystem");

		foreach( $file->getDirContents($path) as $migration ) {
			$list[] = str_replace(".php", "", $migration);
		}

		return $list;
	}

}