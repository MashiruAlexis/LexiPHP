<?php

Class Http_Controller_Url {

	public function getUrl() {
		return $_SERVER['REQUEST_URI'];
	}
}