<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Controller_Maker extends Console_Controller_Core {

	public $parent;
	public $key1;
	public $key2;
	public $template;
	public $path;

	protected $defaults = [
		"key1",
		"key2",
		"parent",
		"template",
		"path",
	];

	/**
	 *	Creator
	 *	@param array $setup
	 *	@return bool
	 */
	public function __construct( $setup ) {
		// if(! in_array($this->defaults, $setup) ) {
		// 	return false;
		// }
		$file = Core::getSingleton("system/filesystem");
		if(! $file->dirExist($setup['path']) ) {
			mkdir($setup['path']);
		}
		$path = $setup['path'] . $setup['key2'] . ".php";
		

		$temp = file_get_contents($setup['template']);
		$temp = str_replace('{key1}', $setup['key1'], $temp);
		$temp = str_replace('{key2}', $setup['key2'], $temp);
		$temp = str_replace('{parent}', $setup['parent'], $temp);

		if( file_put_contents($setup['path'] . $setup['filename'], $temp) ) {
			return true;
		}
		return false;
	}

	/**
	 *	Start the making process
	 */
	public function make() {

	}

	/**
	 *	Set path
	 *	@param string $path
	 *	@return
	 */
	public function setPath( $path ) {
		$this->path = $path;
		return;
	}

	/**
	 *	Set where this class will extends
	 *	@param string $parent
	 *	@return
	 */
	public function setParent( $parent ) {
		$this->parent = $parent;
		return;
	}

}