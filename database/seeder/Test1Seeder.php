<?php

Class Test1Seeder extends Database_Model_Schema {
	protected $table = 'test1';

	public function seed() {
		// column and values inside the array
		$rs = $this->insert([
			// sample
			"name" => "value"
		]);

		if(! $rs ) {
			return false;
		}

		return true;
	}
}