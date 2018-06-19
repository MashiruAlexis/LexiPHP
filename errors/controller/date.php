<?php
namespace Errors\Controller;

Class Date {
	
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
		date_default_timezone_set("Asia/Manila");
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

	/**
	 *	Sum all time
	 */
	public function sumTime( $times = array() ) {
		$timeHr = 0;
		$timeMin = 0;
		$timeSec = 0;
		foreach( $times as $time ) {
			$expTime = explode( ":", $time );
			$timeHr += $expTime[0];
			$timeMin += $expTime[1];
			$timeSec += $expTime[2];
		}
		$timeMin = floor(($timeSec / 60)) + $timeMin;
		$timeHr = floor(($timeMin / 60)) + $timeHr;
		$timeMin = $timeMin % 60;
		$timeSec = $timeSec % 60;
		return str_pad($timeHr, 2, '0', STR_PAD_LEFT) . ":" . str_pad($timeMin, 2, '0', STR_PAD_LEFT) .":" . str_pad($timeSec, 2, '0', STR_PAD_LEFT);
	}

	/**
	 *	Parse Atom Time
	 */
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
		$time1 = date("Y-m-d h:i:s a", strtotime($time1));
		$time2 = date("Y-m-d h:i:s a", strtotime($time2));
		$datetime1 = new DateTime($time1);
		$datetime2 = new DateTime($time2);
		$interval = $datetime1->diff($datetime2);
		return $interval->format('%h').":".$interval->format('%i').":".$interval->format('%s');
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