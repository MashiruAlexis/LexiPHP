<?php

/**
 *	Creates a response for api calls
 */
Class Response {

	public static $result = [
		'type' => 'success',
		'message' => 'request successfully delivered.'
	];

	/**
	 *	Create json response
	 *	@param array $data
	 *	@return json $data
	 */
	public static function json( $data = [] ) {
		# check if the data recieved is an array
		if(! is_array($data) ) {
			self::$result['type'] = 'error';
			self::$result['message'] = "Something went wrong processing your request.";
		}

		self::$result['data'] = $data;
		echo json_encode(self::$result);
		exit(); # kill 
	}


}