<?php

Class Console_Db_Delete extends Console_Controller_Core {

	public function handler( $args ) {
		$db = Core::getModel($args[2]);
		$db->delete();
		$this->success($args[2] . " was successfully deleted.");
	}
}