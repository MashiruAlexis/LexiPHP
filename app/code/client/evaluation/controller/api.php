<?php

Class Evaluation_Controller_Api extends Frontend_Controller_Action{

	public function getAdminDataAction() {
		$this->setPageTitle("Api");
		echo json_encode([
				[
					"criteria" => "Commitment",
					"value" => 10
				],
				[
					"criteria" => "Knowledge of Subject",
					"value" => 40
				],
				[
					"criteria" => "eaching for Independent Learning",
					"value" => 50
				],
				[
					"criteria" => "Management of Learning",
					"value" => 78
				],
		]);
		exit();
	}
}