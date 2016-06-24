<?php

Class Chromenoti_Controller_Action extends Frontend_Controller_Action {

	public function index() {
		$this->setPageTitle("Chrome Notification");
		$this->setBlock("chromenoti/main");
		$this->linkCSs("//cdn.jsdelivr.net/sweetalert2/4.0.3/sweetalert2.min.css");
		$this->linkJs("//cdn.jsdelivr.net/sweetalert2/4.0.3/sweetalert2.min.js");
		$this->render();
	}
}