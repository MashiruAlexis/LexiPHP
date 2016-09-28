<?php

// Lexi API

Class Api_Controller_Index extends Frontend_Controller_Action {


	public function index($var = "test") {
		// text/plain
		// application/json
		// echo Core::getSingleton("encode/json")->encode($this->varData);
		header("Content-Type:application/json");
		Core::log(Core::getSingleton("url/request"));
		Core::log(Core::getSingleton("url/request")->getRequest("id"));
		Core::log($_POST);
		Core::log($_GET);
		Core::log($_SERVER['REQUEST_METHOD']);
		echo json_encode($con);
	}
}