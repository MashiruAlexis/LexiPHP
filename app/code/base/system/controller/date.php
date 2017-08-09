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