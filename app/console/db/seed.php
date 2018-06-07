<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Db_Seed extends Console_Controller_Core {

	public $description = 'Seeder.';

	public function handler( $args = [] ) {
		$sd = $args;
		// convert argmuents
		$args = $this->extract($args);

		// check if there arguments extracted.
		if( $args and (count($args) > 0) and !empty($args['name'])) {
			// if name is specified we will seed based
			// the given arguments
			if( isset($args['name']) ) {
				if( strpos($args['name'], ',') ) {
					$seeds = explode(',', $args['name']);
				}else{
					$seeds = $args['name'];
				}				
			}

			if( is_array($seeds) ) {
				$itm = count($seeds); $prg = 0;
				foreach( $seeds as $seed ) {
					Core::getSeeder($seed)->seed();
					$this->info($seed . " seeded successfully.(" . ++$prg . "/".$itm.")" );
				}
				$this->success("All seeder run successfully.");
				return true;
			}else{
				Core::getSeeder($seeds)->seed();
				$this->info($seeds . " seeded successfully.");
				return true;
			}
		}else{
			$file = Core::getSingleton("system/filesystem");
			$path = BP . DS . "database" . DS . "seeder" . DS;
			$seeders = $file->getDirContents($path);
			if( count($seeders) < 1 ) {
				$this->error("Error: please create a seed file before running this command.");
				return false;
			}
			foreach( $seeders as $seeder ) {
				$seeder = str_replace(".php", "", $seeder);
				Core::getSeeder($seeder)->seed();
				$this->success($seeder . " successfully seeded.");
			}
			return true;
		}
		$this->error("Error: something went wrong while running this command.");
		return false;
	}
}