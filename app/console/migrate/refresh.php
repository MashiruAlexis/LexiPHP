<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Migrate_Refresh extends Console_Controller_Core {

	public $description = "This will refresh the database.";
	public $help = "Syntax must be right.";

	public function handler() {
		$db = Core::getModel("database/base");
		foreach( $db->showTables() as $table ) {
			$db->truncate( $table );
			if(! $db->tableNotEmpty($table) ) {
				$this->success($table . " has been truncated.");
			}else{
				$this->output($this->color($table, "green") . $this->color(" was not truncated.", "red"));
			}
		}
		return;
	}
}