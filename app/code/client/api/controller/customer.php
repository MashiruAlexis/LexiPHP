<?php

Class Api_Controller_Customer {

	public function getInfo() {
		// echo Core::getSingleton("system/config")->loadConfigFile();
		Core::log(Core::getSingleton("system/config")->loadConfigFile());
		$encoded = Core::getSingleton("encode/json")->encode(array(
		0	=>	"last_name", 
		1	=>	"first_name",
		2	=>	"bjorge", 
		3	=>	"philip",
		4	=>	"kardashian", 
		5	=>	"kim",
		6	=>	"mercury", 
		7	=>	"freddie"
));
		Core::log(array($encoded));
	}

	public function time() {
		$response = file_get_contents('http://api.timezonedb.com/v2/list-time-zone?key=CL6CF4NERF9E&format=json&country=PH');

		$response = json_decode($response);
		$curtime = $response->zones[0]->timestamp;
		$curtime = $this->ctime($curtime);
		Core::log($curtime);
	}

	public function ctime($times) {
		return date("h:i:s:u", $times);
	}

	public function getTime() {
		date_default_timezone_set("Asia/Manila");
		$currDate = date("h:i:s");

		echo date('D, j, h:i:s a',strtotime('-6 hour +6 minutes',strtotime($currDate)));
	}
}
