<?php

Class Console_Db_showTables extends Console_Controller_Core {

	public function handler() {
		$db = Core::getModel("database/base");
		if( $db->showTables() ) {
			foreach( $db->showTables() as $table ) {
				$this->output($table);
			}
		}else{
			$this->error("There are no tables.");
		}
		
		return;
	}
}