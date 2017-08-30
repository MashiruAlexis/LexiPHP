<?php

Class Test_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$date = Core::getSingleton("system/date");
		$toggl = new TogglReport;
		$workspace = new TogglWorkspace;
		// Core::log( $workspace->getWorkspaces() );
		Core::log($date->getDate());

		
		$reports = $toggl->detailed([
			"since" => "July 26, 2017", 
			"until" => "August 10, 2017", 
			"user_agent" => "alexis@arkhold.com", 
			"workspace_id" => 988175,
			"user_ids" => "1760979",
		]);

		$to_time = strtotime($reports["data"][0]["start"]);
		$from_time = strtotime($reports["data"][0]["end"]);
		echo round(abs($to_time - $from_time) / 60,2). " minute";


		Core::log(date("Y-m-d h:i:s a", strtotime($reports["data"][0]["start"])));
		Core::log($reports);
	}
	public function vidAction() {
		$getID3 = new getID3;
		$file = $getID3->analyze(BP . DS . "modules" . DS . "elfinder" . DS . "files" . DS . "test.mp4" );
		Core::log($file['playtime_string']);
	}
}