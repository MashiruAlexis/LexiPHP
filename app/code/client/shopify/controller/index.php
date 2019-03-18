<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Shopify_Controller_Index extends Frontend_Controller_Action {

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Index');
		$this->linkJs( 'http://sdks.shopifycdn.com/js-buy-sdk/v2/latest/index.umd.min.js' );
		$this->setBlock('shopify/main');
		// code here
	}
}