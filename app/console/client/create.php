<?php

Class Console_Client_Create extends Console_Controller_Core {

	public function handler( $test ) {
		$this->error($test);
		$this->error("Hello World!");
	}
}