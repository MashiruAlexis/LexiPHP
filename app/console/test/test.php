<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_test_test extends Console_Controller_Core {

	public function handler() {
		$file = Core::getSingleton("system/filesystem");
		$dirs = $file->getDirList( $this->getConsolePath() );
		foreach( $dirs as $dir ) {
			$this->warning( $dir );
			$this->log( $file->getDirContents( $this->getConsolePath() . DS . $dir . DS ) );
		}
		// $this->log( $dirs );
		return;
	}
}