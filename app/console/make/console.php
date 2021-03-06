<?php

/**
 *	Console
 */
Class Console_Make_Console extends Console_Controller_Core {

	public $description = "Create console command.";
	protected $path;
	protected $templateName = "console.txt";
	protected $parent = "Console_Controller_Core";

	public function handler( $args = [] ) {
		if( empty($args) ) {
			$this->error("Error: no arguments was passed.");
			return false;
		}

		$args = explode(":", $args[0]);
		$key1 = strtolower($args[0]);
		$key2 = strtolower($args[1]);

		$this->path = dirname(__FILE__) . DS . "template" . DS .$this->templateName;
		if(! file_exists($this->path) ) {
			$this->error("Error: template file is missing, you have to create console manually.");
			return false;
		}

		$setup = [
			"key1" => $key1,
			"key2" => $key2,
			"parent" => $this->parent,
			"template" => $this->path,
			"path" => $this->getConsolePath() . $key1 . DS,
			"filename" => $key2 . '.php' 
		];

		if( file_exists($setup['path'] . $setup['key2'] . '.php') ) {
			$this->error("Error: this command already exists.");
			return false;
		}

		if( new Console_Controller_Maker($setup) ) {
			$this->success("Maker Success");
			$this->info("to test run: php lexi $key1:$key2");
			return 1;
		}
		return true;
	}
}