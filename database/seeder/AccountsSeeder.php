<?php

Class AccountsSeeder extends Database_Model_Schema {
	protected $table = accounts;

	public function seed() {
		// column and values inside the array
		$rs = $this->insert([
			// sample
			"column" => "value"
		]);

		if(! $rs ) {
			return false;
		}

		return true;
	}
}