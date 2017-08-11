<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Date {

	/**
	 *	Date Format
	 */
	protected $dateFormat = "M d, Y";

	/**
	 *	Time Format
	 */
	protected $timeFormat = "h:i:s a";

	/**
	 *	Date and Time format
	 */
	protected $dateTimeFormat;


	public function __construct() {
		$this->dateTimeFormat = $this->dateFormat . " " . $this->timeFormat;
	}

	/**
	 *	Get Current Date
	 *	@param bool $timestamp
	 *	@return date $date
	 */
	public function getDate( $timestamp = false ) {
		if( $timestamp ) {
			return $this->parse( date($this->dateTimeFormat), true );
		}
		return date($this->dateTimeFormat);
	}

	/**
	 *	Parse the date
	 *	@param date $date
	 *	@param bool $timestamp
	 *	@return parsed date
	 */
	public function parse($date, $timestamp = false) {
		$date = strtotime($date) ? strtotime($date) : $date;
		$newDate = date($this->dateTimeFormat, $date);
		if( $timestamp ) {
			$newDate = strtotime($newDate);
		}
		return $newDate;
	}

	/**
	 *	Convert seconds to time
	 *	@param string $inputSeconds
	 *	@return time $time;
	 */
	public function secondsToTime($inputSeconds) {
		$inputSeconds = abs($inputSeconds);
		$secondsInAMinute = 60;
		$secondsInAnHour  = 60 * $secondsInAMinute;
		$secondsInADay    = 24 * $secondsInAnHour;

		// extract days
		$days = floor($inputSeconds / $secondsInADay);

		// extract hours
		$hourSeconds = $inputSeconds % $secondsInADay;
		$hours = floor($hourSeconds / $secondsInAnHour);

		// extract minutes
		$minuteSeconds = $hourSeconds % $secondsInAnHour;
		$minutes = floor($minuteSeconds / $secondsInAMinute);

		// extract the remaining seconds
		$remainingSeconds = $minuteSeconds % $secondsInAMinute;
		$seconds = ceil($remainingSeconds);

	    return $hours . ":" . $minutes . ":" . $seconds;
	}

	public function parseAtom( $date, $timestamp = false ) {
		$date = strtotime($date) ? strtotime($date) : $date;
		$date = date($this->timeFormat, $date);
		if( $timestamp ) {
			return strtotime($date);
		}
		return $date;
	}

	/**
	 *	Get Diff between time
	 *	@param date $date1
	 *	@param date $date2
	 *	@return time
	 */
	public function getDiff( $time1, $time2 ){
		$start = $this->parseAtom( $time1, true );
		$end = $this->parseAtom( $time2, true );
		return $this->secondsToTime( $start - $end );
	}

	/**
	 * Get Time Format
	 *	@return string $timeformat
	 */
	public function getTimeFormat() {
		return $this->timeFormat;
	}

	/**
	 *	Get Date Format
	 *	@return string $dateformat
	 */
	public function getDateFormat() {
		return $this->dateFormat;
	}
}