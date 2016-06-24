<?php

Class Chromenoti_Controller_Index extends Frontend_Controller_Action {

	public function index() {
		Core::getSingleton("chromenoti/action")->index();
	}
}