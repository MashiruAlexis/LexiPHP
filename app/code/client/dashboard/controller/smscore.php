<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Smscore extends Frontend_Controller_Action {
	# api url
	public $url;

	# sms api provider
	public $provider;

	# api key
	protected $api;

	# receiver number
	private $receiver;

	# message
	protected $message;

	/**
	 *	set message
	 *	@param string $msg
	 *	@return $this
	 */
	public function setMessage( $msg ) {
		$this->message = $msg;
		return $this;
	}

	/**
	 *	set api url
	 *	@param string $url
	 *	@return obj $this
	 */
	public function setUrl( $url ) {
		$this->url = $url;
		return $this;
	}

	/**
	 *	set the receiver number
	 *	@param int $number
	 *	@return obj $this
	 */
	public function setReceiver( $number ) {
		$this->receiver = $number;
		return $this;
	}

	/**
	 *	set the sms api provider
	 *	@param string $provider
	 *	@retun obj $this
	 */
	public function setProvider( $provider ) {
		$this->provider = $provider;
		return $this;
	}

	/**
	 *	set the sms key
	 *	@param string $key
	 *	@return obj $this
	 */
	public function setApiKey( $key ) {
		$this->api = $key;
		return $this;
	}

	/**
	 *	send sms
	 *	@return bool
	 */
	public function send() {
		# path to provider
		$provider  = dirname(__FILE__) . DS . 'smsproviders' . DS . $this->provider . '.php';

		# lets check if the provider is supported
		if(! file_exists($provider) ) {
			return false;
		}
		
		require $provider;
		$provider = new $this->provider;

		# provider needed data
		$data = [
			'api' => $this->api,
			'number' => $this->receiver,
			'message' => $this->message
		];

		# send SMS
		$rs = $provider->send($data);

		# check if the sms was successfuly sent
		if(! $rs ) {
			return false;
		}

		return $rs;
	}
}