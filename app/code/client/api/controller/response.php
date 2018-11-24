<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Api_Controller_Response extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Response');
		// code here
	}

	/**
	 *	make api response to the client
	 *	@param obj|array $data
	 *	@return json
	 */
	public function response( $data ) {
		header('Content-Type: application/json');
		echo json_encode($data);
		exit();
	}
}