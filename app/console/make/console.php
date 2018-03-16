<?php

/**
 *	Console
 */
Class Console_Make_Console extends Console_Controller_Core {

	protected $path;
	protected $templateName = "console.txt";
	protected $parent = "Console_Controller_Core";

	public function handler( $args = [] ) {
		if( empty($args) ) {
			$this->error("Error: no arguments was passed.");
			return false;
		}

		if(! isset($args[1]) ) {
			$this->error("Error: a second argument is needed.");
			return 0;
		}

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
			return 1;
		}
		return;

		$maker = Core::getSingleton("console/maker");

		

		$temp = file_get_contents($this->path);
		$temp = str_replace("{command}", ucfirst($args[0]), $temp);
		$temp = str_replace("{filename}", ucfirst($args[1]), $temp);
		$temp = str_replace("{parent}", $this->parent, $temp);
		file_put_contents("test.php", $temp);

	}
}