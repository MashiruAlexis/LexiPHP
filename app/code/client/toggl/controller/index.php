<?php

// use AJT\Toggl\TogglClient;

Class Toggl_Controller_Index extends Frontend_Controller_Action {

	public function indexAction() {
		$toggl = new Toggl;
		$togglTimeEntry = new TogglTimeEntry;
		Toggl::setKey("c7279f362fe703f7a3f53e941d454f5d");
		$date = new DateTime("2017-07-27");
		$start_date = $date->format(DateTime::ATOM);
		$date = new DateTime("2017-07-28");
		$end_date = $date->format(DateTime::ATOM);
		$timeEntries = $togglTimeEntry->getTimeEntriesStartedInASpecificTimeRange(["start" => $start_date, "stop" => $end_date, "duronly" => true]);
		foreach( $timeEntries as $te ) {
			Core::log( $te );
		}
	}

	public function test() {
		$toggl_token = 'c7279f362fe703f7a3f53e941d454f5d'; // Fill in your token here
		$toggl_client = TogglClient::factory(array('api_key' => $toggl_token));

		// if you want to see what is happening, add debug => true to the factory call
		$toggl_client = TogglClient::factory(array('api_key' => $toggl_token, 'debug' => true)); 
		$workspaces = $toggl_client->getTaskDetails(array());

		foreach($workspaces as $workspace){
			$id = $workspace['id'];
			// print $workspace['name'] . "\n";
			Core::log( $workspace );
		}
	}
}