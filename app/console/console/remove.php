<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_console_remove extends Console_Controller_Core {

	public function handler( $args ) {
		if( empty($args) ) {
			$this->error("Error: no arguments was passed.");
		}
		$this->log( $args );
		if( strrpos("/", $args[0]) > 0 ) {
			$param = explode("/", $args[0]);
			$path = $this->getConsolePath() . $param[0] . DS . $param[1] . ".php";
			if(! file_exists($path) ) {
				$this->error("Error: command doest not exist.");
				return false;
			} 
			unlink($path);
			$this->success("Command was successfully removed (" . $param[0] . '/' . $param[1] . ')');
			return true;
		}else{
			$this->warning("This will remove console command completely. you can't undo this action.");
			$path = $this->getConsolePath() . $args[0];
			if( Core::getSingleton("system/filesystem")->dirExist( $path ) ) {
				if( unlink($path) ) {
					$this->success("Console command successfully removed.");
				}
				return true;
			}
		}

		$this->info("Please check your syntax and try again.");
		return;


	}
}