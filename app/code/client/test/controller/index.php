<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Test_Controller_Index extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Test');
		echo '
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQKdd8Te1vj2OyjfP1H9NPIz4DrxXO4iQ&callback=initMap"
  type="text/javascript"></script>';
	}
}