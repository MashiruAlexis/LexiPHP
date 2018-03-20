<?php

Class Console_Db_Delete extends Console_Controller_Core {

	public function handler( $args ) {
		if( empty($args) ) {
			$this->error("Error: no arguments was passed.");
			return false;
		}

		if(! strpos($args[0], '/') ) {
			$this->error("Error: check your syntax and try again.");
			return false;
		}

		$db = Core::getModel($args[0]);
		$db->truncate();
		
		if( $db->tableNotEmpty($db->getTable()) ) {
			$this->error("Error: something went while processing this command.");
			return false;
		}
		$this->success($args[0] . " was successfully deleted.");
		return true;
	}
}