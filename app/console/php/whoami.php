<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Php_Whoami extends Console_Controller_Core {

	public $description = 'Test which user does php run.';

	public function handler( $args = [] ) {
		system("whoami");
		return;
	}
}