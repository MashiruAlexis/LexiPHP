<?php

Class Console_Db_showTables extends Console_Controller_Core {

	public function handler() {
		$db = Core::getModel("database/base");
		foreach( $db->showTables() as $table ) {
			$this->output($table);
		}
	}
}