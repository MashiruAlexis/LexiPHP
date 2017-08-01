<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */
Class Syntax_Controller_Index extends Frontend_Controller_Action {

	public function index() {
		Core::getSingleton("syntax/highlight")->index();
	}
}