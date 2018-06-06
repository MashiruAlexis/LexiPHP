<?php

/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Console_Db_Seed extends Console_Controller_Core {

	public $description = 'New Console Command Created!';

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
				$itm = count($seeds);
				$allItm = $itm;
				foreach( $seeds as $seed ) {
					Core::getSeeder($seed)->seed();
					$this->info($seed . " seeded successfully.[" . $itm-- . "/".$allItm."]" );
				}
				$this->success("All seeder run successfully.");
				return true;
			}
		}
	}
}