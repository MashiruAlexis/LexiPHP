<?php

Class Evaluation_Controller_Evaluation extends Frontend_Controller_Action {

		/**
	 *	Get School Year
	 */
	public function getSchoolYear() {
		return [
			"2015-2016",
			"2016-2017",
			"2017-2018",
			"2018-2019",
			"2019-2020",
			"2020-2021",
			"2021-2022"
		];
	}

	/**
	 *	Get Semester
	 */
	public function getSemester() {
		return [
			"1st",
			"2nd"
		];
	}

	/**
	 *	Get Available Course
	 */
	public function getCourse() {
		return [
			"BSIT",
			"BSCE",
			"BSED",
			"BEED",
			"BSHRM",
			"BSBA",
			"BST",
			"BA Com"
		];
	}

	/**
	 *	Get Student Year
	 */
	public function getStudentYear() {
		return [
			"1st",
			"2nd",
			"3rd",
			"4rth"
		];
	}
}