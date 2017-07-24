<?php

/**
 *  Git PHP
 *  @author Ramon Alexis Celis [celisramon@ymail.com]
 */

Class Test_Controller_Git extends Frontend_Controller_Action {

	public function index() {
		Core::log("This is the index method.");
		$filesystem = Core::getSingleton("system/filesystem");
		Core::log($filesystem->create("text.log"));
	}
}