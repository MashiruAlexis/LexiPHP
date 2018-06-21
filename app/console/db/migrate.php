<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_db_migrate extends Console_Controller_Core {

	public $description = 'Run migrations.';

	/**
	 *	Up the migrations
	 */
	public function handler( $args = [] ) {
		$migrations = $this->getList();
		if( count($migrations) < 1 ) {
			$this->error("Error: no migration file was found.");
			return false;
		}

		foreach( $migrations as $migration ) {
			if(! in_array("-down", $args) ) {
				if( $mg = Core::getMigration($migration) ) {
					$this->log( $mg->up() );
					// $mg->up();
					$this->success($migration . " was migrated successfully.");
				}else{
					$this->warning("Warning: " . $migration . " was already migrated.");
				}
			}else{
				if( $mg = Core::getMigration($migration) ) {
					$mg->down();
					$this->warning($migration . " was reverse migrate successfully.");
			}
			}
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