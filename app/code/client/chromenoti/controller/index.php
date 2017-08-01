<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */
Class Chromenoti_Controller_Index extends Frontend_Controller_Action {

	public function index() {
		Core::getSingleton("chromenoti/action")->index();
	}
}