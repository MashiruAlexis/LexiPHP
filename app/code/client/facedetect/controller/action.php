<?php

Class Facedetect_Controller_Action extends Frontend_Controller_Action {

	public function index() {

		$this->setPageTitle("Face Recognation");
		$this->setJs("facedetect/detection");
		$this->setBlock("facedetect/main");
		$this->render();
	}
}