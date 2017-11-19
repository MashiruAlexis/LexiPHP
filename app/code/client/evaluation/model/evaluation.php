<?php

Class Evaluation_Model_Evaluation extends Database_Model_Base {

	const STATUS_ON_GOING 		= "on-going";
	const STATUS_COMPLETED 		= "completed";
	const STATUS_STOPED 		= "stopped";

	protected $table = "evaluation";
	
}