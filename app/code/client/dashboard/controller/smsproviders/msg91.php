<?php

/**
 *	msg91 service provider
 *	@url http://control.msg91.com/user/index.php#send_sms
 */
Class msg91 {

	/**
	 *	Send SMS
	 */
	public function send($data = []) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=611332&route=4&mobiles=63" . $data['number']. "&authkey=". $data['api'] ."&encrypt=0&country=0&message=". $data['message'] ."&flash=1&unicode=1&response=json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		if ($err) {
		  return false;
		} else {
		  return $response;
		}
	}

}