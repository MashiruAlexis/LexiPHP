<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Make_Controller extends Console_Controller_Core {

	protected $controllerPath;
	protected $templatePath;
	protected $controllerNeedle = '{controller}';
	protected $controllerFileNeedle = '{filename}';
	protected $controllerParent = 'Frontend_Controller_Action';
	protected $controllerParentNeedle = '{parent}';
	protected $controllerExtension = ".php";
	protected $dirs = [
		"controller",
		"model",
		"view"
	];
	
	public $templateFilename = "controller.txt";


	/**
	 *	Default Request Handler
	 *	@param array $args
	 */
	public function handler( $args = [] ) {
		if( empty($args) ) {
			$this->error("Error: no arguments was passed.");
			return;
		}

		$base = in_array("-base", $args) ? true : false;
		$args = explode("/", $args[0]);

		if( count($args) < 2 ) {
			$this->error("Error: invalid syntax. check help.");
			return false;
		}

		$file = Core::getSingleton("system/filesystem");
		$this->controllerPath = Core::$paths[0];
		
		if( $base ) {
			$this->info("Making controller for base directory is intended for core developers only. Procced with caution.");
			$this->controllerPath = Core::$paths[1];
		}

		$this->templatePath = dirname(__FILE__) . DS . "template" . DS;
		$template = $this->templatePath . $this->templateFilename;

		if(! $file->dirExist( $this->controllerPath . $args[0] ) ) {
			if(! $this->makeClient( $args[0] ) ) {
				$this->error("Error: something went while creating client.");
				return false;
			}
		}

		if( file_exists($template) ) {
			$template = file_get_contents($this->templatePath . $this->templateFilename);
			$template = str_replace($this->controllerNeedle, ucfirst($args[0]), $template);
			$template = str_replace($this->controllerFileNeedle, ucfirst($args[1]), $template);
			$template = str_replace($this->controllerParentNeedle, $this->controllerParent, $template);
			$controllerFilePath = $this->controllerPath . $args[0] . DS . "controller" . DS . $args[1] . $this->controllerExtension;
			if( file_exists($controllerFilePath) ) {
				$this->error("Error: " . $args[1] . " already created.");
				return false;
			}
			@file_put_contents($controllerFilePath, $template);
			if( file_exists($controllerFilePath) ) {
				$this->info($args[1] . " controller was successfully created.");
				$this->warning( $controllerFilePath );
				return true;
			}
			$this->log( $this->color("Error: something went wrong while creating ", "red") . $this->color($args[1], "green") );
		}
		return false;
	}

	/**
	 *	Create Client Directories
	 *	@param string $args
	 *	@param bool $base
	 *	@return bool $result
	 */
	public function makeClient( $args, $base = false ) {
		$file = Core::getSingleton("system/filesystem");
		$this->path = Core::$paths[0] . $args;
		if( $base ) {
			$this->path = Core::$paths[1] . $args;
		}
		if( $file->dirExist( $this->path ) ) {
			$this->error("Error: " . $args . " already exists.");
			return false;
		}

		if( $file->mkdir( strtolower($this->path) ) ) {
			$mvcPath = $this->path . DS;
			foreach( $this->dirs as $dir ) {
				$file->mkdir( $mvcPath . $dir );
			}
		}else{
			$this->error("Error: something went wrong while creating " . $args);
			return false;
		}
		$this->info("Info: " . $args . " was successfully created");
		$this->info("Path: " . $this->path);
		$this->handler([$args . "/index"]);
		return true;
	}

}