<?php

/**
 *	JSON Encoder
 *	@author Ramon Alexis Celis
 */

Class Encode_Controller_Json {

	public function encode($varJson) {
		return json_encode($varJson);
	}
}