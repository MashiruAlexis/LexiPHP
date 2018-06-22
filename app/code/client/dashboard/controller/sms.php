<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Sms extends Frontend_Controller_Action {

	# sms api key
	private $apikey = '219445AipM5X4lb3su5b19961f';

	public function __construct() {
		Core::middleware('auth');
	}

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle('Sms');
		$this->setBlock("dashboard/sms");
	}

	/**
	 *	Send Message
	 */
	public function sendAction() {
		$data = Core::getSingleton("url/request")->getPost();
		$next = Core::getBaseUrl() . 'dashboard/sms';

		# check if this is a 10 digit number
		if( strlen($data['number']) !== 10 ) {
			Core::alert([
				"type" => "warning", 
				"msg" => "You enter 10 digit number."
			]);
			$this->_redirect($next, $data);
		}

		# set the min message to be sent.
		if( strlen($data['message']) < 9 ) {
			Core::alert([
				"type" => "warning", 
				"msg" => "Your message must not be less 10 digit number."
			]);
			$this->_redirect($next, $data);
		}

		$sms = Core::getSingleton("dashboard/smscore");
		$rs = $sms->setApiKey('219445AipM5X4lb3su5b19961f')
			->setProvider('msg91')
			->setReceiver($data['number'])
			->setMessage($data['message'])
			->send();

		if(! $rs ) {
			Core::alert([
				"type" => "error", 
				"msg" => "Something went while sending you message."
			]);
			$this->_redirect($next, $data);
		}

		# save the current tansaction
		Core::getModel("dashboard/sms")->insert([
			'senderId' => $_SESSION['account']->id,
			"receiver" => $data['number'],
			"message" => $data['message'],
			"response" => $rs
		]);

		Core::alert([
				"type" => "success", 
				"msg" => "Message Sent!"
			]);
		$this->_redirect($next);
		return;
	}
}