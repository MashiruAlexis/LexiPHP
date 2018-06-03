<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_db_droptable extends Console_Controller_Core {

	public $description = 'Drop table from commandline.';

	public function handler( $args = [] ) {
		$schema = Core::getModel("database/schema");
		if( count($args) > 0 ) {
			if( $schema->dropTable( $args[0] ) ) {
				$this->success($args[0] . " was successfully droped.");
				return;
			}else{
				$this->error("Error: something went wrong while performing this command.");
			}
		}
		return;
	}
}