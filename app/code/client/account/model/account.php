<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Account_Model_Account extends Database_Model_Base {

	/**
	 *	Table Name for this model
	 */
	protected $table = "accounts";


	/**
	 *	Get Account By Id
	 *	@param int $id
	 *	@return obj $account
	 */
	public function get( $id = false ){
		if( $id ) {
			return $this->where("id", $id)->first();
		}
		return $this->get();
	}
}