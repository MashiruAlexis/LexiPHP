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

		if(! isset($args[1]) ) {
			$this->error("Error: a second argument is needed for this command.");
			return;
		}

		$file = Core::getSingleton("system/filesystem");

		$this->controllerPath = Core::$paths[0];
		$this->templatePath = dirname(__FILE__) . DS . "template" . DS;
		$template = $this->templatePath . $this->templateFilename;

		if(! $file->dirExist( $this->controllerPath . $args[0] ) ) {
			$this->error("Error: please create a client first.");
			$this->info("Info: run this command php lexi make:client clientname");
			return false;
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
			file_put_contents($controllerFilePath, $template);
			if( file_exists($controllerFilePath) ) {
				$this->info($args[1] . " controller was successfully created.");
				return true;
			}
			$this->error("Error: something went wrong while creating " . $args[1] );
		}
		return false;
	}

}