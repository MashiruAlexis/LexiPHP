<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Toggl extends Frontend_Controller_Action {

	/**
	 *	User API Key
	 */
	protected $apiKey;

	/**
	 *	Time Entries
	 */
	private $timeEntries;

	public function __construct() {
		$reports = new TogglReport;
	}

}