<?php

Class Test_Controller_Download extends Frontend_Controller_Action {

	public function indexAction() {
		$this->setPageTitle("Alcoy 2017");
		echo '
			<center><h1><u><a href="http://192.168.1.99/ALCOY2017.mp4" download>View Alcoy2017.mp4</a></u></h1></center>
		';
	}
}