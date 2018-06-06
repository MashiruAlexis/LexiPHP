<?php

Class TestSeeder extends Database_Model_Schema {
	protected $table = 'test';

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